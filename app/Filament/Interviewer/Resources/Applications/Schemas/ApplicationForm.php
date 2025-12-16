<?php

namespace App\Filament\Interviewer\Resources\Applications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id'),
                TextInput::make('job_vacancy_id'),
                DateTimePicker::make('applied_at')
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
                TextInput::make('current_stage_id'),
                Select::make('final_status')
                    ->options(['pending' => 'Pending', 'hired' => 'Hired', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->required(),
                Toggle::make('is_submitted')
                    ->required(),
                DateTimePicker::make('submitted_at'),
                TextInput::make('submitted_by'),
                TextInput::make('external_id'),
                TextInput::make('external_status'),
            ]);
    }
}
