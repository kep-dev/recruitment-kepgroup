<?php

namespace App\Livewire\Exam;

use App\Models\ApplicantTest;
use App\Models\ApplicantTestAttempt;
use App\Models\JobVacancyTest;
use App\Models\JobVacancyTestItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.exam')]
#[Title('Ujian | Recruitment KEP Group')]
class ExamIndex extends Component
{
    public JobVacancyTest $JobVacancyTest;

    public $attempt;

    public function mount()
    {
        $accessToken = session('user_'.Auth::user()->id.'_token');
        // 1) Validasi token & ambil paket
        $nowDb = DB::raw('CURRENT_TIMESTAMP');
        $this->attempt = ApplicantTest::query()
            ->where('access_token', $accessToken)
            ->where('status', '!=', 'expired')
            ->whereHas('jobVacancyTest', function ($q) use ($nowDb) {
                $q->where('is_active', 1)
                    ->where(function ($q) use ($nowDb) {
                        $q->whereNull('active_from')
                            ->orWhere('active_from', '<=', $nowDb);
                    })
                    ->where(function ($q) use ($nowDb) {
                        $q->whereNull('active_until')
                            ->orWhere('active_until', '>=', $nowDb);
                    });
                // ->whereNull('deleted_at'); // kalau pakai SoftDeletes
            })
            ->first();

        // if (!$at) {
        //     throw new \Exception('Token tidak valid / paket tidak aktif.');
        // }
    }

