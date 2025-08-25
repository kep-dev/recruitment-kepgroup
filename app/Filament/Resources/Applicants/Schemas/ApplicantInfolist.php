<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ApplicantInfolist
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
                            ->columns(12)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                                'lg' => 8,
                                'xl' => 8
                            ])
                            ->schema([
                                Section::make()
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('user.name')
                                            ->columnSpanFull(),
                                        TextEntry::make('user.email')
                                            ->columnSpanFull(),
                                        TextEntry::make('nik')
                                            ->label('NIK')
                                            ->columnSpanFull(),
                                        TextEntry::make('date_of_birth')
                                            ->label('Tanggal Lahir')
                                            ->date()
                                            ->columnSpanFull(),
                                        TextEntry::make('phone_number')
                                            ->label('Nomor Telepon')
                                            ->columnSpanFull(),
                                        TextEntry::make('gender')
                                            ->label('Jenis Kelamin')
                                            ->columnSpanFull(),
                                        TextEntry::make('city')
                                            ->label('Kota')
                                            ->columnSpanFull(),
                                        TextEntry::make('province')
                                            ->label('Provinsi')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Grid::make()
                            ->columns(12)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                                'lg' => 4,
                                'xl' => 4
                            ])
                            ->schema([
                                // Section::make()
                                //     ->columnSpanFull()
                                //     ->schema([
                                RepeatableEntry::make('skills')
                                    ->label('Skill')
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('skill')
                                            ->label('Skill')
                                            ->inlineLabel(),
                                    ]),

                                RepeatableEntry::make('functionOfInterests')
                                    ->label('Fungsi Interes')
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('function_of_interest')
                                            ->inlineLabel()
                                            ->label('Fungsi Interes'),
                                    ]),

                                RepeatableEntry::make('languages')
                                    ->label('Bahasa')
                                    ->columnSpanFull()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('language')
                                            ->label('Bahasa'),
                                        TextEntry::make('level')
                                            ->label('Level'),
                                    ]),

                                RepeatableEntry::make('socialMedias')
                                    ->label('Sosial Media')
                                    ->columnSpanFull()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Sosial Media'),
                                        TextEntry::make('url')
                                            ->label('URL'),
                                    ]),

                                RepeatableEntry::make('salaries')
                                    ->label('Gaji')
                                    ->columnSpanFull()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('expected_salary')
                                            ->label('Gaji Yang Diharapkan'),
                                        TextEntry::make('current_salary')
                                            ->label('Gaji Saat Ini'),
                                    ]),


                                // ]),
                            ]),
                    ])
            ]);
    }
}
