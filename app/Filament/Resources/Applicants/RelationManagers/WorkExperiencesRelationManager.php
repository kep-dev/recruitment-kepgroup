<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkExperiencesRelationManager extends RelationManager
{
    protected static string $relationship = 'workExperiences';
    protected static ?string $title = 'Pengalaman Kerja';
    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('job_title')
            ->label('Jabatan'),
            TextColumn::make('company_name')
            ->label('Perusahaan'),
            TextColumn::make('job_position')
            ->label('Posisi'),
            TextColumn::make('industry')
            ->label('Industri'),
            TextColumn::make('start_date')
            ->date()
            ->label('Mulai'),
            TextColumn::make('end_date')
            ->date()
            ->label('Selesai'),
            TextColumn::make('currently_working')
            ->label('Saat Ini'),
            TextColumn::make('description')
            ->label('Deskripsi'),
        ])
            ->headerActions([
                //
            ]);
    }
}
