<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\User;
use App\Enums\status;
use App\Models\JobVacancy;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Actions\Action;
use App\Models\JobVacancyStage;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Grouping\Group;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Blade;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Filament\Tables\Columns\SelectColumn;

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
            ->headerActions([
                FilamentExportHeaderAction::make('export')
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
                SelectColumn::make('final_status')
                    ->label('Status Akhir')
                    ->options([
                        'pending' => 'Pending',
                        'hired' => 'Diterima',
                        'reject' => 'Ditolak',
                    ]),
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
                SelectFilter::make('job_vacancy_id')
                    ->label('Lowongan')
                    ->options(JobVacancy::query()->pluck('title', 'id'))
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
                Action::make('printResume')
                    ->label('Cetak Resume')
                    ->icon(LucideIcon::Printer)
                    ->action(function (Model $record) {
                        // ds($record->preMedicalSessionApplication);
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('print.application.application-pdf', ['record' => $record])
                            )->stream();
                        }, $record->user->name . '-' . $record->jobVacancy->title . '.pdf');
                    }),
                // ->url(fn(Model $reco,rd) => route('applications.print', $record))
                // ->openUrlInNewTab(),
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
