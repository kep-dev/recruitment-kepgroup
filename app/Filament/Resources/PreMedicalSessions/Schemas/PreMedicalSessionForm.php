<?php

namespace App\Filament\Resources\PreMedicalSessions\Schemas;

use App\Models\JobVacancy;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DateTimePicker;

class PreMedicalSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([

                        // Grid::make()
                        //     ->columns(4)
                        //     ->columnSpan([
                        //         'sm' => 12,
                        //         'md' => 4,
                        //         'lg' => 4,
                        //     ])->schema([
                        //         Section::make('Informasi Pekerjaan')
                        //             ->columns(12)
                        //             ->columnSpan([
                        //                 'sm' => 12,
                        //                 'lg' => 4,
                        //                 'xl' => 4
                        //             ])
                        //             ->schema([]),
                        //     ]),

                        Grid::make()
                            ->columns(12)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ])->schema([
                                Section::make('Informasi Tambahan')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 12,
                                        'xl' => 12
                                    ])
                                    ->schema([
                                        Select::make('job_vacancy_id')
                                            ->label('Lowongan')
                                            ->options(
                                                JobVacancy::query()
                                                    ->where('status', true)
                                                    ->pluck('title', 'id')
                                            )
                                            ->searchable()
                                            ->columnSpanFull(),

                                        RichEditor::make('title')
                                            ->label('Judul Pre Medical Checkup')
                                            ->columnSpanFull(),

                                        DateTimePicker::make('scheduled_at')
                                            ->label('Tanggal Pre Medical Checkup')
                                            ->columnSpan(6),

                                        DateTimePicker::make('scheduled_end_at')
                                            ->label('Tanggal Selesai Pre Medical Checkup')
                                            ->columnSpan(6),

                                        TextInput::make('location')
                                            ->label('Lokasi Pre Medical Checkup')
                                            ->placeholder('Klinik PT. Cahaya Fajar Kaltim...')
                                            ->columnSpanFull(),

                                        Textarea::make('instruction')
                                            ->label('Instruksi Pre Medical Checkup')
                                            ->placeholder('puasa, bawa KTP, dsb.')
                                            ->columnSpanFull(),

                                        ToggleButtons::make('status')
                                            ->label('Status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'scheduled' => 'Terjadwal',
                                                'in_progress' => 'Dilaksanakan',
                                                'completed' => 'Selesai',
                                                'canceled' => 'Dibatalkan',
                                            ])
                                            ->inline()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                    ])
            ]);
    }
}
