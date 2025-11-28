<?php

namespace App\Livewire\Exam;

use App\Enums\status;
use App\Models\ApplicantTestAttempt;
use App\Models\ExamClientEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.exam')]
#[Title('Ujian')]
class ExamShow extends Component
{
    public ApplicantTestAttempt $attempt;

    public Collection $attemptQuestions;

    /** Index soal yang sedang aktif (0-based) */
    public int $index = 0;

    /**
     * Jawaban user, keyed by question_id.
     * - multiple_choice / true_false: string (choice_label)
     * - essay: string
     * - fill_in_blank: array of strings (sementara)
     * - matching: array of pair [['left'=>..., 'right'=>...], ...] (sementara)
     */
    #[Session('answers')]
    public array $answers = [];

    public function mount(int $startIndex = 0): void
    {
        $this->attempt = $this->attempt->load([
            'attemptQuestions' => function ($q) {
                $q->orderBy('order_index');
            },
            'attemptQuestions.question.choices',
        ]);

        $this->attemptQuestions = $this->attempt->attemptQuestions;

        // Set index awal (aman-kan range)
        $this->index = max(0, min($startIndex, $this->attemptQuestions->count() - 1));

        // Prefill jawaban jika sudah ada (sesuaikan dengan relasi mu jika ada)
        // Contoh jika punya relasi $attempt->answers: [question_id => value]
        if (method_exists($this->attempt, 'answers')) {
            $prefill = $this->attempt->answers()
                ->get()
                ->mapWithKeys(function ($row) {
                    // Normalisasi: simpan value string/json -> array sesuai tipe
                    return [$row->question_id => $row->value_normalized]; // sesuaikan accessor
                })
                ->toArray();

            $this->answers = array_replace($this->answers, $prefill);
        }
    }

    public function getCurrentAttemptQuestionProperty()
    {
        return $this->attemptQuestions[$this->index] ?? null;
    }

    public function getCurrentQuestionProperty()
    {
        return optional($this->currentAttemptQuestion)->question;
    }

    public function selectIndex(int $i): void
    {
        if ($i >= 0 && $i < $this->attemptQuestions->count()) {
            $this->index = $i;
        }
    }

    public function next(): void
    {
        if ($this->index < $this->attemptQuestions->count() - 1) {
            $this->index++;
        }
    }

    public function prev(): void
    {
        if ($this->index > 0) {
            $this->index--;
        }
    }

    /** Simpan jawaban ke array lokal (dan opsional persist ke DB) */
    public function setAnswer(string $questionId, $value): void
    {
        $this->answers[$questionId] = $value;

        // $this->persistSingle($questionId, $value);
    }

    /** Contoh persist satu jawaban (sesuaikan dg schema mu) */
    protected function persistSingle(string $questionId, $value): void
    {
        // Misal table applicant_test_attempt_answers: attempt_id, question_id, value(json/string)
        // \App\Models\ApplicantTestAttemptAnswer::updateOrCreate(
        //     ['attempt_id' => $this->attempt->id, 'question_id' => $questionId],
        //     ['value' => is_array($value) ? json_encode($value) : $value]
        // );
    }

    protected function saveAnswer($status, $endedReason, $totalScore)
    {
        $attempt = $this->attempt->fresh(['applicantTest']); // pastikan segar

        // Guard: kalau bukan in_progress, langsung keluar
        if ($attempt->status !== status::in_progress) {
            // throw new \RuntimeException('Attempt tidak aktif.');
            $jobVacancyTestId = (string) session('jobVacancyTestId');
            // return redirect()->route('exam.index', $jobVacancyTestId);

            return redirect()
                ->route('exam.index', $jobVacancyTestId)
                ->withErrors(['test_alert' => 'Attempt tidak aktif atau waktu sudah habis.']);
        }

        $now = now();

        // 1) Ambil semua question_id yang memang termasuk attempt ini (agar pasti konsisten)
        $questionIds = DB::table('applicant_attempt_questions')
            ->where('applicant_test_attempt_id', $attempt->id)
            ->orderBy('order_index')
            ->pluck('question_id')
            ->all();

        if (empty($questionIds)) {
            throw new \RuntimeException('Daftar soal untuk attempt ini tidak ditemukan.');
        }

        // 2) Prefetch semua pertanyaan & semua pilihan (hindari N+1)
        $questions = \App\Models\Question::with(['choices' => function ($q) {
            $q->select('id', 'question_id', 'choice_label', 'is_correct');
        }])
            ->whereIn('id', $questionIds)
            ->get(['id', 'type', 'points'])
            ->keyBy('id');

        // Map jawaban user dari $this->answers (array: [question_id => value])
        // value bisa "A"/"B" untuk MC/TF, string untuk essay, array/json utk fill_in/matching
        $userAnswers = collect($this->answers ?? []);

        $rows = [];
        $totalScore = 0;
        // dd($questions);
        foreach ($questionIds as $qid) {
            /** @var \App\Models\Question|null $q */
            $q = $questions->get($qid);
            if (! $q) {
                // Skip atau lempar error—pilih kebijakanmu
                continue;
            }

            $value = $userAnswers->get($qid, null);

            $selectedChoiceId = null;
            $isCorrect = null;
            $score = null;
            $answerText = null;
            $answerJson = null;

            switch ($q->type->value) {
                case 'multiple_choice':
                case 'true_false':
                    // value diharapkan label: 'A','B',dst. Cari choice berdasarkan label
                    $selected = optional($q->choices->firstWhere('choice_label', $value));
                    $correct = optional($q->choices->firstWhere('is_correct', true));

                    $selectedChoiceId = $selected?->id;

                    if ($selectedChoiceId && $correct->id) {
                        $isCorrect = $selectedChoiceId === $correct->id;
                        $score = $isCorrect ? ($q->points ?? 0) : 0; // kebijakan: salah = 0
                    } else {
                        // tidak menjawab → 0 atau null sesuai kebijakan
                        $isCorrect = null;
                        $score = 0;
                    }
                    break;

                case 'essay':
                    // nilai manual (null), simpan teks apa adanya
                    $answerText = is_scalar($value) ? (string) $value : null;
                    $score = null;
                    $isCorrect = null;
                    break;

                case 'fill_in_blank':
                case 'matching':
                    // Simpan dalam JSON
                    $answerJson = $value ? json_encode($value, JSON_UNESCAPED_UNICODE) : null;
                    $score = null;   // biasanya dinilai belakangan / auto-grade kustom
                    $isCorrect = null;
                    break;

            }

            $rows[] = [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'applicant_test_attempt_id' => $attempt->id,
                'question_id' => $qid,
                'selected_choice_id' => $selectedChoiceId,
                'answer_text' => $answerText,
                'answer_json' => $answerJson,
                'is_correct' => $isCorrect,
                'score' => $score,
                'answered_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (is_numeric($score)) {
                $totalScore += (float) $score;
            }
        }

        $this->updateAttempt($status, $endedReason, $totalScore);

        // dd($rows);
        // 3) Upsert jawaban (kalau sudah ada sebagian jawaban tidak dobel)
        //    pastikan ada unique index di (applicant_test_attempt_id, question_id)
        if (! empty($rows)) {
            \App\Models\ApplicantAnswer::upsert(
                $rows,
                ['applicant_test_attempt_id', 'question_id'],
                ['selected_choice_id', 'answer_text', 'answer_json', 'is_correct', 'score', 'answered_at', 'updated_at']
            );
        }
    }

