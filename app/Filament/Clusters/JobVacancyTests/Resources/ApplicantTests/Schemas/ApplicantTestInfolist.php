<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class ApplicantTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Potensi Dasar Akademik')
                            ->schema([
                                RepeatableEntry::make('attempts')
                                    ->hiddenLabel(true)
                                    ->table([
                                        TableColumn::make('Soal'),
                                        TableColumn::make('Status'),
                                        TableColumn::make('Alasan Selesai'),
                                        TableColumn::make('Skor'),
                                    ])
                                    ->schema([
                                        TextEntry::make('test.title'),
                                        TextEntry::make('status'),
                                        TextEntry::make('ended_reason'),
                                        TextEntry::make('score'),
                                    ])
                                    ->columnSpanFull()
                            ])
                            ->columnSpanFull(),

                        Tab::make('Psikotest')
                            ->schema(function ($record): array {
                                $components = [];

                                $attempt =  $record->psychotestAttempts()
                                    ->latest('completed_at')
                                    ->with([
                                        'form',
                                        'aspects.aspect',
                                        'characteristics.characteristic.psychotestAspect',
                                        'characteristics.characteristic.psychotestCharacteristicScores',
                                    ])
                                    ->first();

                                if (! $attempt) {
                                    return [
                                        Section::make()
                                            ->schema([
                                                TextEntry::make('no_psychotest')
                                                    ->label('Hasil Psikotest')
                                                    ->default('Pelamar ini belum memiliki hasil psikotest.'),
                                            ])
                                            ->columnSpanFull(),
                                    ];
                                }

                                $aspectResults = $attempt->aspects;          // collection PsychotestResultAspect
                                $charResults   = $attempt->characteristics;  // collection PsychotestResultCharacteristic

                                //
                                // ===== Ringkasan Umum =====
                                //
                                $components[] = Section::make('Ringkasan Psikotest')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('form_name')
                                            ->label('Form Psikotest')
                                            ->default($attempt->form->name ?? '-'),

                                        TextEntry::make('completed_at')
                                            ->label('Tanggal Tes')
                                            ->default(
                                                $attempt->completed_at
                                                    ? $attempt->completed_at->format('d-m-Y H:i')
                                                    : '-'
                                            ),

                                        // TextEntry::make('status')
                                        //     ->label('Status')
                                        //     ->default(ucfirst($attempt->status ?? '-')),
                                    ])
                                    ->columnSpanFull();

                                //
                                // ========== HASIL PER ASPEK ==========
                                //
                                if ($aspectResults->isNotEmpty()) {
                                    $aspectState = $aspectResults->map(function ($item) {
                                        return [
                                            'name'        => $item->aspect->name,
                                            'raw'         => $item->raw_score,
                                            'scaled'      => $item->scaled_score,
                                            'description' => $item->aspect->description ?? '-',
                                        ];
                                    })->values()->toArray();

                                    $components[] = Section::make('Hasil Per Aspek')
                                        ->columnSpanFull()
                                        ->schema([
                                            RepeatableEntry::make('aspect_results')
                                                ->label('Hasil Per Aspek')
                                                ->hiddenLabel()
                                                ->state($aspectState)
                                                ->table([
                                                    TableColumn::make('Aspek'),
                                                    // TableColumn::make('Skor Mentah'),
                                                    TableColumn::make('Skor Skala'),
                                                ])
                                                ->schema([
                                                    TextEntry::make('name')
                                                        ->label('Aspek')
                                                        ->weight('bold'),

                                                    // TextEntry::make('raw')
                                                    //     ->label('Skor Mentah'),

                                                    TextEntry::make('scaled')
                                                        ->label('Skor Skala (0–9)')
                                                        ->badge()
                                                        ->color(fn($state) => match (true) {
                                                            $state >= 7 => 'success',
                                                            $state >= 4 => 'warning',
                                                            default     => 'danger',
                                                        }),
                                                ])
                                                ->columnSpanFull(),
                                        ]);
                                }

                                //
                                // ========== HASIL PER KARAKTERISTIK, DIKELOMPOKKAN PER ASPEK ==========
                                //
                                if ($charResults->isNotEmpty()) {
                                    // Group karakteristik berdasarkan aspek
                                    $groupedByAspect = $charResults->groupBy(function ($item) {
                                        return $item->characteristic->psychotestAspect->name ?? 'Tanpa Aspek';
                                    });

                                    foreach ($groupedByAspect as $aspectName => $chars) {
                                        $charState = $chars->map(function ($item) {
                                            // Interpretasi skor dari relasi psychotestCharacteristicScores yang sudah di-eager load
                                            $scoreDesc = optional(
                                                $item->characteristic->psychotestCharacteristicScores
                                                    ->firstWhere('score', $item->scaled_score)
                                            )->description ?? '-';

                                            return [
                                                'name'              => $item->characteristic->name,
                                                'code'              => $item->characteristic->code,
                                                'raw'               => $item->raw_score,
                                                'scaled'            => $item->scaled_score,
                                                'final_description' => $scoreDesc,
                                                'detail'            => $item->characteristic->description ?? '-',
                                            ];
                                        })->values()->toArray();

                                        $components[] = Section::make("{$aspectName}")
                                            ->columnSpanFull()
                                            ->schema([
                                                RepeatableEntry::make("char_results_{$aspectName}")
                                                    ->label("Hasil Karakteristik ({$aspectName})")
                                                    ->hiddenLabel()
                                                    ->state($charState)
                                                    ->table([
                                                        TableColumn::make('Kode'),
                                                        TableColumn::make('Karakteristik'),
                                                        // TableColumn::make('Skor Mentah'),
                                                        TableColumn::make('Skor Skala'),
                                                        TableColumn::make('Interpretasi Skor'),
                                                        TableColumn::make('Deskripsi Karakteristik'),
                                                    ])
                                                    ->schema([
                                                        TextEntry::make('code')
                                                            ->label('Kode')
                                                            ->weight('bold'),
                                                        TextEntry::make('name')
                                                            ->label('Karakteristik')
                                                            ->weight('bold'),

                                                        // TextEntry::make('raw')
                                                        //     ->label('Skor Mentah'),

                                                        TextEntry::make('scaled')
                                                            ->label('Skor Skala (0–9)')
                                                            ->badge()
                                                            ->color(fn($state) => match (true) {
                                                                $state >= 7 => 'success',
                                                                $state >= 4 => 'warning',
                                                                default     => 'danger',
                                                            }),

                                                        TextEntry::make('final_description')
                                                            ->label('Interpretasi Skor')
                                                            ->columnSpanFull(),

                                                        TextEntry::make('detail')
                                                            ->label('Keterangan Karakteristik')
                                                            ->columnSpanFull()
                                                            ->limit(50)
                                                            ->tooltip(function (TextEntry $entry): ?string {
                                                                $state = $entry->getState();

                                                                if (strlen($state) <= $entry->getCharacterLimit()) {
                                                                    return null;
                                                                }

                                                                return $state;
                                                            }),
                                                    ])
                                                    ->columnSpanFull(),
                                            ]);
                                    }
                                }

                                return $components;
                            })
                    ])
                    ->columnSpanFull()
            ]);
    }
}
