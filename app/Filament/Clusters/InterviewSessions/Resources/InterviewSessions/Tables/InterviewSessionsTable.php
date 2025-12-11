<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessions\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;

class InterviewSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->hidden(),
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('interviewForm.name')
                    ->label('Form Interview')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Judul Sesi Wawancara')
                    ->searchable(),
                TextColumn::make('scheduled_at')
                    ->label('Jadwal Mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('scheduled_end_at')
                    ->label('Jadwal Selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('default_mode')
                    ->label('Mode'),
                TextColumn::make('default_location')
                    ->label('Lokasi')
                    ->searchable(),
                TextColumn::make('default_meeting_link')
                    ->label('Link Meeting')
                    ->searchable(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Dijadwalkan',
                        'in_progress' => 'Dalam Proses',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                    ])
                    ->searchable()
                    ->disabled(function ($record) {
                        if (!Auth::user()->hasRole('super_admin')) {
                            return $record->status->value === 'completed';
                        }
                        return false;
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
