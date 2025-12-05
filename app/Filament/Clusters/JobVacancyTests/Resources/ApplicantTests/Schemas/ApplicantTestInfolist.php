<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class ApplicantTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Potensi Dasar Akademik')
                            ->schema([
                                RepeatableEntry::make('attempts')
                                    ->hiddenLabel()
                                    ->table([
                                        TableColumn::make('Ujian'),
                                        TableColumn::make('Skor'),
                                    ])
                                    ->schema([
                                        TextEntry::make('test.title'),
                                        TextEntry::make('score'),
                                    ])
                                    ->columnSpanFull()
                            ])
                            ->columnSpanFull(),

                        Tab::make('Psikotest')
                            ->schema([
                                // ...
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
