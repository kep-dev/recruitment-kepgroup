<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class PsychotestAspectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Aspek')
                    ->icon(LucideIcon::Info)
                    ->description('Detail aspek psikotest')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Aspek')
                            ->badge()
                            ->size(TextSize::Large),

                        RepeatableEntry::make('characteristics')
                            ->label('Karakteristik')
                            ->schema([
                                TextEntry::make('code')
                                    ->label('Kode Karakteristik'),
                                TextEntry::make('name')
                                    ->label('Nama Karakteristik'),
                                TextEntry::make('description')
                                    ->columnSpan(2)
                                    ->label('Deskripsi Karakteristik'),

                                RepeatableEntry::make('psychotestCharacteristicScores')
                                    ->label('Nilai Karakteristik')
                                    ->hiddenLabel(true)
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('score'),
                                        TextEntry::make('description'),
                                    ])
                                    ->columnSpanFull()
                            ])
                            ->columns(2)

                    ])
                    ->columnSpanFull()
            ]);
    }
}
