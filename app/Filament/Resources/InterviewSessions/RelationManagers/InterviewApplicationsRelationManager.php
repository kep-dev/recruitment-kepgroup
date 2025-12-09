<?php

namespace App\Filament\Resources\InterviewSessions\RelationManagers;

use Filament\Tables\Table;
use App\Models\Application;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\InterviewSessions\InterviewSessionResource;
use App\Filament\Resources\InterviewSessions\Pages\DetailInterviewPage;

class InterviewApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'interviewApplications';
    protected static ?string $title = 'Pelamar Dalam Sesi Ini';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('application_id')
                ->label('Pelamar')
                ->options(
                    Application::query()
                        ->whereNotIn('id', $this->getOwnerRecord()->interviewApplications()->pluck('application_id'))
                        ->where('job_vacancy_id', $this->getOwnerRecord()->job_vacancy_id)
                        ->get()
                        ->mapWithKeys(fn($application) => [$application->id => $application->user->name])
                )
                ->multiple()
                ->searchable()
                ->required()
                ->hiddenOn('edit'),
            Select::make('mode')
                ->label('Mode')
                ->options(
                    [
                        'onsite' => 'Onsite',
                        'remote' => 'Remote',
                        'hybrid' => 'Hybrid',
                    ]
                ),
            TextInput::make('location')->label('Lokasi'),
            TextInput::make('meeting_link')->label('Link Meeting'),
            Select::make('status')
                ->label('Status')
                ->options(
                    [
                        'scheduled' => 'Dijadwalkan',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                        'no_show' => 'Tidak Hadir',
                    ]
                ),
            TextInput::make('avg_score')->label('Skor Rata-rata'),
            TextInput::make('recommendation')->label('Rekomendasi'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.user.name')
                    ->label('Kandidat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mode')
                    ->label('Mode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('meeting_link')
                    ->label('Link Meeting')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_score')
                    ->label('Skor Rata-rata')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_score_label')
                    ->label('Label')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('recommendation')
                    ->label('Rekomendasi')
                    ->searchable()
                    ->sortable(),

            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pelamar')
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        // Karena multiple select, kita perlu buat record untuk tiap application_id
                        foreach ($data['application_id'] as $applicationId) {
                            $this->getOwnerRecord()->interviewApplications()->create([
                                'application_id' => $applicationId,
                                'mode' => $data['mode'] ?? null,
                                'location' => $data['location'] ?? null,
                                'meeting_link' => $data['meeting_link'] ?? null,
                                'status' => $data['status'] ?? 'scheduled',
                                'avg_score' => $data['avg_score'] ?? null,
                                'recommendation' => $data['recommendation'] ?? null,
                            ]);
                        }
                    }),
            ])
            ->recordActions([
                Action::make('GiveAnAssessment')
                    ->color('primary')
                    ->icon(LucideIcon::Eye)
                    ->label('Detail Penilaian')
                    ->url(fn($record) => DetailInterviewPage::getUrl(['record' => $record->getKey()])),

                EditAction::make()
                    ->label('Edit')
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),

                DeleteAction::make()
            ])
        ;
    }
}
