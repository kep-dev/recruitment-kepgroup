<?php

namespace App\Filament\Resources\InterviewSessions\Schemas;

use App\Models\Interview;
use App\Models\JobVacancy;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InterviewSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Grid::make()
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([

                        Grid::make()
                            ->columns(8)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                                'lg' => 8,
                            ])->schema([

                                Section::make('Sesi Wawancara')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 8,
                                        'xl' => 8,
                                    ])
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul Sesi Wawancara')
                                            ->placeholder('Wawancara untuk lowongan...')
                                            ->required()
                                            ->columnSpanFull(),
                                        DateTimePicker::make('scheduled_at')
                                            ->label('Jadwal Mulai')
                                            ->required()
                                            ->columnSpanFull(),
                                        DateTimePicker::make('scheduled_end_at')
                                            ->columnSpanFull(),
                                        Select::make('default_mode')
                                            ->label('Mode')
                                            ->options(['onsite' => 'Onsite', 'online' => 'Online', 'hybrid' => 'Hybrid'])
                                            ->default('online')
                                            ->required()
                                            ->columnSpanFull(),
                                        TextInput::make('default_location')
                                            ->label('Lokasi')
                                            ->columnSpanFull(),
                                        TextInput::make('default_meeting_link')
                                            ->label('Link Meeting')
                                            ->columnSpanFull(),
                                        Select::make('status')
                                            ->label('Status')
                                            ->options([
                                                'scheduled' => 'Scheduled',
                                                'in_progress' => 'In progress',
                                                'completed' => 'Completed',
                                                'canceled' => 'Canceled',
                                            ])
                                            ->default('scheduled')
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Grid::make()
                            ->columns(4)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                                'lg' => 4,
                            ])->schema([

                                Section::make('Lainnya')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 4,
                                        'xl' => 4,
                                    ])
                                    ->schema([
                                        Select::make('job_vacancy_id')
                                            ->label('Lowongan')
                                            ->options(
                                                JobVacancy::query()
                                                    ->where('status', true)
                                                    ->pluck('title', 'id')
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->columnSpanFull()
                                            ->required(),
                                        Select::make('interview_id')
                                            ->label('Form Interview')
                                            ->options(
                                                Interview::all()
                                                    ->pluck('name', 'id')
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->columnSpanFull()
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
