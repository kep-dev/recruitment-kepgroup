<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class ApplicantTestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.user.name')->label('Pelamar')->searchable(),
                TextColumn::make('application.jobVacancy.title')->label('Lowongan')->searchable(),
                TextColumn::make('status')->label('Status')->searchable(),
                TextColumn::make('total_score')->label('Skor'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
