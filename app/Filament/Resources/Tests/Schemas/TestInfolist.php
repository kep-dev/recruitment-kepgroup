<?php

namespace App\Filament\Resources\Tests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->hidden(),
                TextEntry::make('title')
                    ->label('Judul'),
                TextEntry::make('duration_in_minutes')
                    ->label('Durasi (menit)')
                    ->numeric(),
                TextEntry::make('description')
                    ->label('Deskripsi'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->hidden(),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->hidden(),
            ]);
    }
}
