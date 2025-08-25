<?php

namespace App\Filament\Resources\JobVacancyTests\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;

class JobVacancyTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(12)
                    ->schema([
                        TextEntry::make('jobVacancy.title')
                            ->columnSpanFull()
                            ->label('Lowongan'),
                        TextEntry::make('name')
                            ->columnSpanFull()
                            ->label('Ujian Untuk'),
                        TextEntry::make('active_from')
                            ->columnSpan(4)
                            ->label('Mulai')
                            ->dateTime(),
                        TextEntry::make('active_until')
                            ->columnSpan(4)
                            ->label('Selesai')
                            ->dateTime(),
                        IconEntry::make('is_active')
                            ->columnSpan(4)
                            ->label('Status')
                            ->boolean(),
                    ]),

            ]);
    }
}
