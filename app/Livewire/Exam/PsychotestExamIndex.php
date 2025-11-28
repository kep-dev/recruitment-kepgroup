<?php

namespace App\Livewire\Exam;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\ApplicantTest;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use App\Models\JobVacancyPsychotestForm;
use App\Models\Psychotest\PsychotestAttempt;

#[Layout('components.layouts.exam')]
#[Title('Ujian Psikotest | Recruitment KEP Group')]
class PsychotestExamIndex extends Component
{
    public ?ApplicantTest $applicantTest;
    public array $attempts = [];

    public function mount()
    {
        $this->attempts = $this->applicantTest->psychotestAttempts()
            ->whereIn('status', ['submitted', 'graded', 'expired'])
            ->pluck('form_id')->toArray();
    }

    #[Computed()]
    public function testItems()
    {
        return JobVacancyPsychotestForm::query()
            ->where('job_vacancy_test_id', $this->applicantTest->job_vacancy_test_id)
            ->get();
    }

    protected function nextAllowedItemId(string $applicantTestId, string $jobVacancyTestId): ?string
    {
        // 1) Ambil order terbesar yang sudah selesai (submitted/graded)
        $maxFinishedOrder = JobVacancyPsychotestForm::query()
            ->where('job_vacancy_test_id', $jobVacancyTestId)
            ->whereHas('finishedAttempts', function ($q) use ($applicantTestId) {
                $q->where('applicant_test_id', $applicantTestId);
            })
            ->max('order');

        $nextOrder = (int) $maxFinishedOrder + 1;

        // 2) Ambil ID item dengan order berikutnya
        return JobVacancyPsychotestForm::query()
            ->where('job_vacancy_test_id', $jobVacancyTestId)
            ->where('order', $nextOrder)
            ->value('id'); // null jika semua item sudah selesai
    }

    public function startTest($JobVacancyPsychotestFormId, $psychotestFormId)
    {
        // dd([
        //     $JobVacancyPsychotestFormId,
        //     $psychotestFormId
        // ]);

        DB::beginTransaction();
        try {
            $applicantTestId = $this->applicantTest->id;
            $jobVacancyTestId = $this->applicantTest->job_vacancy_test_id;

            $item = JobVacancyPsychotestForm::with('jobVacancyTest')
                ->select('id', 'job_vacancy_test_id', 'psychotest_form_id', 'duration_minutes', 'order')
                ->find($JobVacancyPsychotestFormId);

            if (! $item) {
                throw new \Exception('Item tes tidak ditemukan!');
            }

            $nextId = $this->nextAllowedItemId($applicantTestId, $jobVacancyTestId);

            abort_if($item->id !== $nextId, 403, 'Selesaikan bagian sebelumnya dulu.');

            $attempt = DB::table('psychotest_attempts')
                ->where('applicant_test_id', $applicantTestId)
                ->where('form_id', $item->psychotest_form_id)
                ->lockForUpdate()
                ->first();

            if ($attempt) {
                // blokir kalau sudah submitted/graded/expired
                if (in_array($attempt->status, ['submitted', 'graded', 'expired'])) {
                    throw new \Exception('Tes ini sudah tidak bisa dikerjakan.');
                }
                // kalau masih in_progress tapi sudah lewat deadline → expire
                if ($attempt->deadline_at && now()->greaterThan(Carbon::parse($attempt->deadline_at))) {
                    DB::table('psychotest_attempts')->where('id', $attempt->id)
                        ->update(['status' => 'expired', 'ended_reason' => 'timeout', 'updated_at' => now()]);
                    throw new \Exception('Waktu tes telah habis.');
                }

                return redirect()->route('frontend.profile.psikotest.show', $attempt);
                // return $attempt->id; // lanjutkan attempt lama
            }


            // 4) Hitung deadline berdasarkan duration + window paket
            $duration = $item->duration_minutes;
            $deadline = now()->addMinutes($duration);

            $activeUntil = DB::table('job_vacancy_tests')
                ->where('id', $this->applicantTest->job_vacancy_test_id)
                ->value('active_until');

            if ($activeUntil) {
                $deadline = $deadline->min(Carbon::parse($activeUntil));
            }

            // 5) Buat attempt baru
            $attemptId = (string) Str::uuid();
            $seed = random_int(1, PHP_INT_MAX);

            $applicantTestAttempt = PsychotestAttempt::query()
                ->where('applicant_test_id', $applicantTestId)
                ->where('form_id', $item->psychotest_form_id)
                ->first();

            if ($applicantTestAttempt) {
                return redirect()->route('frontend.profile.psikotest.show', $applicantTestAttempt);
            }
            // dd($attemptId);

            $newAttempt = PsychotestAttempt::create([
                // 'id' => $attemptId,
                'form_id' => $psychotestFormId,
                'applicant_test_id' => $applicantTestId,
                'status' => 'in_progress',
                'started_at' => now(),
                'completed_at' => null,
                'attempt_no' => $item->order,
                'score' => null,
                'deadline_at' => $deadline,
            ]);

            // dd($newAttempt);
            DB::commit();
            return redirect()->route('frontend.profile.psikotest.show', $newAttempt->id);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function endTest()
    {
        try {
            $applicantTest = $this->applicantTest;

            if (! $applicantTest) {
                throw new \Exception('Tidak dapat mengakhiri test.');
            }

            $applicantTest->update([
                'completed_at' => now(),
                'status' => 'completed',
            ]);

            // session()->forget([
            //     'test_applicant_test_id',
            //     'test_attempt_id',
            //     'jobVacancyTestId',
            //     'test_lock',
            //     'user_'.auth()->user()->id.'_token',
            // ]);

            return redirect()->route('frontend.profile');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);

            return redirect()->back();
        }
    }


    public function render()
    {
        // dd($this->testItems());

        // dd($this->attempts);
        return view('livewire.exam.psychotest-exam-index');
    }
}
