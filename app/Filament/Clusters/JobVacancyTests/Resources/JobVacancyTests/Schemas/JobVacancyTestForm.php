<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Schemas;

use App\Models\JobVacancy;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class JobVacancyTestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('job_vacancy_id')
                    ->label('Lowongan')
                    ->options(
                        JobVacancy::all()
                            // ->where('status', true)
                            ->pluck('title', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Ujian Untuk')
                    ->required()
                    ->columnSpanFull(),
                DateTimePicker::make('active_from')
                    ->label('Mulai')
                    ->required(),
                DateTimePicker::make('active_until')
                    ->label('Selesai')
                    ->required(),

                ToggleButtons::make('type')
                    ->label('Jenis Test')
                    ->inline()
                    ->options([
                        'general' => 'Umum',
                        'psychotest' => 'Psychotest',
                    ])
                    ->required(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->required(),
            ]);
    }
}
