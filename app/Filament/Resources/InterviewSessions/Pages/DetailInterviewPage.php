<?php

namespace App\Filament\Resources\InterviewSessions\Pages;

use Filament\Schemas\Schema;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Contracts\HasSchemas;
use App\Models\InterviewSessionApplication;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use App\Filament\Resources\InterviewSessions\InterviewSessionResource;

class DetailInterviewPage extends Page implements HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = InterviewSessionResource::class;

    protected string $view = 'filament.resources.interview-sessions.pages.detail-interview-page';

    public function mount(int|string $record): void
    {
        // dd($record);
        $this->record = InterviewSessionApplication::find($record)->load([
            'interviewSession',
            'application.user',
            'evaluations' => function ($q) {
                $q->with([
                    'sessionEvaluator.user:id,name,email',
                    'scores' => function ($q) {
                        $q->with(['criteria:id,label,weight', 'scaleOption:id,label,value']);
                    },
                ]);
            },
        ]);
        // dd($this->record);
    }

    public function evaluationSchema(Schema $schema): Schema
    {
        return $schema
            ->state($this->record)
            ->components([
                Section::make('Detail Sesi & Kandidat')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('interviewSession.title')->label('Judul Sesi'),
                            TextEntry::make('application.user.name')->label('Kandidat'),
                            TextEntry::make('status')->badge(),
                        ]),
                        Grid::make(3)->schema([
                            TextEntry::make('mode')->label('Mode')->placeholder('-'),
                            TextEntry::make('location')->label('Lokasi')->placeholder('-'),
                            TextEntry::make('meeting_link')->label('Meeting Link')->placeholder('-'),
                        ]),
                        Grid::make(3)->schema([
                            TextEntry::make('avg_score')->numeric(2)->label('Rata-rata Skor'),
                            TextEntry::make('recommendation')
                                ->label('Rekomendasi')
                                ->badge()
                                ->colors([
                                    'success' => 'hire',
                                    'warning' => 'hold',
                                    'danger'  => 'no_hire',
                                ]),
                            TextEntry::make('updated_at')->dateTime()->label('Diperbarui'),
                        ]),
                    ]),

                Section::make('Ringkasan Penilaian')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('evaluations_count')
                                ->label('Jumlah Evaluator Submit')
                                ->state(fn() => $this->record->evaluations()->count())
                                ->badge(),
                            TextEntry::make('avg_score')
                                ->label('Rata-rata Skor')
                                ->numeric(2),
                            // TextEntry::make('recommendation')->label('Keputusan')->badge(),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Hasil Penilaian')
                    ->schema([
                        RepeatableEntry::make('evaluations')
                            ->hiddenLabel()
                            ->label(false)
                            ->state(function () {
                                return $this->record
                                    ->evaluations()
                                    ->get()
                                    ->map(function ($ev) {
                                        return [
                                            'evaluator_name'  => $ev->sessionEvaluator?->user?->name,
                                            'evaluator_email' => $ev->sessionEvaluator?->user?->email,
                                            'total_score'     => $ev->total_score,
                                            'recommendation'  => $ev->recommendation,
                                            'submitted_at'    => $ev->submitted_at,
                                            'overall_comment' => $ev->overall_comment,
                                            'scores'          => $ev->scores->map(function ($s) {
                                                return [
                                                    'criteria_label' => $s->criteria?->label,
                                                    'criteria_weight' => $s->criteria?->weight,
                                                    'scale_label'     => $s->scale_label_snapshot ?: $s->scaleOption?->label,
                                                    'scale_value'     => $s->scale_value_snapshot ?: $s->scaleOption?->value,
                                                    'score_numeric'   => $s->score_numeric,
                                                    'comment'         => $s->comment,
                                                ];
                                            })->values()->all(),
                                        ];
                                    })->values()->all();
                            })
                            ->schema([
                                Grid::make(4)->schema([
                                    TextEntry::make('evaluator_name')->label('Evaluator')->icon('heroicon-m-user-circle')->iconColor('primary'),
                                    TextEntry::make('evaluator_email')->label('Email')->copyable(),
                                    TextEntry::make('total_score')->label('Skor Total')->numeric(2)->badge(),
                                    TextEntry::make('recommendation')
                                        ->label('Rekomendasi')
                                        ->badge()
                                        ->colors([
                                            'success' => 'hire',
                                            'warning' => 'hold',
                                            'danger'  => 'no_hire',
                                        ]),
                                ]),
                                Grid::make(1)->schema([
                                    TextEntry::make('overall_comment')->label('Komentar Umum')->placeholder('—'),
                                ]),
                                Grid::make(2)->schema([
                                    TextEntry::make('submitted_at')->dateTime()->label('Disubmit pada'),
                                ]),

                                // ---- rincian skor per kriteria untuk evaluator ini ----
                                RepeatableEntry::make('scores')
                                    ->hiddenLabel()
                                    ->label('Rincian Skor per Kriteria')
                                    ->table([
                                        TableColumn::make('Kriteria'),
                                        TableColumn::make('Nilai'),
                                        TableColumn::make('Nilai'),
                                        TableColumn::make('Skor'),
                                        TableColumn::make('Catatan'),
                                    ])
                                    ->schema([

                                            TextEntry::make('criteria_label')->label('Kriteria'),
                                            TextEntry::make('scale_label')->label('Nilai'),
                                            TextEntry::make('scale_value')->label('Value'),
                                            // TextEntry::make('criteria_weight')->label('Bobot')->numeric(2)->columnSpan(2),
                                            TextEntry::make('score_numeric')->label('Skor')->numeric(2)->badge(),
                                            TextEntry::make('comment')->label('Catatan')->placeholder('—'),

                                    ])
                                    ->grid(1),
                            ])
                            ->grid(1),
                    ]),
            ]);
    }
}
