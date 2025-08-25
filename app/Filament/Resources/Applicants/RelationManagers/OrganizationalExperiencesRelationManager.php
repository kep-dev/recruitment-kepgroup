<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Resources\RelationManagers\RelationManager;

class OrganizationalExperiencesRelationManager extends RelationManager
{
    protected static string $relationship = 'organizationalExperiences';
    protected static ?string $title = 'Pengalaman Organisasi';

    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization_name')
                    ->label('Organisasi'),
                TextColumn::make('position')
                    ->label('Posisi'),
                TextColumn::make('level')
                    ->label('Level'),
                TextColumn::make('start_date')
                    ->date()
                    ->label('Mulai'),
                TextColumn::make('end_date')
                    ->date()
                    ->label('Selesai'),
            ])
            ->headerActions([
                //
            ]);
    }
}
