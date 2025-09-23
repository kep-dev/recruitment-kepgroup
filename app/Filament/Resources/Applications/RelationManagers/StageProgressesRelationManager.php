<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Models\User;
use App\Enums\status;
use App\Models\StageType;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\JobVacancyStage;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Models\ApplicationStageProgress;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Applications\ApplicationResource;

class StageProgressesRelationManager extends RelationManager
{
    protected static string $relationship = 'stageProgresses';
    protected static ?string $title = 'Tahap Lamaran';

    public function isReadOnly(): bool
    {
        return false;
    }

    // protected static ?string $relatedResource = ApplicationResource::class;

    protected function getFormSchema(): array
    {
        return [
            Select::make('job_vacancy_stage_id')
                ->label('Tahap Lamaran')
                ->options(
                    JobVacancyStage::with('stageType')
                        ->get()
                        ->mapWithKeys(fn($stage) => [$stage->id => $stage->stageType->name])
                )
                ->searchable(),
            Select::make('status')
                ->label('Status')
                ->options(status::class),
            DatePicker::make('started_at')
                ->label('Mulai'),
            DatePicker::make('decided_at')
                ->label('Selesai'),
            Select::make('decided_by')
                ->label('Diterima Oleh')
                ->options(
                    User::query()->pluck('name', 'id')
                ),
            Textarea::make('note')
                ->columnSpanFull()
                ->label('Catatan'),
            TextInput::make('score')
                ->label('Skor')
                ->numeric()
                ->minValue(1),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Progress Tahap Lamaran')
            ->columns([
                TextColumn::make('jobVacancyStage.stageType.name')
                    ->label('Tahap'),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status'),
                TextColumn::make('started_at')
                    ->date('d M Y')
                    ->label('Mulai'),
                TextColumn::make('decided_at')
                    ->date('d M Y')
                    ->label('Selesai'),
                TextColumn::make('decidedBy.name')
                    ->label('Diterima Oleh'),
                TextColumn::make('note')
                    ->label('Catatan'),
                TextColumn::make('score')
                    ->numeric()
                    ->label('Skor'),

            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->databaseTransaction()
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),
            ])
            ->headerActions([
                Action::make('createStageProgress')
                    ->label('Tambah Tahap Lamaran')
                    ->icon(LucideIcon::ArrowDown01)
                    ->schema($this->getFormSchema())
                    ->databaseTransaction()
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->update([
                            'current_stage_id' => $data['job_vacancy_stage_id'],
                        ]);

                        $this->getOwnerRecord()->stageProgresses()->create($data);
                    }),
            ]);
    }
}
