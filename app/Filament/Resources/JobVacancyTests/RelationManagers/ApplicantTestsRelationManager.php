<?php

namespace App\Filament\Resources\JobVacancyTests\RelationManagers;

use Filament\Tables\Table;
use App\Models\Application;
use Illuminate\Support\Str;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DateTimePicker;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;

class ApplicantTestsRelationManager extends RelationManager
{
    protected static string $relationship = 'applicantTests';
    protected static ?string $title = 'Pelamar Dalam Tes Ini';

    // protected static ?string $relatedResource = JobVacancyTestResource::class;

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
                        ->whereNotIn('id', $this->getOwnerRecord()->applicantTests()->pluck('application_id'))
                        ->where('job_vacancy_id', $this->getOwnerRecord()->job_vacancy_id)
                        ->get()
                        ->mapWithKeys(fn($application) => [$application->id => $application->user->name])
                )
                ->multiple()
                ->searchable()
                ->required()
                ->hiddenOn('edit'),
            Select::make('status')
                ->label('Status')
                ->options(
                    [
                        'assigned' => 'Ditugaskan',
                        'in_progress' => 'Dalam Proses',
                        'completed' => 'Selesai',
                        'expired' => 'Kadaluarsa',
                    ]
                ),
            DateTimePicker::make('started_at')
                ->label('Mulai')
                ->required(),
            DateTimePicker::make('completed_at')
                ->label('Selesai')
                ->required(),
            TextInput::make('score')
                ->label('Skor')
                ->hiddenOn('create')

        ];
    }

    // 'application_id',
    //     'job_vacancy_test_id',
    //     'access_token',
    //     'status',
    //     'started_at',
    //     'completed_at',
    //     'total_score',

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.user.name')
                    ->label('Pelamar')
                    ->searchable(),
                TextColumn::make('application.user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('access_token')
                    ->label('Token')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                TextColumn::make('started_at')
                    ->label('Mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Skor')
            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pelamar')
                    ->icon(LucideIcon::Plus)
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        foreach ($data['application_id'] as $application_id) {
                            $this->getOwnerRecord()->applicantTests()->create([
                                'application_id' => $application_id,
                                'status' => $data['status'],
                                'access_token' => Str::upper(Str::random(10)),
                                'started_at' => $data['started_at'],
                                'completed_at' => $data['completed_at'],
                            ]);
                        }

                        Notification::make()
                            ->success()
                            ->title('Berhasil')
                            ->send();
                    }),
            ]);
    }
}
