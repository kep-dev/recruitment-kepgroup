<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PsychotestFormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Form'),
                        Textarea::make('description')
                            ->label('Keterangan'),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