    public function startAttemptByToken(string $jobVacancyTestItemId)
    {
        $accessToken = session('user_'.Auth::user()->id.'_token');
        DB::beginTransaction();
        try {
            $at = $this->attempt;
            // 2) Ambil item yang dipilih (jumlah soal ditentukan di sini)
            $item = JobVacancyTestItem::with('test')
                ->select('id', 'test_id', 'number_of_question', 'duration_in_minutes', 'order')
                ->find($jobVacancyTestItemId);

            if (! $item) {
                throw new \Exception('Item tes tidak ditemukan!');
            }

            $nextId = $this->nextAllowedItemId($at->id, $at->job_vacancy_test_id);
            // dd($nextId);
            abort_if($item->id !== $nextId, 403, 'Selesaikan bagian sebelumnya dulu.');

            // 3) Cek attempt existing
            $attempt = DB::table('applicant_test_attempts')
                ->where('applicant_test_id', $at->id)
                ->where('job_vacancy_test_item_id', $item->id)
                ->lockForUpdate()
                ->first();

            if ($attempt) {
                // blokir kalau sudah submitted/graded/expired
                if (in_array($attempt->status, ['submitted', 'graded', 'expired'])) {
                    throw new \Exception('Tes ini sudah tidak bisa dikerjakan.');
                }
                // kalau masih in_progress tapi sudah lewat deadline → expire
                if ($attempt->deadline_at && now()->greaterThan(Carbon::parse($attempt->deadline_at))) {
                    DB::table('applicant_test_attempts')->where('id', $attempt->id)
                        ->update(['status' => 'expired', 'ended_reason' => 'timeout', 'updated_at' => now()]);
                    throw new \Exception('Waktu tes telah habis.');
                }

                return redirect()->route('exam.show', $attempt->id);
                // return $attempt->id; // lanjutkan attempt lama
            }

            // 4) Hitung deadline berdasarkan duration + window paket
            $duration = $item->duration_in_minutes;
            $deadline = now()->addMinutes($duration);

            $activeUntil = DB::table('job_vacancy_tests')
                ->where('id', $at->job_vacancy_test_id)
                ->value('active_until');

            if ($activeUntil) {
                $deadline = $deadline->min(Carbon::parse($activeUntil));
            }

            // 5) Buat attempt baru
            $attemptId = (string) Str::uuid();
            $seed = random_int(1, PHP_INT_MAX);

            $applicantTestAttempt = ApplicantTestAttempt::query()
                ->where('applicant_test_id', $at->id)
                ->where('job_vacancy_test_item_id', $item->id)
                ->where('test_id', $item->test_id)
                ->first();

            if ($applicantTestAttempt) {
                return redirect()->route('exam.show', $applicantTestAttempt->id);
            }

            DB::table('applicant_test_attempts')->insert([
                'id' => $attemptId,
                'applicant_test_id' => $at->id,
                'job_vacancy_test_item_id' => $item->id,
                'test_id' => $item->test_id,
                'attempt_no' => $item->order,
                'status' => 'in_progress',
                'score' => null,
                'started_at' => now(),
                'deadline_at' => $deadline,
                'submitted_at' => null,
                'random_seed' => $seed,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 6) Ambil N soal acak dari bank
            $questionIds = DB::table('questions')
                ->where('test_id', $item->test_id)
                ->inRandomOrder()
                ->limit($item->number_of_question)
                ->pluck('id')
                ->all();

            if (count($questionIds) < (int) $item->number_of_question) {
                // terserah kebijakan: lanjut dengan yang tersedia atau tolak
                // throw new TestAttemptNotAllowedException('Jumlah soal tidak mencukupi.');
            }

            // 7) Simpan mapping soal terpilih
            $rows = [];
            $i = 1;
            foreach ($questionIds as $qid) {
                $rows[] = [
                    'id' => (string) Str::uuid(),
                    'applicant_test_attempt_id' => $attemptId,
                    'question_id' => $qid,
                    'order_index' => $i++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if ($rows) {
                DB::table('applicant_attempt_questions')->insert($rows);
            }

            // $at->update([
            //     'status' => 'in_progress',
            //     'started_at' => now(),
            // ]);

            session()->put('test_applicant_test_id', $at->id);
            session()->put('test_attempt_id', $attemptId);
            session()->put('test_lock', true);

            DB::commit();

            return redirect()->route('exam.show', $attemptId);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function endTest()
    {
        try {
            $accessToken = session('user_'.auth()->user()->id.'_token');
            $jobVacancyTestId = (string) session('jobVacancyTestId');

            $at = ApplicantTest::query()
                ->where('access_token', $accessToken)
                ->where('job_vacancy_test_id', $jobVacancyTestId)
                ->first();
            // ds($at);
            if (! $at) {
                throw new \Exception('Tidak dapat mengakhiri test.');
            }

            $at->update([
                'completed_at' => now(),
                'status' => 'completed',
            ]);

            session()->forget([
                'test_applicant_test_id',
                'test_attempt_id',
                'jobVacancyTestId',
                'test_lock',
                'user_'.auth()->user()->id.'_token',
            ]);

            // return redirect()->route('frontend.profile.test');
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);

            return redirect()->back();
        }
    }

    #[Computed()]
    public function testItems()
    {
        $accessToken = session('user_'.Auth::user()->id.'_token');
        $nowDb = DB::raw('CURRENT_TIMESTAMP');
        $at = $this->attempt;

        $applicantTestAttempts = $at->attempts->pluck('job_vacancy_test_item_id')->toArray();

        return JobVacancyTestItem::query()
            // ->whereNotIn('id', $applicantTestAttempts)
            ->whereBelongsTo($this->JobVacancyTest)
            ->orderBy('order')
            ->get();
    }

    protected function nextAllowedItemId(string $applicantTestId, string $jobVacancyTestId): ?string
    {
        // 1) Ambil order terbesar yang sudah selesai (submitted/graded)
        $maxFinishedOrder = JobVacancyTestItem::query()
            ->where('job_vacancy_test_id', $jobVacancyTestId)
            ->whereHas('finishedAttempts', function ($q) use ($applicantTestId) {
                $q->where('applicant_test_id', $applicantTestId);
            })
            ->max('order');

        $nextOrder = (int) $maxFinishedOrder + 1;

        // 2) Ambil ID item dengan order berikutnya
        return JobVacancyTestItem::query()
            ->where('job_vacancy_test_id', $jobVacancyTestId)
            ->where('order', $nextOrder)
            ->value('id'); // null jika semua item sudah selesai
    }

    public function render()
    {
        // dump([
        //     $locked            = session('test_lock'),
        //     $attemptId         = (string) session('test_attempt_id'),
        //     $test         = (string) session('test_applicant_test_id'),
        //     $jobVacancyTestId  = (string) session('jobVacancyTestId'),
        // ]);
        // session()->flush();
        $applicantTestAttempts = $this->attempt->attempts
            ->whereNotIn('status', ['submitted', 'graded', 'expired'])
            ->pluck('job_vacancy_test_item_id')->toArray();

        // dd($applicantTestAttempts);

        return view('livewire.exam.exam-index', compact('applicantTestAttempts'));
    }
}
