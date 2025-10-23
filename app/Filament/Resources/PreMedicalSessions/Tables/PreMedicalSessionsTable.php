<?php

namespace App\Filament\Resources\PreMedicalSessions\Tables;

use Dom\Text;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;

class PreMedicalSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->html()
                    ->label('Judul'),
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan'),
                TextColumn::make('scheduled_at')
                    ->label('Jadwal Mulai')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('scheduled_end_at')
                    ->label('Jadwal Selesai')
                    ->dateTime('d M Y H:i'),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Terjadwal',
                        'in_progress' => 'Dilaksanakan',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                    ])
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
