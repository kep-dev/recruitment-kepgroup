<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Nama'),
                TextEntry::make('user.email')
                    ->label('Email'),
                TextEntry::make('jobVacancy.title')
                    ->label('Pekerjaan'),
                TextEntry::make('final_status')
                    ->label('Status'),
            ]);
    }
}
