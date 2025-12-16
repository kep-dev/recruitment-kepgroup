<?php

namespace App\Filament\Resources\Applications\Schemas;

use DateTime;
use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

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
                Toggle::make('is_submitted')
                    ->label('Sudah Dikirim')
                    ->columnSpanFull(),
                DateTimePicker::make('submitted_at')
                    ->label('Tanggal Dikirim')
                    ->columnSpanFull(),
                Select::make('submitted_by')
                    ->label('Dikirim Oleh (User ID)')
                    ->options(function () {
                        return User::whereRelation('roles', 'name', '!=', 'applicant')->pluck('name', 'id');
                    })
                    ->columnSpanFull(),

                Textarea::make('note')
                    ->columnSpanFull(),

            ]);
    }
}
