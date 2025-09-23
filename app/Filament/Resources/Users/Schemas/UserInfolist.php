<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Akun Pengguna')
                    ->icon('heroicon-o-user-circle')
                    ->iconColor('warning')
                    ->description('Identitas dasar akun.')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama')
                            ->icon('heroicon-o-identification'),

                        TextEntry::make('email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->copyMessage('Email disalin')
                            ->copyMessageDuration(1200)
                            ->url(fn($record) => "mailto:{$record->email}", true)
                            ->openUrlInNewTab(),
                    ]),

                Section::make('Peran & Izin')
                    ->icon('heroicon-o-shield-check')
                    ->iconColor('warning')
                    ->description('Role yang melekat pada user.')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('roles.name')
                            ->label('Role')
                            ->badge()
                            ->limit(25)
                            ->hidden(fn($record) => $record->roles->isEmpty()),
                    ]),
            ]);
    }
}
