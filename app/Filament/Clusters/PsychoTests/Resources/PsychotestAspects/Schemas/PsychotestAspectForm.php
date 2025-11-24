<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Schemas;

use Dom\Text;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Utilities\Get;
use Livewire\Component;

class PsychotestAspectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Aspek')
                        ->schema([
                            Grid::make(12)
                                ->schema([
                                    TextInput::make('code')
                                        ->label('Kode')
                                        ->required()
                                        ->columnSpan(6),
                                    TextInput::make('name')
                                        ->label('Nama Aspek')
                                        ->placeholder('Arah Kerja, Kepemimpinan, dll')
                                        ->required()
                                        ->columnSpan(6),
                                    Textarea::make('description')
                                        ->label('Keterangan')
                                        ->required()
                                        ->columnSpan(12),
                                ]),
                        ]),

                    Step::make('Karakteristik')
                        ->schema([
                            Grid::make(12)
                                ->schema([
                                    Repeater::make('characteristics')
                                        ->hiddenLabel()
                                        ->schema([
                                            TextInput::make('code')
                                                ->label('Kode')
                                                ->required()
                                                ->columnSpan(4),
                                            TextInput::make('name')
                                                ->label('Karakteristik')
                                                ->required()
                                                ->columnSpan(4),
                                            TextInput::make('order')
                                                ->label('Urutan')
                                                ->required()
                                                ->numeric()
                                                ->columnSpan(4),
                                            Textarea::make('description')
                                                ->label('Keterangan')
                                                ->required()
                                                ->columnSpan(12),
                                        ])
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->live(),

                    Step::make('Skor Karakteristik')
                        ->schema([
                            Repeater::make('characteristics')
                                ->label('Skor per Karakteristik')
                                ->schema([
                                    Section::make(fn(Get $get) => $get('name') ?? 'Karakteristik')
                                        ->schema([
                                            // Tampilkan info saja, biar nggak bingung
                                            TextInput::make('code')
                                                ->label('Kode')
                                                ->disabled(),
                                            TextInput::make('name')
                                                ->label('Karakteristik')
                                                ->disabled(),

                                            Repeater::make('scores')
                                                ->label('Skor & Keterangan (0–9)')
                                                ->schema([
                                                    TextInput::make('score')
                                                        ->label('Skor')
                                                        ->numeric()
                                                        ->minValue(0)
                                                        ->maxValue(9)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Textarea::make('description')
                                                        ->label('Keterangan')
                                                        ->required()
                                                        ->columnSpanFull(),
                                                ]),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ])
                        ->live(),
                ])->columnSpanFull(),
            ]);
    }
}
