<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Tables;

use App\Models\JobVacancy;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class ApplicantTestsTable
{
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
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                TextColumn::make('total_score')
                    ->sortable()
                    ->label('Skor'),
            ])
            ->filters([
                SelectFilter::make('application.jobVacancy.title')
                    ->relationship('application.jobVacancy', 'title')
                    ->label('Lowongan')
                    ->options(JobVacancy::all()->pluck('title', 'id')),
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    FilamentExportBulkAction::make('export')
                ]),
            ]);
    }
}
