<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('final_status')
                    ->options(['pending' => 'Pending', 'Dalam Proses' => 'Dalam Proses', 'hired' => 'Diterima', 'rejected' => 'Ditolak'])
                    ->default('pending')
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
