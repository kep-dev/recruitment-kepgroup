<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InterviewSessionApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('interview_session_id')
                    ->required(),
                TextInput::make('application_id')
                    ->required(),
                Select::make('mode')
                    ->options(['onsite' => 'Onsite', 'online' => 'Online', 'hybrid' => 'Hybrid']),
                TextInput::make('location'),
                TextInput::make('meeting_link'),
                Select::make('status')
                    ->options([
            'scheduled' => 'Scheduled',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
            'no_show' => 'No show',
            'canceled' => 'Canceled',
        ])
                    ->default('scheduled')
                    ->required(),
                TextInput::make('avg_score')
                    ->numeric(),
                Select::make('recommendation')
                    ->options(['hire' => 'Hire', 'hold' => 'Hold', 'no_hire' => 'No hire']),
            ]);
    }
}
