<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\View;
use Illuminate\Support\Facades\Blade;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Infolists\Components\RepeatableEntry;

class PreMedicalSessionApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->tabs([
                        // RINGKASAN
                        Tab::make('Ringkasan')->schema([
                            Section::make('Kesimpulan')
                                ->columns(12)
                                ->schema([
                                    TextEntry::make('preMedicalResult.examined_at')
                                        ->label('Tanggal Pemeriksaan')
                                        ->dateTime('d M Y H:i')
                                        ->placeholder('-')
                                        ->columnSpan(4),

                                    TextEntry::make('preMedicalResult.overall_status')
                                        ->label('Status Keseluruhan')
                                        ->badge()
                                        ->color(fn($s) => match ($s) {
                                            'fit' => 'success',
                                            'fit_with_notes' => 'warning',
                                            'unfit' => 'danger',
                                            default => 'gray',
                                        })
                                        ->formatStateUsing(fn($s) => match ($s) {
                                            'fit' => 'Sehat',
                                            'fit_with_notes' => 'Sehat dg Catatan',
                                            'unfit' => 'Tidak Sehat',
                                            'pending' => 'Ditunda',
                                            default => '-',
                                        })
                                        ->placeholder('-')
                                        ->columnSpan(3),

                                    TextEntry::make('preMedicalResult.overall_note')
                                        ->label('Catatan Keseluruhan')
                                        ->html()
                                        ->placeholder('-')
                                        ->columnSpan(12),
                                ]),
                        ]),

                        // RIWAYAT KESEHATAN
                        Tab::make('Riwayat')->schema([
                            Section::make('Riwayat Kesehatan')->columns(12)->schema([
                                TextEntry::make('preMedicalResult.preMedicalHistory.personal_history')->label('Riwayat Penyakit')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.family_history')->label('Riwayat Keluarga')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.allergies')->label('Alergi')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.current_medications')->label('Obat Sedang Digunakan')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.past_surgeries')->label('Riwayat Operasi')->html()->placeholder('-')->columnSpan(12),

                                Grid::make()->columns(12)->schema([
                                    TextEntry::make('preMedicalResult.preMedicalHistory.smoking_status')
                                        ->label('Status Merokok')
                                        ->badge()
                                        ->color(fn($s) => match ($s) {
                                            'never' => 'success',
                                            'former' => 'warning',
                                            'current' => 'danger',
                                            default => 'gray'
                                        })
                                        ->formatStateUsing(fn($s) => match ($s) {
                                            'never' => 'Tidak Pernah',
                                            'former' => 'Lama Pernah',
                                            'current' => 'Masih Aktif',
                                            default => '-'
                                        })
                                        ->placeholder('-')
                                        ->columnSpan(6),
                                    TextEntry::make('preMedicalResult.preMedicalHistory.alcohol_use')
                                        ->label('Alkohol')
                                        ->badge()
                                        ->color(fn($s) => match ($s) {
                                            'never' => 'success',
                                            'occasional' => 'warning',
                                            'regular' => 'danger',
                                            default => 'gray'
                                        })
                                        ->formatStateUsing(fn($s) => match ($s) {
                                            'never' => 'Tidak Pernah',
                                            'occasional' => 'Sedikit',
                                            'regular' => 'Sering',
                                            default => '-'
                                        })
                                        ->placeholder('-')
                                        ->columnSpan(6),
                                ]),

                                TextEntry::make('preMedicalResult.preMedicalHistory.other_notes')->label('Catatan Lain')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),

                        // FISIK
                        Tab::make('Fisik')->schema([
                            Section::make('Tanda Vital & Pemeriksaan Fisik')->columns(12)->schema([
                                Grid::make()->columns(12)->schema([
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.height_cm')->label('Tinggi (cm)')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.weight_kg')->label('Berat (kg)')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.temperature_c')->label('Suhu (°C)')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.bmi')
                                        ->label('BMI')
                                        ->badge()
                                        ->color(fn($v) => is_numeric($v) ? ($v < 18.5 ? 'warning' : ($v < 25 ? 'success' : ($v < 30 ? 'warning' : 'danger'))) : 'gray')
                                        ->formatStateUsing(fn($v) => is_numeric($v) ? number_format((float)$v, 1) : ($v ?? '-'))
                                        ->placeholder('-')
                                        ->columnSpan(3),

                                    TextEntry::make('preMedicalResult.preMedicalPhysical.bp_systolic')->label('TD Sistolik')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.bp_diastolic')->label('TD Diastolik')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.heart_rate_bpm')->label('Nadi (bpm)')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalPhysical.resp_rate_per_min')->label('Resp (/menit)')->placeholder('-')->columnSpan(3),
                                ]),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.head_neck')->label('Kepala & Leher')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.chest_heart')->label('Dada & Jantung')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.chest_lung')->label('Dada & Paru')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.abdomen_liver')->label('Abdomen & Ginjal')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.abdomen_spleen')->label('Abdomen & Perut')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.extremities')->label('Ekstremitas')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalPhysical.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),

                        // THT
                        Tab::make('THT')->schema([
                            Section::make('THT')->columns(12)->schema([
                                TextEntry::make('preMedicalResult.preMedicalEnt.ear')->label('Telinga')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalEnt.nose')->label('Hidung')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalEnt.throat')->label('Tenggorokan')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalEnt.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),

                        // MATA
                        Tab::make('Mata')->schema([
                            Section::make('Mata')->columns(12)->schema([
                                Grid::make()->columns(12)->schema([
                                    TextEntry::make('preMedicalResult.preMedicalEye.va_unaided_right')->label('Tanpa Kacamata (Kanan)')->placeholder('-')->columnSpan(6),
                                    TextEntry::make('preMedicalResult.preMedicalEye.va_unaided_left')->label('Tanpa Kacamata (Kiri)')->placeholder('-')->columnSpan(6),
                                    TextEntry::make('preMedicalResult.preMedicalEye.va_aided_right')->label('Dengan Kacamata (Kanan)')->placeholder('-')->columnSpan(6),
                                    TextEntry::make('preMedicalResult.preMedicalEye.va_aided_left')->label('Dengan Kacamata (Kiri)')->placeholder('-')->columnSpan(6),
                                ]),
                                TextEntry::make('preMedicalResult.preMedicalEye.color_vision')
                                    ->label('Buta Warna')
                                    ->badge()
                                    ->color(fn($s) => match ($s) {
                                        'normal' => 'success',
                                        'partial' => 'warning',
                                        'total' => 'danger',
                                        default => 'gray'
                                    })
                                    ->formatStateUsing(fn($s) => match ($s) {
                                        'normal' => 'Normal',
                                        'partial' => 'Sebagian',
                                        'total' => 'Total',
                                        default => '-'
                                    })
                                    ->placeholder('-')
                                    ->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalEye.conjunctiva')->label('Konjungtiva')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalEye.sclera')->label('Sclera')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalEye.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),

                        // GIGI
                        Tab::make('Gigi')->schema([
                            Section::make('Temuan per Gigi')->schema([
                                RepeatableEntry::make('preMedicalResult.preMedicalDental.preMedicalDentalFindings')
                                    ->label('Temuan')
                                    ->schema([
                                        TextEntry::make('dentalTeeth.name')
                                            ->label('Gigi')
                                            ->formatStateUsing(function ($state, $record) {
                                                $t = $record?->dentalTeeth;
                                                return $t
                                                    ? "{$t->fdi_code} - {$t->name} ({$t->tooth_type}, {$t->dentition}) · No {$t->tooth_number} Q{$t->quadrant}"
                                                    : '-';
                                            })
                                            ->columnSpan(4),
                                        TextEntry::make('dentalStatus.description')->label('Status')->badge()->color('info')->placeholder('-')->columnSpan(3),
                                        TextEntry::make('surface')
                                            ->label('Lapisan')
                                            ->badge()
                                            ->color('gray')
                                            ->formatStateUsing(fn($s) => match ($s) {
                                                'O' => 'Occlusal',
                                                'M' => 'Mesial',
                                                'D' => 'Distal',
                                                'B' => 'Buccal',
                                                'L' => 'Lingual',
                                                'P' => 'Palatal',
                                                'I' => 'Incisal',
                                                'F' => 'Facial',
                                                'W' => 'Whole',
                                                default => $s ?? '-'
                                            })
                                            ->columnSpan(3),
                                        TextEntry::make('severity')
                                            ->label('Kerusakan')
                                            ->badge()
                                            ->color(fn($s) => match ($s) {
                                                'mild' => 'success',
                                                'moderate' => 'warning',
                                                'severe' => 'danger',
                                                default => 'gray'
                                            })
                                            ->formatStateUsing(fn($s) => match ($s) {
                                                'mild' => 'Ringan',
                                                'moderate' => 'Sedang',
                                                'severe' => 'Parah',
                                                default => '-'
                                            })
                                            ->columnSpan(2),
                                        TextEntry::make('notes')->label('Catatan')->placeholder('-')->columnSpan(12),
                                    ]),
                            ]),
                            Section::make('Ringkasan Gigi')->columns(12)->schema([
                                TextEntry::make('preMedicalResult.preMedicalDental.general_condition')->label('Pemeriksaan Umum')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalDental.occlusion')->label('Oklusi')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalDental.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),

                        // OBGYN
                        Tab::make('Obgyn')->schema([
                            Section::make('Kandungan')->columns(12)->schema([
                                Grid::make()->columns(12)->schema([
                                    TextEntry::make('preMedicalResult.preMedicalObgyn.is_pregnant')
                                        ->label('Sedang Hamil?')
                                        ->badge()
                                        ->color(fn($v) => $v === null ? 'gray' : ($v ? 'success' : 'danger'))
                                        ->formatStateUsing(fn($v) => $v === true ? 'Ya' : 'Tidak')
                                        ->placeholder('-')
                                        ->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalObgyn.lmp_date')->label('HPHT')->date('d M Y')->placeholder('-')->columnSpan(3),
                                    TextEntry::make('preMedicalResult.preMedicalObgyn.gravida')->label('G')->placeholder('-')->columnSpan(2),
                                    TextEntry::make('preMedicalResult.preMedicalObgyn.para')->label('P')->placeholder('-')->columnSpan(2),
                                    TextEntry::make('preMedicalResult.preMedicalObgyn.abortus')->label('A')->placeholder('-')->columnSpan(2),
                                ])
                                ->columnSpanFull(),
                                TextEntry::make('preMedicalResult.preMedicalObgyn.uterus_exam')->label('Uterus')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalObgyn.adnexa_exam')->label('Adnexa')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalObgyn.cervix_exam')->label('Cervix')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalObgyn.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
