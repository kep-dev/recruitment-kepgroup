<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class PsychotestFormInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Form'),
                TextEntry::make('description')
                    ->label('Keterangan'),

                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->contained(false)
                    ->tabs([
                        Tab::make('Aspek')
                            ->schema(function ($record): array {
                                // $record = PsychotestForm
                                $rows = DB::table('psychotest_option_characteristic_mappings as m')
                                    ->join('psychotest_question_options as o', 'o.id', '=', 'm.option_id')
                                    ->join('psychotest_questions as q', 'q.id', '=', 'o.psychotest_question_id')
                                    ->join('psychotest_aspects as a', 'a.id', '=', 'm.aspect_id')
                                    ->where('q.psychotest_form_id', $record->id)
                                    ->whereNotNull('m.aspect_id')
                                    ->select(
                                        'a.id',
                                        'a.name',
                                        DB::raw('SUM(m.weight) as max_raw_score')
                                    )
                                    ->groupBy('a.id', 'a.name')
                                    ->get();

                                if ($rows->isEmpty()) {
                                    return [
                                        TextEntry::make('aspects_empty')
                                            ->label('Informasi')
                                            ->default('Belum ada mapping aspek untuk form ini.'),
                                    ];
                                }

                                $maxAspectData = $rows->map(function ($row) {
                                    return [
                                        'name'       => $row->name,
                                        'max_raw'    => $row->max_raw_score,
                                        'max_scaled' => 9, // karena skala kita 0–9
                                    ];
                                })->values()->toArray();

                                return [
                                    RepeatableEntry::make('max_aspects')
                                        ->label('Nilai Maksimal per Aspek')
                                        ->state($maxAspectData)
                                         ->table([
                                            TableColumn::make('Aspek'),
                                            TableColumn::make('Nilai Maksimal Mentah'),
                                            TableColumn::make('Nilai Skala (0–9)'),
                                        ])
                                        ->schema([
                                            TextEntry::make('name')
                                                ->label('Aspek')
                                                ->weight('bold'),

                                            TextEntry::make('max_raw')
                                                ->label('Nilai Maksimal Mentah'),

                                            TextEntry::make('max_scaled')
                                                ->label('Nilai Skala (0–9)')
                                                ->badge()
                                                ->color('primary'),
                                        ]),
                                ];
                            }),
                        Tab::make('Karakteristik')
                            ->schema(function ($record) {

                                $rows = DB::table('psychotest_option_characteristic_mappings as m')
                                    ->join('psychotest_question_options as o', 'o.id', '=', 'm.option_id')
                                    ->join('psychotest_questions as q', 'q.id', '=', 'o.psychotest_question_id')
                                    ->join('psychotest_characteristics as c', 'c.id', '=', 'm.characteristic_id')
                                    ->where('q.psychotest_form_id', $record->id)
                                    ->select(
                                        'c.id',
                                        'c.name',
                                        DB::raw('SUM(m.weight) as max_raw_score')
                                    )
                                    ->groupBy('c.id', 'c.name')
                                    ->get();

                                if ($rows->isEmpty()) {
                                    return [
                                        TextEntry::make('info_empty')
                                            ->label('Informasi')
                                            ->default('Belum ada mapping karakteristik untuk form ini.'),
                                    ];
                                }

                                $maxCharacteristicData = $rows->map(function ($row) {
                                    return [
                                        'name'        => $row->name,
                                        'max_raw'     => $row->max_raw_score,
                                        'max_scaled'  => 9,
                                    ];
                                })->values()->toArray();

                                return [
                                    RepeatableEntry::make('max_characteristics')
                                        ->label('Nilai Maksimal per Karakteristik')
                                        ->hiddenLabel()
                                        ->state($maxCharacteristicData)
                                        ->table([
                                            TableColumn::make('Karakteristik'),
                                            TableColumn::make('Nilai Maksimal Mentah'),
                                            TableColumn::make('Nilai Skala (0–9)'),
                                        ])
                                        ->schema([
                                            TextEntry::make('name')
                                                ->label('Karakteristik')
                                                ->weight('bold'),

                                            TextEntry::make('max_raw')
                                                ->label('Nilai Maksimal Mentah'),

                                            TextEntry::make('max_scaled')
                                                ->label('Nilai Skala (0–9)')
                                                ->badge()
                                                ->color('primary'),
                                        ]),
                                ];
                            }),
                    ])
            ]);
    }
}
