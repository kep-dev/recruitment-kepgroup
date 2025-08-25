<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationsRelationManager extends RelationManager
{
    protected static string $relationship = 'educations';
    protected static ?string $title = 'Pendidikan Terakhir';
    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('education_level')
                    ->label('Tingkat Pendidikan'),
                TextColumn::make('major')
                    ->label('Jurusan'),
                TextColumn::make('university')
                    ->label('Universitas'),
                TextColumn::make('location')
                    ->label('Lokasi'),
                TextColumn::make('graduation_year')
                    ->label('Tahun Lulus'),
                TextColumn::make('gpa')
                    ->label('IPK'),
            ])
            ->headerActions([]);
    }
}
