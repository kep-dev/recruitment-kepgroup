<?php

namespace App\Filament\Resources\JobVacancies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class JobVacanciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->rowIndex()
                    ->label('ID')
                    ->hidden(),
                TextColumn::make('user_id')
                    ->label('Penanggung Jawab')
                    ->hidden()
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable()
                    ->label('Judul'),
                TextColumn::make('workType.name')
                    ->sortable()
                    ->label('Jenis Pekerjaan'),
                TextColumn::make('employeeType.name')
                    ->sortable()
                    ->label('Jenis Karyawan'),
                TextColumn::make('jobLevel.name')
                    ->sortable()
                    ->label('Level Jabatan'),
                TextColumn::make('placement_id')
                    ->numeric()
                    ->sortable()
                    ->hidden()
                    ->label('Penempatan'),
                TextColumn::make('slug')
                    ->searchable()
                    ->hidden(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label('Tanggal Penutupan'),
                ToggleColumn::make('status')
                    ->label('Status'),
                TextColumn::make('salary')
                    ->numeric()
                    ->sortable()
                    ->label('Gaji'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
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
