<?php

namespace App\Filament\Resources\InterviewSessions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InterviewSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([

                        Grid::make()
                            ->columns(8)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                                'lg' => 8,
                            ])->schema([

                                Section::make('Sesi Wawancara')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 8,
                                        'xl' => 8,
                                    ])
                                    ->schema([
                                        TextEntry::make('title')
                                            ->label('Judul Sesi Wawancara')
                                            ->columnSpanFull(),
                                        TextEntry::make('scheduled_at')
                                            ->label('Waktu Mulai')
                                            ->dateTime()
                                            ->columnSpanFull(),
                                        TextEntry::make('scheduled_end_at')
                                            ->label('Waktu Selesai')
                                            ->dateTime()
                                            ->columnSpanFull(),
                                        TextEntry::make('default_mode')
                                            ->label('Mode')
                                            ->columnSpanFull(),
                                        TextEntry::make('default_location')
                                            ->label('Lokasi')
                                            ->columnSpanFull(),
                                        TextEntry::make('default_meeting_link')
                                            ->label('Link Meeting')
                                            ->columnSpanFull(),
                                        TextEntry::make('status')
                                            ->label('Status')
                                            ->columnSpanFull(),

                                    ]),
                            ]),

                        Grid::make()
                            ->columns(4)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                                'lg' => 4,
                            ])->schema([

                                Section::make('Lainnya')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 4,
                                        'xl' => 4,
                                    ])
                                    ->schema([
                                        TextEntry::make('jobVacancy.title')
                                            ->label('Lowongan')
                                            ->columnSpanFull(),
                                        TextEntry::make('interviewForm.name')
                                            ->label('Form Interview')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                    ]),
            ]);
    }
}
