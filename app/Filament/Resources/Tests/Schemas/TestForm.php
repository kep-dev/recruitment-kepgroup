<?php

namespace App\Filament\Resources\Tests\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Judul')
                    ->placeholder('Psikotes, Wawancara, dll')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('duration_in_minutes')
                    ->label('Durasi (menit)')
                    ->required()
                    ->numeric()
                    ->columnSpanFull(),
            ]);
    }
}
