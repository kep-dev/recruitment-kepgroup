<?php

namespace App\Filament\Resources\JobVacancyTests\RelationManagers;

use Filament\Tables\Table;
use App\Models\Application;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Collection;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Pages\ApplicantTestAttemptPage;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;
use App\Traits\SendToken;

class ApplicantTestsRelationManager extends RelationManager
{
    use SendToken;
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
                ->label('Mulai'),
            DateTimePicker::make('completed_at')
                ->label('Selesai'),
            TextInput::make('score')
                ->label('Skor')
                ->hiddenOn('create')

        ];
    }

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
                TextColumn::make('total_score')
                    ->label('Skor')
            ])
            ->recordActions([
                Action::make('ViewChoices')
                    ->label('Periksa Jawaban')
                    ->icon(LucideIcon::Eye)
                    ->url(fn($record) => ApplicantTestAttemptPage::getUrl(['ApplicantTest' => $record->getKey()])),
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('sendToken')
                        ->label('Kirim Token')
                        ->action(function (Collection $records, array $data) {
                            $records->each(function ($record) {
                                // dd($record->application->user->applicant->phone_number);
                                $this->generateWhatsappMessage([
                                    'name'        => $record->application->user->name,
                                    'job_title'   => $record->application->jobVacancy->title,
                                    'company_name' => config('app.company_name', 'KEP Group'),
                                    'token'       => $record->access_token,
                                    'link'        => 'https://exam.kepgroup.com',
                                    'active_from' => $record->jobVacancyTest->active_from,
                                    'active_until' => $record->jobVacancyTest->active_until,
                                    'contact'     => $record->application->user->applicant->phone_number,
                                ]);
                            });
                        }),
                ]),
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
