<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AchievementsRelationManager extends RelationManager
{
    protected static string $relationship = 'achievements';
    protected static ?string $title = 'Penghargaan';

    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('achievment_name')
                    ->label('Prestasi'),
                TextColumn::make('organization_name')
                    ->label('Organisasi'),
                TextColumn::make('year')
                    ->label('Tahun'),
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
