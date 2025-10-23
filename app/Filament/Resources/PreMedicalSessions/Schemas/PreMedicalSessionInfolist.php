<?php

namespace App\Filament\Resources\PreMedicalSessions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class PreMedicalSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Jadwal')
                    ->columns(2)
                    ->schema([

                        TextEntry::make('title')
                            ->label('Judul Sesi')
                            ->html()                     // penting: render HTML
                            ->columnSpanFull(),

                        TextEntry::make('jobVacancy.title')
                            ->label('Lowongan Terkait')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('scheduled_at')
                            ->label('Mulai')
                            ->dateTime('d M Y H:i'),

                        TextEntry::make('scheduled_end_at')
                            ->label('Selesai')
                            ->dateTime('d M Y H:i')
                            ->placeholder('-'),

                        TextEntry::make('location')
                            ->label('Lokasi')
                            ->placeholder('-'),

                        TextEntry::make('status')
                            ->badge()
                            ->colors([
                                'gray' => 'draft',
                                'info' => 'scheduled',
                                'warning' => 'in_progress',
                                'success' => 'completed',
                                'danger' => 'canceled',
                            ])
                            ->label('Status'),
                    ]),

                Section::make('Instruksi')
                    ->schema([
                        TextEntry::make('instruction')
                            ->label('Instruksi')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
