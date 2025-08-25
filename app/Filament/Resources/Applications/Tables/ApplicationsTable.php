<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\User;
use App\Enums\status;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Actions\Action;
use App\Models\JobVacancyStage;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Grouping\Group;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->whereRelation('jobVacancy', 'status', true))
            ->groups([
                Group::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('latestStageProgress.jobVacancyStage.stageType.name')
                    ->badge()
                    ->label('Tahap'),
                TextColumn::make('latestStageProgress.status')
                    ->badge()
                    ->label('Status'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->hidden(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->hidden(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Action::make('createStageProgress')
                //     ->label('Tambah Tahap Lamaran')
                //     ->icon(LucideIcon::ArrowDown01)
                //     ->schema([
                //         Select::make('job_vacancy_stage_id')
                //             ->label('Tahap Lamaran')
                //             ->options(
                //                 JobVacancyStage::with('stageType')
                //                     ->get()
                //                     ->mapWithKeys(fn($stage) => [$stage->id => $stage->stageType->name])
                //             )
                //             ->searchable(),
                //         Select::make('status')
                //             ->label('Status')
                //             ->options(status::class),
                //         DatePicker::make('started_at')
                //             ->label('Mulai'),
                //         DatePicker::make('decided_at')
                //             ->label('Selesai'),
                //         Select::make('decided_by')
                //             ->label('Diterima Oleh')
                //             ->options(
                //                 User::query()->pluck('name', 'id')
                //             ),
                //         Textarea::make('note')
                //             ->columnSpanFull()
                //             ->label('Catatan'),
                //         TextInput::make('score')
                //             ->label('Skor')
                //             ->numeric()
                //             ->minValue(1),
                //     ])
                //     ->databaseTransaction()
                //     ->action(function ($record, array $data) {
                //         $record->update([
                //             'current_stage_id' => $data['job_vacancy_stage_id'],
                //         ]);

                //         $record->stageProgresses()->create($data);
                //     }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('createStageProgress')
                        ->label('Tambah Tahap Lamaran')
                        ->icon('heroicon-o-plus')
                        ->schema([
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
                                ->options(Status::class),
                            DatePicker::make('started_at')->label('Mulai'),
                            DatePicker::make('decided_at')->label('Selesai'),
                            Select::make('decided_by')
                                ->label('Diterima Oleh')
                                ->options(User::pluck('name', 'id')),
                            Textarea::make('note')->columnSpanFull()->label('Catatan'),
                            TextInput::make('score')->label('Skor')->numeric()->minValue(1),
                        ])
                        ->action(function (Collection $records, array $data) {
                            // dd($records);
                            foreach ($records as $record) {
                                // update stage saat ini di parent
                                $record->update([
                                    'current_stage_id' => $data['job_vacancy_stage_id'],
                                ]);

                                // tambahkan progress baru
                                $record->stageProgresses()->create($data);
                            }
                        })

                ]),
            ]);
    }
}
