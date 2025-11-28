<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PsychotestFormInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Form'),
                TextEntry::make('description')
                    ->label('Keterangan'),
            ]);
    }
}
