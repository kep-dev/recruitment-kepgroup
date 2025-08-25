<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Resources\RelationManagers\RelationManager;

class TrainingCertificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingCertifications';
    protected static ?string $title = 'Pelatihan & Sertifikasi';

    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('training_certification_title')
                    ->label('Nama Sertifikasi'),
                TextColumn::make('institution_name')
                    ->label('Institusi'),
                TextColumn::make('type')
                    ->label('Tipe'),
                TextColumn::make('location')
                    ->label('Lokasi'),
                TextColumn::make('start_date')
                    ->date()
                    ->label('Mulai'),
                TextColumn::make('end_date')
                    ->date()
                    ->label('Selesai'),
                TextColumn::make('description')
                    ->label('Deskripsi'),
            ])
            ->headerActions([
                //
            ]);
    }
}
