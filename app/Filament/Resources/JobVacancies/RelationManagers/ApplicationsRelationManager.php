<?php

namespace App\Filament\Resources\JobVacancies\RelationManagers;

use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\JobVacancies\JobVacancyResource;

class ApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'applications';

    protected static ?string $title = 'Pelamar Dalam Lowongan Ini';

    public function isReadOnly(): bool
    {
        return false;
    }

    // protected static ?string $relatedResource = JobVacancyResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pelamar'),
                TextColumn::make('user.email')
                    ->label('Email'),
                TextColumn::make('applied_at')
                    ->label('Tanggal Lamaran')
                    ->dateTime(),
                TextColumn::make('latestEducation_education_level')
                    ->state(fn($record) => $record->user?->latestEducation?->education_level)
                    ->formatStateUsing(fn($state) => $state ?? '-')
                    ->label('Tingkat Pendidikan'),
                TextColumn::make('latestEducation_major')
                    ->state(fn($record) => $record->user?->latestEducation?->major)
                    ->formatStateUsing(fn($state) => $state ?? '-')
                    ->label('Jurusan'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn($record): string => route(
                        'filament.admin.resources.applicants.view',
                        ['record' => $record->applicant->id] // sesuaikan
                    ))
            ])
            ->headerActions([
                // CreateAction::make(),
            ]);
    }
}
