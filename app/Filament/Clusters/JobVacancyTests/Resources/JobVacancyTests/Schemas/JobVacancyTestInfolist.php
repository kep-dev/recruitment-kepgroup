<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

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
                            ->columnSpan(3)
                            ->label('Mulai')
                            ->dateTime(),
                        TextEntry::make('active_until')
                            ->columnSpan(3)
                            ->label('Selesai')
                            ->dateTime(),
                        TextEntry::make('type')
                            ->columnSpan(3)
                            ->label('Jenis Test')
                            ->formatStateUsing(fn($state) => $state === 'general' ? 'Umum' : 'Psikotest')
                            ->badge(),
                        IconEntry::make('is_active')
                            ->columnSpan(3)
                            ->label('Status')
                            ->boolean(),
                    ]),

            ]);
    }
}
