<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->password()
                    ->columnSpanFull(),
                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->relationship('roles', 'name') // otomatis sync ke role user
                    ->preload()
                    ->searchable()
                    ->options(
                        Role::query()
                        ->whereNotIn('name', ['applicant']) // kecuali role applicant
                        ->pluck('name', 'id')
                        ->toArray()
                    )
                    ->columnSpanFull(),

            ]);
    }
}
