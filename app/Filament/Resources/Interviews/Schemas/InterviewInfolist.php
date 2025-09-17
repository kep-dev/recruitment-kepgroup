<?php

namespace App\Filament\Resources\Interviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InterviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Interview')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }
}
