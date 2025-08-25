<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Applications\ApplicationResource;

class StatusHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';
    protected static ?string $title = 'Riwayat Status Lamaran';
    // protected static ?string $relatedResource = ApplicationResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Riwayat Status Lamaran')
            ->columns([
                TextColumn::make('jobVacancyStage.stageType.name')
                    ->label('Tahap'),
                TextColumn::make('from_status')
                    ->badge()
                    ->label('Dari'),
                TextColumn::make('to_status')
                    ->badge()
                    ->label('Ke'),
                TextColumn::make('changed_at')
                    ->date('d M Y')
                    ->label('Tanggal'),
                TextColumn::make('changedBy.name')
                    ->label('Diubah Oleh'),

            ])
            ->headerActions([
                // CreateAction::make(),
            ]);
    }
}
