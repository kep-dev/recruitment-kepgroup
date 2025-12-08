<?php

namespace App\Livewire\Exam;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use App\Services\PsychotestScoringService;
use App\Models\Psychotest\PsychotestAnswer;
use App\Models\Psychotest\PsychotestAttempt;

#[Layout('components.layouts.exam')]
#[Title('Ujian Psikotest | Recruitment KEP Group')]
class PsychotestExamShow extends Component
{
    public string $attemptId;

    public PsychotestAttempt $attempt;

    /** @var \Illuminate\Support\Collection<int,\App\Models\PsychotestQuestion> */
    // public Collection $questions;

    public int $currentIndex = 0;

    public int $totalQuestions = 0;

    public ?string $selectedOptionId = null;


    /** @var array<string,string|null> [question_id => option_id] */
    public array $answerMap = [];

    protected $rules = [
        'selectedOptionId' => 'required|uuid',
    ];

    protected $messages = [
        'selectedOptionId.required' => 'Silakan pilih salah satu pernyataan terlebih dahulu.',
    ];

    public function mount(string $attemptId): void
    {
        $this->attemptId = $attemptId;

        $this->attempt = PsychotestAttempt::with([
            'form.questions.options',
            'answers',
        ])->findOrFail($attemptId);

        // $this->questions = $this->attempt->form
        //     ->questions
        //     ->sortBy('number')
        //     ->values();

        $this->totalQuestions = $this->questions->count();


        $this->currentIndex = 0;
        $this->buildAnswerMap();   // <-- ini
        $this->loadSelectedOption();
    }

    protected function buildAnswerMap(): void
    {
        $this->answerMap = $this->attempt
            ->answers
            ->pluck('option_id', 'question_id')
            ->toArray();
    }

    public function selectIndex(int $index): void
    {
        if ($index < 0 || $index >= $this->totalQuestions) {
            return;
        }

        $this->resetErrorBag();

        $this->currentIndex = $index;
        $this->loadSelectedOption();
    }

    #[Computed(persist: true, seconds: 3600, cache: true)]
    public function questions(): Collection
    {
        return  $this->attempt->form
            ->questions
            ->sortBy('number')
            ->values();
    }

    public function selectOption(string $optionId): void
    {
        $this->selectedOptionId = $optionId;

        // Simpan langsung ke DB
        $this->saveCurrentAnswer();
    }

    public function getCurrentQuestionProperty()
    {
        return $this->questions[$this->currentIndex] ?? null;
    }

    public function getCurrentNumberProperty(): int
    {
        return $this->currentIndex + 1;
    }

    protected function loadSelectedOption(): void
    {
        $question = $this->currentQuestion;

        if (! $question) {
            $this->selectedOptionId = null;

            return;
        }

        $answer = $this->attempt
            ->answers
            ->firstWhere('question_id', $question->id);

        $this->selectedOptionId = $answer?->option_id;
    }

    protected function saveCurrentAnswer(): void
    {
        $this->validate(); // boleh dipertahankan jika memang wajib isi sebelum lanjut

        $question = $this->currentQuestion;

        if (! $question) {
            return;
        }

        PsychotestAnswer::updateOrCreate(
            [
                'attempt_id'  => $this->attempt->id,
                'question_id' => $question->id,
            ],
            [
                'option_id' => $this->selectedOptionId,
            ],
        );

        // reload jawaban untuk navigator & loadSelectedOption
        $this->attempt->load('answers');
        $this->buildAnswerMap();
    }

    public function goToPrev(): void
    {
        if ($this->currentIndex <= 0) {
            return;
        }

        $this->resetErrorBag();
        $this->currentIndex--;
        $this->loadSelectedOption();
    }

    public function saveAndNext(): void
    {
        // validasi minimal: harus pilih dulu
        if (! $this->selectedOptionId) {
            $this->addError('selectedOptionId', 'Silakan pilih salah satu pernyataan terlebih dahulu.');
            return;
        }

        // (opsional) kamu bisa panggil saveCurrentAnswer() lagi di sini
        // kalau mau ekstra aman, tapi sebenarnya sudah disimpan di selectOption()

        if ($this->currentIndex < $this->totalQuestions - 1) {
            $this->currentIndex++;
            $this->resetErrorBag();
            $this->loadSelectedOption();
            return;
        }

        // terakhir → selesai
        $this->finishAttempt();
    }

    public function finishAttempt()
    {
        // Pastikan jawaban terakhir (jika ada) tersimpan
        $this->saveCurrentAnswer();

        // Hitung total soal
        $totalQuestions = $this->questions->count();

        // Hitung total jawaban yang tersimpan untuk attempt ini
        $answeredCount = $this->attempt->answers()->count();

        // VALIDASI: Jika ada soal belum dijawab → stop!
        if ($answeredCount < $totalQuestions) {

            $this->dispatch(
                'notification',
                type: 'error',
                title: 'Gagal Submit!',
                message: "Masih ada soal yang belum Anda jawab. Harap jawab semua soal sebelum menyelesaikan tes.",
                timeout: 4000
            );

            return; // Hentikan proses submit
        }

        // Kalau semua soal sudah terjawab → update status attempt
        $this->attempt->update([
            'status'       => 'submitted',
            'completed_at' => now(),
            'ended_reason' => 'submitted',
        ]);

        // Hitung skor
        app(PsychotestScoringService::class)->calculate($this->attempt);

        // Notifikasi sukses
        $this->dispatch(
            'notification',
            type: 'success',
            title: 'Selamat!',
            message: "Psikotest selesai dikerjakan.",
            timeout: 3000
        );

        // Redirect ke halaman list test
        return redirect()->route('frontend.profile.psikotest.index', $this->attempt->applicant_test_id);
    }

    public function render()
    {
        return view('livewire.exam.psychotest-exam-show');
    }
}
