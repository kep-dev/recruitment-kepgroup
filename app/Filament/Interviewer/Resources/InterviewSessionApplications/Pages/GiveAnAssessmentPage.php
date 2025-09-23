<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Models\InterviewEvaluation;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use App\Models\InterviewEvaluationScore;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use App\Models\InterviewSessionEvaluator;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Validation\ValidationException;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;

class GiveAnAssessmentPage extends Page implements HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = InterviewSessionApplicationResource::class;

    protected string $view = 'filament.interviewer.resources.interview-session-applications.pages.give-an-assessment-page';

    public array $data = [
        'scores' => [],
        'recommendation' => null,
        'overall_comment' => null,
    ];

    public function mount(int|string $record): void
    {
        // $this->form->fill();
        $this->record = $record = $this->resolveRecord($record)->load(['interviewSession.interviewForm', 'application.user']);

        $isEvaluator = InterviewSessionEvaluator::query()
            ->where('interview_session_id', $record->interview_session_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (! $isEvaluator) {
            abort(403, 'Anda bukan evaluator pada sesi ini.');
        }

        // Prefill jika sudah pernah menilai
        $existingEval = InterviewEvaluation::query()
            ->where('interview_session_application_id', $record->id)
            ->where('interview_session_evaluator_id', function ($q) use ($record) {
                $q->select('id')
                    ->from('interview_session_evaluators')
                    ->where('interview_session_id', $record->interview_session_id)
                    ->where('user_id', Auth::id());
            })
            ->with('scores') // pastikan relasi ada
            ->first();

        if ($existingEval) {
            $this->data['recommendation']  = $existingEval->recommendation;
            $this->data['overall_comment'] = $existingEval->overall_comment;
            $this->data['scores'] = $existingEval->scores->map(function ($s) {
                return [
                    'interview_criteria_id'  => $s->interview_criteria_id,
                    'interview_scale_id'     => $s->interview_scale_id,
                    'scale_label_snapshot'   => $s->scale_label_snapshot,
                    'scale_value_snapshot'   => $s->scale_value_snapshot,
                    'score_numeric'          => (float) $s->score_numeric,
                    'comment'                => $s->comment,
                ];
            })->values()->all();
        } else {
            // Prefill baris kosong: semua kriteria dari interview
            $criteria = DB::table('interview_criterias')
                ->where('interview_id', $record->interviewSession->interview_id)
                ->orderBy('order')
                ->get(['id']);

            $this->data['scores'] = $criteria->map(fn($c) => [
                'interview_criteria_id'  => $c->id,
                'interview_scale_id'     => null,
                'scale_label_snapshot'   => null,
                'scale_value_snapshot'   => null,
                'score_numeric'          => null,
                'comment'                => null,
            ])->toArray();
        }
    }

    public function testSchema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi')
                    ->columns(3)
                    ->schema([
                        Placeholder::make('candidate')
                            ->label('Kandidat')
                            ->content(fn() => $this->record?->application?->user?->name ?? '-'),

                        Placeholder::make('session')
                            ->label('Sesi')
                            ->content(fn() => $this->record?->interviewSession?->title ?? '-'),

                        Placeholder::make('interview')
                            ->label('Form Wawancara')
                            ->content(fn() => $this->record?->interviewSession?->interview?->name ?? '-'),
                    ]),

                Section::make('Penilaian per Kriteria')
                    ->schema([
                        Repeater::make('scores')
                            ->columns(12)
                            ->deletable(false)->addable(false)->reorderable(false)
                            ->schema([
                                // Kriteria (readonly)
                                Select::make('interview_criteria_id')
                                    ->label('Kriteria')
                                    ->columnSpan(5)
                                    ->options(function () {
                                        if (! $this->record) return [];
                                        return DB::table('interview_criterias')
                                            ->where('interview_id', $this->record->interviewSession->interview_id)
                                            ->orderBy('order')
                                            ->pluck('label', 'id')
                                            ->toArray();
                                    })
                                    ->disabled()
                                    ->dehydrated(true),

                                // Skala per-kriteria
                                Select::make('interview_scale_id')
                                    ->label('Nilai')
                                    ->columnSpan(3)
                                    ->required()
                                    ->options(function (Get $get) {
                                        $critId = $get('interview_criteria_id');
                                        if (! $critId) return [];
                                        return DB::table('interview_scales')
                                            ->where('interview_criteria_id', $critId)
                                            ->orderBy('order')
                                            ->get(['id', 'label', 'value'])
                                            ->mapWithKeys(fn($o) => [$o->id => "{$o->label} ({$o->value})"])
                                            ->toArray();
                                    })
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                        if (! $state) return;

                                        $critId = $get('interview_criteria_id');

                                        $opt = DB::table('interview_scales')->where('id', $state)->first();
                                        if (! $opt) return;

                                        // Snapshot
                                        $set('scale_label_snapshot', $opt->label);
                                        $set('scale_value_snapshot', (int) $opt->value);

                                        // Skor numerik: (value / max_value_of_criteria) * weight * 100
                                        $maxVal = (int) (DB::table('interview_scales')
                                            ->where('interview_criteria_id', $critId)
                                            ->max('value') ?: 1);

                                        $weight = (float) (DB::table('interview_criterias')
                                            ->where('id', $critId)
                                            ->value('weight') ?: 1.0);

                                        $normalized = $maxVal > 0 ? ($opt->value / $maxVal) : 0;
                                        $score = round($normalized * $weight * 100, 2);

                                        $set('score_numeric', $score);
                                    }),

                                Hidden::make('scale_label_snapshot')->dehydrated(true),
                                Hidden::make('scale_value_snapshot')->dehydrated(true),

                                TextInput::make('score_numeric')
                                    ->label('Skor')
                                    ->numeric()->readOnly()
                                    ->columnSpan(2),

                                Textarea::make('comment')
                                    ->label('Catatan')
                                    ->rows(2)
                                    ->columnSpan(12),
                            ]),
                    ]),

                Section::make('Ringkasan')
                    ->schema([
                        Radio::make('recommendation')
                            ->label('Rekomendasi')
                            ->options([
                                'hire'    => 'Hire',
                                'hold'    => 'Hold',
                                'no_hire' => 'No Hire',
                            ])
                            ->inline(),

                        Textarea::make('overall_comment')
                            ->label('Komentar Umum')
                            ->rows(3),
                    ]),
            ])
            ->statePath('data');
    }

    /** Tombol di footer form (v4) */
    // protected function getFormActions(): array
    // {
    //     return [
    //         Action::make('save')
    //             ->label('Simpan Penilaian')
    //             ->submit('save')
    //             ->icon('heroicon-m-check'),
    //     ];
    // }

    public function save(): void
    {
        $state = $this->testSchema->getState();
        // dd($state);
        // Pastikan semua kriteria terisi
        foreach ($state['scores'] as $row) {
            if (empty($row['interview_criteria_id']) || empty($row['interview_scale_id'])) {
                throw ValidationException::withMessages([
                    'data.scores' => 'Semua kriteria wajib diberi nilai.',
                ]);
            }
        }

        DB::transaction(function () use ($state) {
            $sessionEvaluatorId = InterviewSessionEvaluator::query()
                ->where('interview_session_id', $this->record->interview_session_id)
                ->where('user_id', Auth::id())
                ->value('id');

            if (! $sessionEvaluatorId) {
                throw new \RuntimeException('Anda bukan evaluator pada sesi ini.');
            }

            // Upsert evaluation (1 evaluator x 1 kandidat per sesi)
            $evaluation = InterviewEvaluation::query()->firstOrCreate(
                [
                    'interview_session_application_id' => $this->record->id,
                    'interview_session_evaluator_id'   => $sessionEvaluatorId,
                ],
                [
                    'submitted_at'    => now(),
                ]
            );

            // Simpan nilai ringkasan
            $evaluation->update([
                'recommendation'  => $state['recommendation'] ?? null,
                'overall_comment' => $state['overall_comment'] ?? null,
                'submitted_at'    => now(),
            ]);

            // Simpan/Upsert skor per-kriteria
            $total = 0;
            foreach ($state['scores'] as $row) {
                $score = (float) ($row['score_numeric'] ?? 0);

                InterviewEvaluationScore::query()->updateOrCreate(
                    [
                        'interview_evaluation_id' => $evaluation->id,
                        'interview_criteria_id'   => $row['interview_criteria_id'], // <- gunakan FK kriteria (bukan interview_id)
                    ],
                    [
                        'interview_scale_id'     => $row['interview_scale_id'],
                        'scale_label_snapshot'   => $row['scale_label_snapshot'] ?? null,
                        'scale_value_snapshot'   => $row['scale_value_snapshot'] ?? null,
                        'score_numeric'          => $score,
                        'comment'                => $row['comment'] ?? null,
                    ]
                );

                $total += $score;
            }

            // Update total evaluator
            $evaluation->update(['total_score' => $total]);

            // Update avg_score kandidat di sesi ini
            $avg = InterviewEvaluation::query()
                ->where('interview_session_application_id', $this->record->id)
                ->avg('total_score');

            $this->record->update(['avg_score' => $avg]);
        });

        Notification::make()
            ->title('Penilaian tersimpan')
            ->success()
            ->send();
    }

    // public function getHeading(): string
    // {
    //     $name = $this->record?->application?->user?->name ?? 'Kandidat';
    //     return "Penilaian: {$name}";
    // }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url(fn(): string => route(
                    'filament.interviewer.resources.interview-session-applications.view',
                    ['record' => $this->record] // sesuaikan
                )),
        ];
    }
}
