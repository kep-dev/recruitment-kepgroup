<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Schemas;

use Carbon\Carbon;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class ApplicantTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Informasi Kandidat')
                            ->schema([
                                Section::make('Informasi')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('application.applicant.user.name')
                                            ->label('Kandidat'),

                                        TextEntry::make('application.jobVacancy.title')
                                            ->label('Melamar pada lowongan'),

                                    ])
                                    ->columnSpanFull(),

                                Section::make('Informasi Pribadi')
                                    ->description('Ringkasan identitas karyawan.')
                                    ->icon(LucideIcon::UserCircle)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        ImageEntry::make('application.applicant.user.photo')
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
                                                TextEntry::make('application.applicant.nik')
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

                                                TextEntry::make('application.applicant.phone_number')
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

                                                TextEntry::make('application.applicant.user.email')
                                                    ->label('Email')
                                                    ->icon('heroicon-o-map-pin')
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.applicant.place_of_birth')
                                                    ->label('Tempat Lahir')
                                                    ->icon('heroicon-o-map-pin')
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('application.applicant.date_of_birth')
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

                                                TextEntry::make('application.applicant.gender')
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
                                                TextEntry::make('application.applicant.address_line')
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

                                Section::make('Pendidikan Terakhir')
                                    ->description('Ringkasan pendidikan terakhir.')
                                    ->icon(LucideIcon::GraduationCap)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.educations')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Jenjang Pendidikan'),
                                                TableColumn::make('Jurusan'),
                                                TableColumn::make('Sekolah/Universitas'),
                                                TableColumn::make('Nomor Induk'),
                                                TableColumn::make('Lokasi'),
                                                TableColumn::make('Tahun Lulus'),
                                                TableColumn::make('Nilai Akhir'),
                                                TableColumn::make('Nomor Ijazah'),
                                            ])
                                            ->schema([
                                                TextEntry::make('education_level'),
                                                TextEntry::make('major'),
                                                TextEntry::make('university'),
                                                TextEntry::make('main_number'),
                                                TextEntry::make('location'),
                                                TextEntry::make('graduation_year'),
                                                TextEntry::make('gpa'),
                                                TextEntry::make('certificate_number'),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Riwayat Pekerjaan')
                                    ->description('Ringkasan riwayat pekerjaan.')
                                    ->icon(LucideIcon::BriefcaseBusiness)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.workExperiences')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Nama Pekerjaan'),
                                                TableColumn::make('Perusahaan'),
                                                TableColumn::make('Jabatan'),
                                                TableColumn::make('Industri'),
                                                TableColumn::make('Mulai'),
                                                TableColumn::make('Selesai'),
                                                TableColumn::make('Masih Bekerja'),
                                                TableColumn::make('Deskripsi'),
                                            ])
                                            ->schema([
                                                TextEntry::make('job_title'),
                                                TextEntry::make('company_name'),
                                                TextEntry::make('job_position'),
                                                TextEntry::make('industry'),
                                                TextEntry::make('start_date')
                                                    ->date(),
                                                TextEntry::make('end_date')
                                                    ->date(),
                                                TextEntry::make('currently_working')
                                                    ->formatStateUsing(fn($state) => $state === true ? 'Ya' : 'Tidak'),
                                                TextEntry::make('description')
                                                    ->limit(50)
                                                    ->tooltip(function (TextEntry $component): ?string {
                                                        $state = $component->getState();

                                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                                            return null;
                                                        }

                                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                                        return $state;
                                                    }),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Pengalaman Organisasi')
                                    ->description('Ringkasan pengalaman organisasi.')
                                    ->icon(LucideIcon::Building2)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.organizationalExperiences')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Nama Organisasi'),
                                                TableColumn::make('Posisi'),
                                                TableColumn::make('Jabatan'),
                                                TableColumn::make('Mulai'),
                                                TableColumn::make('Selesai'),
                                            ])
                                            ->schema([
                                                TextEntry::make('organization_name'),
                                                TextEntry::make('position'),
                                                TextEntry::make('level'),
                                                TextEntry::make('start_date')
                                                    ->date(),
                                                TextEntry::make('end_date')
                                                    ->date(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Pelatihan & Sertifikasi')
                                    ->description('Ringkasan pelatihan & sertifikasi.')
                                    ->icon(LucideIcon::Copyright)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.trainingCertifications')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Nama Sertifikasi'),
                                                TableColumn::make('Institusi'),
                                                TableColumn::make('Jenis'),
                                                TableColumn::make('Lokasi'),
                                                TableColumn::make('Mulai'),
                                                TableColumn::make('Selesai'),
                                                TableColumn::make('Deskripsi'),
                                            ])
                                            ->schema([
                                                TextEntry::make('training_certification_title'),
                                                TextEntry::make('institution_name'),
                                                TextEntry::make('type'),
                                                TextEntry::make('location'),
                                                TextEntry::make('start_date')
                                                    ->date(),
                                                TextEntry::make('end_date')
                                                    ->date(),
                                                TextEntry::make('description')
                                                    ->limit(50)
                                                    ->tooltip(function (TextEntry $component): ?string {
                                                        $state = $component->getState();

                                                        if (strlen($state) <= $component->getCharacterLimit()) {
                                                            return null;
                                                        }

                                                        // Only render the tooltip if the entry contents exceeds the length limit.
                                                        return $state;
                                                    }),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Prestasi')
                                    ->description('Ringkasan prestasi.')
                                    ->icon(LucideIcon::Award)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.achievements')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Nama Prestasi'),
                                                TableColumn::make('Organisasi'),
                                                TableColumn::make('Tahun'),
                                            ])
                                            ->schema([
                                                TextEntry::make('achievement_name'),
                                                TextEntry::make('organization_name'),
                                                TextEntry::make('year'),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Bahasa yang dikuasai')
                                    ->description('Ringkasan bahasa yang dikuasai.')
                                    ->icon(LucideIcon::Languages)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.languages')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Nama Bahasa'),
                                                TableColumn::make('Tingkat'),
                                            ])
                                            ->schema([
                                                TextEntry::make('language'),
                                                TextEntry::make('level'),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Skill yang dikuasai')
                                    ->description('Ringkasan skill yang dikuasai.')
                                    ->icon(LucideIcon::Languages)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.skills')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Kemampuan'),
                                            ])
                                            ->schema([
                                                TextEntry::make('skill'),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Media Sosial')
                                    ->description('Daftar media sosial kandidat karyawan.')
                                    ->icon(LucideIcon::Link2)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('application.user.socialMedias')
                                            ->hiddenLabel()
                                            ->table([
                                                TableColumn::make('Media Sosial'),
                                                TableColumn::make('Link'),
                                            ])
                                            ->schema([
                                                TextEntry::make('name'),
                                                TextEntry::make('url')
                                                    ->formatStateUsing(function (?string $state) {
                                                        if (! $state) {
                                                            return '-';
                                                        }

                                                        // Pastikan URL punya protokol
                                                        $url = str_starts_with($state, 'https://')
                                                            ? $state
                                                            : 'https://' . $state;

                                                        return "<a href=\"{$url}\" target=\"_blank\" class=\"text-primary-600 hover:underline\">
                                                                    {$url}
                                                                </a>";
                                                    })
                                                    ->html(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Dokumen Pendukung')
                                ->description('Daftar dokumen pendukung kandidat karyawan.')
                                ->icon(LucideIcon::Link2)
                                ->collapsible()
                                ->columns(12)
                                ->schema([
                                    RepeatableEntry::make('application.user.documents')
                                        ->hiddenLabel()
                                        ->table([
                                            TableColumn::make('Nama Dokumen'),
                                        ])
                                        ->schema([
                                            TextEntry::make('vacancyDocument.name')
                                                ->icon(LucideIcon::Download)
                                                ->url(fn($record) => $record->getFirstMediaUrl($record->vacancyDocument->name))
                                                ->openUrlInNewTab()
                                                ->formatStateUsing(fn($state) => $state ?? 'Tidak ada dokumen'),
                                        ])
                                        ->columnSpanFull(),
                                ]),

                            ]),

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
                            ->visible(function ($record) {
                                return $record->jobVacancyTest->type == 'general';
                            }) // Placeholder, implement when academic potential tests are available
                            ->columnSpanFull(),

                        Tab::make('Psikotest')
                            ->visible(function ($record) {
                                return $record->jobVacancyTest->type == 'psychotest';
                            })
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

                                // dd($attempt->answers);

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
                                // dd($attempt->characteristics);
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
                                    // ds($charResults);
                                    $groupedByAspect = $charResults
                                        ->sortBy(fn($item) => optional($item->characteristic->psychotestAspect)->order ?? PHP_INT_MAX)
                                        ->groupBy(function ($item) {
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
