<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Tables;

use Livewire\Component;
use App\Models\JobVacancy;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\QueryBuilder\Constraints\SelectConstraint;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\ApplicantTest;

class ApplicantTestsTable
{
    public function getFormSchema(): array
    {
        return [];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.user.name')
                    ->label('Pelamar')
                    ->searchable(),
                TextColumn::make('application.jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('jobVacancyTest.type')
                    ->label('Tipe Ujian')
                    ->formatStateUsing(fn($state) => $state == 'general' ? 'Potensi Dasar Akademik' : 'Psikotest')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                TextColumn::make('total_score')
                    ->sortable()
                    ->label('Skor')
                    ->hidden(function (Component $livewire) {
                        ds($livewire);
                        return $livewire->activeTab === 'Psikotest';
                    }),
            ])
            ->filters([
                SelectFilter::make('application.jobVacancy.title')
                    ->relationship('application.jobVacancy', 'title')
                    ->label('Lowongan')
                    ->options(JobVacancy::all()->pluck('title', 'id')),

                Filter::make('type')
                    ->schema([
                        Select::make('type')
                            ->label('Tipe Ujian')
                            ->options([
                                'general' => 'Tes Potensi Dasar Akademik',
                                'psychotest' => 'Tes Psikotest',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['type'],
                                fn(Builder $query, $date): Builder => $query->whereRelation('jobVacancyTest', 'type', $data['type']),
                            );
                    })

            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make()
                Action::make('Edit')
                    ->label('Edit')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->default(fn (ApplicantTest $record) => $record->status)
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
                        TextInput::make('total_score')
                            ->label('Skor')
                            ->hiddenOn('create')
                    ])
                    ->action(function (ApplicantTest $record, array $data) {
                        ds($data);
                        $record->update($data);
                    }),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    FilamentExportBulkAction::make('export')
                ]),
            ]);
    }
}
