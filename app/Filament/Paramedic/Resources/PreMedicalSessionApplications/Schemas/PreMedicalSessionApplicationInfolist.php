<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Schemas;

use Carbon\Carbon;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\View;
use Illuminate\Support\Facades\Blade;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use App\Models\PreMedical\PreMedicalEnt;
use App\Models\PreMedical\PreMedicalEye;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use App\Models\PreMedical\PreMedicalPhysical;
use Filament\Infolists\Components\ImageEntry;
use App\Models\PreMedical\PreMedicalItemCheck;
use App\Models\PreMedical\PreMedicalExamSection;
use Filament\Infolists\Components\RepeatableEntry;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class PreMedicalSessionApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                Tabs::make()
                    ->tabs([
                        Tab::make('Informasi Kandidat')
                            ->schema([
                                Section::make('Informasi Pribadi')
                                    ->description('Ringkasan identitas karyawan.')
                                    ->icon(LucideIcon::UserCircle)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        ImageEntry::make('application.user.applicant.photo')
                                            ->label('Foto')
                                            ->circular()
                                            ->checkFileExistence(false) // kalau path langsung berupa URL
                                            ->default(fn($record) => asset('images/include/default-user.jpg'))
                                            ->columnSpan([
                                                'default' => 12,
                                                'sm' => 12,
                                                'md' => 2,
                                                'lg' => 2,
                                            ]),

                                        Grid::make()
                                            ->columns([
                                                'default' => 1,
                                                'sm' => 12,
                                                'md' => 10,
                                                'lg' => 10,
                                            ])
                                            ->columnSpan([
                                                'default' => 12,
                                                'md' => 10,
                                                'lg' => 10,
                                            ])
                                            ->schema([
                                                TextEntry::make('application.user.applicant.full_name')
                                                    ->label('NIK')
                                                    ->icon('heroicon-o-identification')
                                                    ->copyable()
                                                    ->formatStateUsing(function (?string $state) {
                                                        if (!$state) return '—';
                                                        // Spasi setiap 4 digit biar mudah dibaca
                                                        return trim(collect(str_split($state))
                                                            ->chunk(4)
                                                            ->map(fn($c) => $c->implode(''))
                                                            ->implode(' '));
                                                    })
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.user.applicant.phone_number')
                                                    ->label('No. HP')
                                                    ->icon('heroicon-o-phone')
                                                    ->copyable()
                                                    ->formatStateUsing(function (?string $state) {
                                                        if (!$state) return '—';
                                                        // Normalisasi jadi +62 dan hilangkan 0 diawal
                                                        $num = ltrim($state);
                                                        $num = preg_replace('/\D+/', '', $num);
                                                        $num = ltrim($num, '0');
                                                        return '+62 ' . $num;
                                                    })
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.user.email')
                                                    ->label('Email')
                                                    ->icon('heroicon-o-map-pin')
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.user.applicant.place_of_birth')
                                                    ->label('Tempat Lahir')
                                                    ->icon('heroicon-o-map-pin')
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.user.applicant.date_of_birth')
                                                    ->label('Tanggal Lahir')
                                                    ->icon('heroicon-o-calendar')
                                                    ->date('d M Y')
                                                    ->suffix(function ($record) {
                                                        if (!$record?->date_of_birth) return null;
                                                        try {
                                                            return Carbon::parse($record->date_of_birth)->age . ' th';
                                                        } catch (\Throwable $e) {
                                                            return null;
                                                        }
                                                    })
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.user.applicant.gender')
                                                    ->label('Jenis Kelamin')
                                                    ->badge()
                                                    ->formatStateUsing(function (?string $state) {
                                                        return match ($state) {
                                                            'male'   => 'Laki-laki',
                                                            'female' => 'Perempuan',
                                                            default  => 'Tidak diketahui',
                                                        };
                                                    })
                                                    ->color(fn(?string $state) => match ($state) {
                                                        'male' => 'primary',
                                                        'female' => 'warning',
                                                        default => 'gray',
                                                    })
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 2,
                                                    ]),

                                                // Alamat utuh (multi-baris)
                                                TextEntry::make('address_line')
                                                    ->label('Alamat Domisili')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 6,
                                                    ])
                                                    ->state(function ($record) {
                                                        $lines = [
                                                            $record?->application?->user?->applicant?->address_line,
                                                            // Tambahkan baris kecil untuk kode pos / kode desa jika ada
                                                            collect([
                                                                $record?->application?->user?->applicant?->postal_code ?  $record?->application?->user?->applicant?->postal_code : null,
                                                                $record?->application?->user?->applicant?->village?->name ?  $record?->application?->user?->applicant?->village?->name : null,
                                                                $record?->application?->user?->applicant?->regency?->name ?  $record?->application?->user?->applicant?->regency?->name : null,
                                                                $record?->application?->user?->applicant?->district?->name ?  $record?->application?->user?->applicant?->district?->name : null,
                                                                $record?->application?->user?->applicant?->province?->name ?  $record?->application?->user?->applicant?->province?->name : null,
                                                            ])->filter()->implode(' • '),
                                                        ];

                                                        return collect($lines)->filter()->implode("\n");
                                                    })
                                                    ->formatStateUsing(fn($state) => $state ? nl2br(e($state)) : '—')
                                                    ->html(),
                                            ]),
                                    ]),
                            ]),

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
                        Tab::make('Anamesis')->schema([
                            Section::make('Anamesis')->columns(12)->schema([
                                TextEntry::make('preMedicalResult.preMedicalHistory.complaint')->label('Keluhan')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.anamesis')->label('Anamesis')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.personal_history')->label('Riwayat Penyakit Terdahulu')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalHistory.family_history')->label('Riwayat Penyakit Keluarga')->html()->placeholder('-')->columnSpan(12),
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
                            Section::make('Tanda Vital & Pemeriksaan Fisik')
                                ->columns(12)
                                ->schema([

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


                                    TextEntry::make('preMedicalResult.preMedicalPhysical.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                                    // Components generated from Fisik sections

                                    Section::make('Pemeriksaan Fisik')
                                        ->columnSpanFull()
                                        ->schema(function ($record) {
                                            $preMedicalPhysical = $record?->preMedicalResult?->preMedicalPhysical;
                                            $sections = PreMedicalExamSection::with([
                                                'subSections.items.itemChecks' => function ($q) use ($preMedicalPhysical) {
                                                    if ($preMedicalPhysical) {
                                                        $q->where('checkable_id',  $preMedicalPhysical->id)
                                                            ->where('checkable_type', get_class($preMedicalPhysical));
                                                    } else {
                                                        $q->whereNull('id');
                                                    }
                                                }
                                            ])
                                                ->where('type', 'physic')
                                                ->orderBy('order')
                                                ->get();

                                            return $sections->map(function ($section) {
                                                return Section::make($section->name)
                                                    ->schema(
                                                        $section->subSections->map(function ($sub) {

                                                            return Section::make($sub->name)
                                                                ->schema(
                                                                    $sub->items->map(function ($item) {

                                                                        $check = $item->itemChecks->first();

                                                                        return Group::make([
                                                                            TextEntry::make("item_{$item->id}")
                                                                                ->label($item->name)
                                                                                ->state($check?->value ?? '-')
                                                                                ->columnSpan(3),

                                                                            TextEntry::make("note_{$item->id}")
                                                                                ->label('Catatan')
                                                                                ->state($check?->note ?? '-')
                                                                                ->columnSpan(9),
                                                                        ])->columns(12);
                                                                    })->toArray()
                                                                );
                                                        })->toArray()
                                                    );
                                            })->toArray();
                                        })
                                ]),
                        ]),

                        // THT
                        Tab::make('THT')->schema([
                            Section::make('THT')->columns(12)->schema([
                                // TextEntry::make('preMedicalResult.preMedicalEnt.ear')->label('Telinga')->html()->placeholder('-')->columnSpan(12),
                                // TextEntry::make('preMedicalResult.preMedicalEnt.nose')->label('Hidung')->html()->placeholder('-')->columnSpan(12),
                                // TextEntry::make('preMedicalResult.preMedicalEnt.throat')->label('Tenggorokan')->html()->placeholder('-')->columnSpan(12),
                                // TextEntry::make('preMedicalResult.preMedicalEnt.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                                // Components generated from THT sections
                                // ...$entSectionComponents,
                                Section::make('Pemeriksaan Telinga Hidung Tenggorokan')
                                    ->columnSpanFull()
                                    ->schema(function ($record) {
                                        $preMedicalPhysical = $record?->preMedicalResult?->preMedicalPhysical;
                                        $sections = PreMedicalExamSection::with([
                                            'subSections.items.itemChecks' => function ($q) use ($preMedicalPhysical) {
                                                if ($preMedicalPhysical) {
                                                    $q->where('checkable_id',  $preMedicalPhysical->id)
                                                        ->where('checkable_type', get_class($preMedicalPhysical));
                                                } else {
                                                    $q->whereNull('id');
                                                }
                                            }
                                        ])
                                            ->where('type', 'ent')
                                            ->orderBy('order')
                                            ->get();

                                        return $sections->map(function ($section) {
                                            return Section::make($section->name)
                                                ->schema(
                                                    $section->subSections->map(function ($sub) {

                                                        return Section::make($sub->name)
                                                            ->schema(
                                                                $sub->items->map(function ($item) {

                                                                    $check = $item->itemChecks->first();

                                                                    return Group::make([
                                                                        TextEntry::make("item_{$item->id}")
                                                                            ->label($item->name)
                                                                            ->state($check?->value ?? '-')
                                                                            ->columnSpan(3),

                                                                        TextEntry::make("note_{$item->id}")
                                                                            ->label('Catatan')
                                                                            ->state($check?->note ?? '-')
                                                                            ->columnSpan(9),
                                                                    ])->columns(12);
                                                                })->toArray()
                                                            );
                                                    })->toArray()
                                                );
                                        })->toArray();
                                    })
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
                                // TextEntry::make('preMedicalResult.preMedicalEye.color_vision')
                                //     ->label('Buta Warna')
                                //     ->badge()
                                //     ->color(fn($s) => match ($s) {
                                //         'normal' => 'success',
                                //         'partial' => 'warning',
                                //         'total' => 'danger',
                                //         default => 'gray'
                                //     })
                                //     ->formatStateUsing(fn($s) => match ($s) {
                                //         'normal' => 'Normal',
                                //         'partial' => 'Sebagian',
                                //         'total' => 'Total',
                                //         default => '-'
                                //     })
                                //     ->placeholder('-')
                                //     ->columnSpan(12),
                                // TextEntry::make('preMedicalResult.preMedicalEye.conjunctiva')->label('Konjungtiva')->html()->placeholder('-')->columnSpan(12),
                                // TextEntry::make('preMedicalResult.preMedicalEye.sclera')->label('Sclera')->html()->placeholder('-')->columnSpan(12),
                                // TextEntry::make('preMedicalResult.preMedicalEye.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                                // Components generated from Mata sections
                                // ...$eyeSectionComponents,

                                Section::make('Pemeriksaan Mata')
                                    ->columnSpanFull()
                                    ->schema(function ($record) {
                                        $preMedicalPhysical = $record?->preMedicalResult?->preMedicalPhysical;
                                        $sections = PreMedicalExamSection::with([
                                            'subSections.items.itemChecks' => function ($q) use ($preMedicalPhysical) {
                                                if ($preMedicalPhysical) {
                                                    $q->where('checkable_id',  $preMedicalPhysical->id)
                                                        ->where('checkable_type', get_class($preMedicalPhysical));
                                                } else {
                                                    $q->whereNull('id');
                                                }
                                            }
                                        ])
                                            ->where('type', 'eye')
                                            ->orderBy('order')
                                            ->get();

                                        return $sections->map(function ($section) {
                                            return Section::make($section->name)
                                                ->schema(
                                                    $section->subSections->map(function ($sub) {

                                                        return Section::make($sub->name)
                                                            ->schema(
                                                                $sub->items->map(function ($item) {

                                                                    $check = $item->itemChecks->first();

                                                                    return Group::make([
                                                                        TextEntry::make("item_{$item->id}")
                                                                            ->label($item->name)
                                                                            ->state($check?->value ?? '-')
                                                                            ->columnSpan(3),

                                                                        TextEntry::make("note_{$item->id}")
                                                                            ->label('Catatan')
                                                                            ->state($check?->note ?? '-')
                                                                            ->columnSpan(9),
                                                                    ])->columns(12);
                                                                })->toArray()
                                                            );
                                                    })->toArray()
                                                );
                                        })->toArray();
                                    })

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

                        Tab::make('Pemeriksaan Penunjang')->schema([
                            Section::make('Pemeriksaan Penunjang')->columns(12)->schema([
                                TextEntry::make('preMedicalResult.preMedicalSupportingExamination.complete_blood')->label('Darah Lengkap')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalSupportingExamination.colesterol')->label('Kolesterol')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalSupportingExamination.blood_sugar')->label('Gula Darah')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalSupportingExamination.gout')->label('Asam Urat')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalSupportingExamination.ro')->label('Rongen Thorax')->html()->placeholder('-')->columnSpan(12),
                                TextEntry::make('preMedicalResult.preMedicalSupportingExamination.others')->label('Lainnya')->html()->placeholder('-')->columnSpan(12),
                            ]),
                        ]),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
