<?php

namespace App\Filament\Interviewer\Resources\Applications\Tables;

use App\Models\JobVacancy;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('user.latestEducation.education_level')
                    ->label('Pendidikan Terakhir')
                    ->searchable(),
                TextColumn::make('user.latestEducation.major')
                    ->label('Jurusan')
                    ->searchable(),
                TextColumn::make('user.latestEducation.university')
                    ->label('Universitas')
                    ->searchable(),
                TextColumn::make('user.latestEducation.gpa')
                    ->label('IPK')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('job_vacancy_id')
                    ->label('Lowongan')
                    ->options(JobVacancy::query()->pluck('title', 'id'))
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