    protected function updateAttempt($status, $endedReason, $totalScore)
    {
        // 4) Tutup attempt: expired (timeout)
        $attempt = $this->attempt;
        $now = now();

        $attempt->update([
            'status' => $status,
            'ended_reason' => $endedReason,
            'submitted_at' => $now,
            'score' => $totalScore,
            'updated_at' => $now,
        ]);

        // 5) Agregasi ke level paket (optional tapi disarankan)
        $sum = \App\Models\ApplicantTestAttempt::where('applicant_test_id', $attempt->applicant_test_id)
            ->sum('score');

        $attempt->applicantTest()->update([
            'total_score' => $sum,
            // opsional: set status completed jika SEMUA attempt item tidak ada yang in_progress
            // 'status' => $this->allItemsClosed($attempt->applicant_test_id) ? 'completed' : DB::raw('status'),
        ]);

        // 6) Bersihkan session yang terkait tes
        session()->forget([
            'test_applicant_test_id',
            'test_attempt_id',
            'answers',
        ]);
    }

    #[On('test-timeout')]
    public function timeout()
    {
        DB::beginTransaction();

        try {
            $attempt = $this->attempt;
            $this->saveAnswer('expired', 'timeout', null);

            DB::commit();

            // redirect ke halaman daftar paket / ringkasan
            $jobVacancyTestId = (string) session('jobVacancyTestId'); // jika memang diset waktu awal

            return redirect()->route('exam.index', $jobVacancyTestId);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    #[On('end-test')]
    public function endTest()
    {
        $this->submitAll();
    }

    #[On('force-submit-exam')]
    public function forceSubmit()
    {
        $this->submitAll();
    }

    /** Submit semua jawaban (opsional) */
    public function submitAll()
    {
        DB::beginTransaction();

        try {
            $attempt = $this->attempt;
            $this->saveAnswer('submitted', 'submitted', null);

            DB::commit();

            if (session()->exists('users')) {
                $this->reset('answers'); // reset nilai property Livewire
                session()->forget('answers'); // hapus dari session Laravel
            }

            // redirect ke halaman daftar paket / ringkasan
            $jobVacancyTestId = (string) session('jobVacancyTestId'); // jika memang diset waktu awal
            // return redirect()->route('exam.index', $jobVacancyTestId);

            $url = route('exam.index', $jobVacancyTestId);
            $this->dispatch('submitTest', url: $url);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    #[On('exam-client-event')]
    public function logClientEvent($name, $at = null)
    {
        // $this->dispatch('notification', type: 'error', title: 'Hati-hati!', message: 'Anda terdeteksi melakukan pelanggaran!', timeout: 3000);
        ExamClientEvent::create([
            'id' => (string) Str::uuid(),
            'applicant_test_id' => $this->attempt->applicant_test_id,
            'job_vacancy_test_item_id' => $this->attempt->job_vacancy_test_item_id,
            'event' => $name ?? 'unknown',
            'meta' => json_encode(['at' => $event['at'] ?? now()->toIso8601String(), 'ua' => request()->userAgent(), 'ip' => request()->ip()]),
        ]);

        // Ambang auto-terminate dari server (tambahan)
        $violationsCount = ExamClientEvent::query()
            ->where('applicant_test_id', $this->attempt->applicant_test_id)
            ->where('job_vacancy_test_item_id', $this->attempt->job_vacancy_test_item_id)
            // ->whereIn('event', ['focus_lost_blur', 'focus_lost_visibilitychange', 'devtools_open', 'multi_window_detected'])
            ->count();
        // ds($violationsCount);
        // if ($violationsCount >= 5) {
        //     $this->submitAll();
        // }
    }

    public function render()
    {
        // ds(count($this->attemptQuestions->toArray()) == count($this->answers));
        return view('livewire.exam.exam-show');
    }
}
