<?php

namespace App\Filament\Pages;

use App\Models\ApplicantAnswer;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\ApplicantTest;
use Livewire\Attributes\Computed;
use App\Models\ApplicantTestAttempt;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ApplicantTestAttemptPage extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected string $view = 'filament.pages.applicant-test-attempt-page';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Tes Pelamar';
    protected ?string $subheading = 'Daftar Paket Ujian Pelamar';
    protected static ?string $slug = 'applicant-test-attempt/{ApplicantTest?}';
    public ApplicantTest $ApplicantTest;
    public $applicantTestAttemptId;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url(fn(): string => route(
                    'filament.admin.resources.job-vacancy-tests.view',
                    ['record' => $this->ApplicantTest->job_vacancy_test_id]
                )),
        ];
    }

    #[Computed()]
    public function applicantTestAttempts()
    {
        return ApplicantTestAttempt::query()
            ->whereBelongsTo($this->ApplicantTest)
            ->get();
    }

    public function updatedApplicantTestAttemptId(): void
    {
        $this->resetTable();  // paksa reload query tabel
    }

    public function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->query(
                ApplicantAnswer::query()
                    ->when(
                        filled($this->applicantTestAttemptId),
                        fn($q) => $q->where('applicant_test_attempt_id', $this->applicantTestAttemptId),
                        fn($q) => $q->whereKey([]) // kosong
                    )
            )
            ->columns([
                TextColumn::make('question.question_text')
                    ->label('Pertanyaan')
                    ->html()                         // penting: render HTML
                    ->wrap()                         // biar membungkus baris
                    ->extraAttributes([
                        'class' => 'prose max-w-none dark:prose-invert', // styling (opsional, pakai Tailwind Typography)
                    ])
                    ->limit(300),
                TextColumn::make('question_choice')
                    ->label('Jawaban')
                    ->state(function ($record) {
                        // 1) Coba dari relasi choice (tapi pastikan isinya ada)
                        $label  = $record->questionChoice?->choice_label;
                        $text   = $record->questionChoice?->choice_text;
                        $choice = trim(
                            (filled($label) ? ($label . '. ') : '') .
                                ($text ?? '')
                        );
                        if (filled($choice)) {
                            return $choice;
                        }

                        // 2) Fallback ke text
                        if (filled($record->answer_text)) {
                            return $record->answer_text;
                        }

                        // 3) Fallback ke JSON
                        $raw = $record->answer_json;

                        if (!filled($raw)) {
                            return null;
                        }

                        // Bisa jadi sudah array karena cast JSON di model
                        $decoded = is_string($raw) ? json_decode($raw, true) : $raw;

                        // Jika gagal decode atau bukan array → stringify mentah
                        if (!is_array($decoded)) {
                            return is_scalar($decoded) ? (string) $decoded : (string) $raw;
                        }

                        // Helper: cek array 1 dimensi (list)
                        $isList = function (array $arr) {
                            return function_exists('array_is_list') ? array_is_list($arr) : array_keys($arr) === range(0, count($arr) - 1);
                        };

                        // Case A: list of objects { right: ... } saja
                        if ($isList($decoded)) {
                            $allSingleRight = true;
                            foreach ($decoded as $item) {
                                if (!is_array($item) || !array_key_exists('right', $item) || count($item) !== 1) {
                                    $allSingleRight = false;
                                    break;
                                }
                            }
                            if ($allSingleRight) {
                                return implode(', ', array_map(fn($it) => (string) $it['right'], $decoded));
                            }

                            // Case B: list of pairs { left, right } → "left → right"
                            $allLeftRight = true;
                            foreach ($decoded as $item) {
                                if (!is_array($item) || !array_key_exists('left', $item) || !array_key_exists('right', $item)) {
                                    $allLeftRight = false;
                                    break;
                                }
                            }
                            if ($allLeftRight) {
                                return implode('; ', array_map(fn($it) => "{$it['left']} → {$it['right']}", $decoded));
                            }

                            // Case C: list of pairs { question, answer } → "question → answer"
                            $allQAPairs = true;
                            foreach ($decoded as $item) {
                                if (!is_array($item) || !array_key_exists('question', $item) || !array_key_exists('answer', $item)) {
                                    $allQAPairs = false;
                                    break;
                                }
                            }
                            if ($allQAPairs) {
                                return implode('; ', array_map(fn($it) => "{$it['question']} → {$it['answer']}", $decoded));
                            }

                            // Case D: list nilai sederhana → "A, B, C"
                            $allScalars = true;
                            foreach ($decoded as $item) {
                                if (!is_scalar($item)) {
                                    $allScalars = false;
                                    break;
                                }
                            }
                            if ($allScalars) {
                                return implode(', ', array_map(fn($v) => (string) $v, $decoded));
                            }
                        }

                        // Default: pretty JSON (biar tetap kebaca)
                        return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    }),
                TextColumn::make('is_correct')
                    ->label('Benar?')
                    ->formatStateUsing(fn(string $state): string => $state ? 'Benar' : 'Salah'),
                TextColumn::make('score')
                    ->label('Skor')
                    ->formatStateUsing(fn(string $state): string => $state ?? '-'),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([
                // Action::make('showAnswer')
                //     ->label('Tampilkan Jawaban')
                //     ->action(function ($record, $livewire) {
                //         $livewire->applicantTestAttemptId = $record->id;
                //     }),
            ])
            ->toolbarActions([
                // ...
            ]);
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Action::make('back')
    //             ->label('Kembali')
    //             ->url(fn(): string => route(
    //                 'filament.admin.resources.job-vacancy-tests.view', ['record' => $this->record->],
    //                 ['record' => $this->question_id->test_id ?? $this->record->test_id ?? null] // sesuaikan
    //             )),
    //     ];
    // }
}
