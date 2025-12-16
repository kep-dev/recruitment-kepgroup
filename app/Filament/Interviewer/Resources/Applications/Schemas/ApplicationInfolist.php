<?php

namespace App\Filament\Interviewer\Resources\Applications\Schemas;

use Carbon\Carbon;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\View;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Nama')
                            ->columnSpan(3),
                        TextEntry::make('user.email')
                            ->label('Email')
                            ->columnSpan(3),
                        TextEntry::make('jobVacancy.title')
                            ->label('Pekerjaan Yang Dilamar')
                            ->columnSpan(3),
                        TextEntry::make('final_status')
                            ->label('Status')
                            ->columnSpan(3),

                        IconEntry::make('is_submitted')
                            ->label('Sudah diajukan ke ERP')
                            ->boolean()
                            ->trueIcon(Heroicon::OutlinedCheckBadge)
                            ->falseIcon(Heroicon::OutlinedXMark)
                            ->columnSpan(3),

                        TextEntry::make('submitted_at')
                            ->label('Diajukan Pada')
                            ->dateTime('d M Y H:i')
                            ->columnSpan(3),

                        TextEntry::make('submittedBy.name')
                            ->label('Diajukan Oleh')
                            ->columnSpan(3),
                    ]),

                View::make('filament.schemas.components.applicant.application-result')
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([
                        Tabs::make('Tabs')
                            ->columnSpanFull()
                            ->contained(false)
                            ->tabs([
                                Tab::make('Informasi Kandidat')
                                    ->schema([
                                        Section::make('Informasi')
                                            ->columns(3)
                                            ->schema([
                                                TextEntry::make('user.name')
                                                    ->label('Kandidat'),

                                                TextEntry::make('interviewSession.title')
                                                    ->label('Sesi'),

                                                TextEntry::make('interviewSession.interview.name')
                                                    ->label('Form Wawancara'),
                                            ])
                                            ->columnSpanFull(),

                                        Section::make('Informasi Pribadi')
                                            ->description('Ringkasan identitas karyawan.')
                                            ->icon(LucideIcon::UserCircle)
                                            ->collapsible()
                                            ->columns(12)
                                            ->schema([
                                                ImageEntry::make('applicant.photo')
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
                                                        TextEntry::make('applicant.nik')
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

                                                        TextEntry::make('applicant.phone_number')
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

                                                        TextEntry::make('user.email')
                                                            ->label('Email')
                                                            ->icon('heroicon-o-map-pin')
                                                            ->placeholder('—')
                                                            ->columnSpan([
                                                                'default' => 1,
                                                                'lg' => 3,
                                                            ]),

                                                        TextEntry::make('applicant.place_of_birth')
                                                            ->label('Tempat Lahir')
                                                            ->icon('heroicon-o-map-pin')
                                                            ->placeholder('—')
                                                            ->columnSpan([
                                                                'default' => 1,
                                                                'lg' => 3,
                                                            ]),

                                                        TextEntry::make('applicant.date_of_birth')
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

                                                        TextEntry::make('applicant.gender')
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

                                        Section::make('Pendidikan Terakhir')
                                            ->description('Ringkasan pendidikan terakhir.')
                                            ->icon(LucideIcon::GraduationCap)
                                            ->collapsible()
                                            ->columns(12)
                                            ->schema([
                                                RepeatableEntry::make('user.educations')
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
                                                RepeatableEntry::make('user.workExperiences')
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
                                                RepeatableEntry::make('user.organizationalExperiences')
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
                                                RepeatableEntry::make('user.trainingCertifications')
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
                                                RepeatableEntry::make('user.achievements')
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
                                                RepeatableEntry::make('user.languages')
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
                                                RepeatableEntry::make('user.skills')
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
                                                RepeatableEntry::make('user.socialMedias')
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
                                                RepeatableEntry::make('user.documents')
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

                                Tab::make('Hasil Tes')
                                    ->schema([
                                        Section::make('Hasil tes potensi dasar akademik')
                                            ->schema([

                                                TextEntry::make('average_score')
                                                    ->label('Rata-rata Skor')
                                                    ->state(function ($record) {
                                                        if (! $record) {
                                                            return '-';
                                                        }

                                                        // Eager-load attempts and related multiplier from DB to ensure data present
                                                        $applicantTests = $record->applicantTests()
                                                            ->with(['attempts.jobVacancyTestItem'])
                                                            ->get();

                                                        $attempts = $applicantTests->flatMap(fn($at) => collect($at->attempts ?? []));

                                                        $values = $attempts->map(function ($attempt) {
                                                            $score = $attempt->score ?? 0;
                                                            $mult = $attempt->jobVacancyTestItem?->multiplier ?? 1;
                                                            return $score * $mult;
                                                        });

                                                        if ($values->isEmpty()) {
                                                            return '-';
                                                        }

                                                        return number_format($values->avg(), 2);
                                                    }),

                                                RepeatableEntry::make('applicantTests.attempts')
                                                    ->hiddenLabel(true)
                                                    ->table([
                                                        TableColumn::make('Soal'),
                                                        TableColumn::make('Skor Minimal'),
                                                       TableColumn::make('Skor'),
                                                       TableColumn::make('Keterangan'),
                                                    ])
                                                    ->schema([
                                                        TextEntry::make('test.title'),
                                                        TextEntry::make('jobVacancyTestItem.minimum_score'),
                                                        TextEntry::make('score')
                                                            ->state(fn($record) => (
                                                                ($record->score ?? 0) * (
                                                                    $record->jobVacancyTestItem?->multiplier ?? 1
                                                                )
                                                            )),
                                                        TextEntry::make('keterangan')
                                                            ->label('Keterangan')
                                                            ->state(function ($record) {
                                                                $score = ($record->score ?? 0) * ($record->jobVacancyTestItem?->multiplier ?? 1);
                                                                $minimum = $record->jobVacancyTestItem?->minimum_score ?? 0;

                                                                if (!is_numeric($score) || !is_numeric($minimum)) {
                                                                    return '-';
                                                                }

                                                                return $score >= $minimum ? 'Di atas minimal' : 'Di bawah minimal';
                                                            }),
                                                    ])
                                                    ->columnSpanFull()
                                            ])
                                            ->columnSpanFull()
                                    ]),
                                Tab::make('Hasil Interview')
                                    ->columns(12)
                                    ->schema([
                                        Section::make('Ketentuan Nilai')
                                            ->schema([
                                                Grid::make(4)
                                                    ->schema([
                                                        TextEntry::make('kurang')
                                                            ->label('Kurang')
                                                            ->badge()
                                                            ->color('danger')
                                                            ->state('1'),

                                                        TextEntry::make('cukup')
                                                            ->label('Cukup')
                                                            ->badge()
                                                            ->color('warning')
                                                            ->state('2'),

                                                        TextEntry::make('baik')
                                                            ->label('Baik')
                                                            ->badge()
                                                            ->color('primary')
                                                            ->state('3'),

                                                        TextEntry::make('sangat_baik')
                                                            ->label('Sangat Baik')
                                                            ->badge()
                                                            ->color('success')
                                                            ->state('4'),
                                                    ])

                                            ])
                                            ->columnSpanFull(),

                                        RepeatableEntry::make('interviewSessionApplications')
                                            ->columns(12)
                                            ->hiddenLabel(true)
                                            ->schema([
                                                TextEntry::make('interviewSession.title')
                                                    ->label('Sesi Interview')
                                                    ->columnSpan(4),
                                                TextEntry::make('interviewSession.scheduled_at')
                                                    ->label('Tanggal Mulai')
                                                    ->columnSpan(4),
                                                TextEntry::make('interviewSession.scheduled_end_at')
                                                    ->label('Tanggal Selesai')
                                                    ->columnSpan(4),

                                                TextEntry::make('avg_application_evaluation_sum')
                                                    ->label('Rata-rata Jumlah Nilai (Sesi)')
                                                    ->state(function ($record) {
                                                        if (! $record) {
                                                            return '-';
                                                        }

                                                        // Load evaluations with scores for this interviewSessionApplication
                                                        $evaluations = collect($record->evaluations()?->with('scores')->get() ?? []);

                                                        // For each evaluation compute its average (same logic as average_evaluation_score),
                                                        // then compute the average of those averages.
                                                        $averages = $evaluations->map(function ($eval) {
                                                            $scores = collect($eval->scores ?? []);
                                                            $values = $scores->map(fn($s) => $s->scale_value_snapshot)
                                                                ->filter(fn($v) => is_numeric($v))
                                                                ->map(fn($v) => (float) $v);

                                                            if ($values->isEmpty()) {
                                                                return null;
                                                            }

                                                            return $values->avg();
                                                        })->filter(fn($v) => $v !== null)->values();

                                                        if ($averages->isEmpty()) {
                                                            return '-';
                                                        }

                                                        return number_format($averages->avg(), 2);
                                                    })
                                                    ->badge()
                                                    ->color(function ($state) {
                                                        if (!is_numeric($state)) {
                                                            return 'secondary';
                                                        }

                                                        return match (true) {
                                                            $state <= 2 => 'danger',
                                                            $state < 3 => 'warning',
                                                            $state < 4 => 'primary',
                                                            default => 'success',
                                                        };
                                                    })
                                                    ->columnSpan(4),

                                                RepeatableEntry::make('evaluations')
                                                    ->columns(12)
                                                    ->hiddenLabel()
                                                    ->contained(false)
                                                    ->schema([
                                                        TextEntry::make('evaluatorUser.name')
                                                            ->label('Penilai')
                                                            ->columnSpan(4),
                                                        TextEntry::make('recommendation')
                                                            ->label('Rekomendasi')
                                                            ->columnSpan(4),

                                                        TextEntry::make('average_evaluation_score')
                                                            ->label('Rata-rata Nilai')
                                                            ->state(function ($record) {
                                                                $scores = collect($record?->scores ?? []);
                                                                $values = $scores->map(fn($s) => $s->scale_value_snapshot)
                                                                    ->filter(fn($v) => is_numeric($v))
                                                                    ->map(fn($v) => (float) $v);

                                                                if ($values->isEmpty()) {
                                                                    return '-';
                                                                }

                                                                return number_format($values->avg(), 2);
                                                            })
                                                            ->badge()
                                                            ->color(function ($state) {
                                                                if (!is_numeric($state)) {
                                                                    return 'secondary';
                                                                }

                                                                return match (true) {
                                                                    $state <= 2 => 'danger',
                                                                    $state < 3 => 'warning',
                                                                    $state < 4 => 'primary',
                                                                    default => 'success',
                                                                };
                                                            })
                                                            ->columnSpan(4),

                                                        TextEntry::make('overall_comment')
                                                            ->label('Catatan')
                                                            ->columnSpanFull(),

                                                        RepeatableEntry::make('scores')
                                                            ->hiddenLabel()
                                                            ->contained(false)
                                                            ->table([
                                                                TableColumn::make('Kriteria'),
                                                                TableColumn::make('Label'),
                                                                TableColumn::make('Nilai'),
                                                                TableColumn::make('Keterangan'),
                                                            ])
                                                            ->schema([
                                                                TextEntry::make('criteria.label'),
                                                                TextEntry::make('scaleOption.label'),
                                                                TextEntry::make('scale_value_snapshot'),
                                                                TextEntry::make('comment'),
                                                            ])
                                                            ->columnSpanFull(),

                                                    ])
                                                    ->columnSpanFull(),

                                            ])
                                            ->columnSpanFull()
                                    ]),
                                Tab::make('Hasil Pre Medical Check Up')
                                    ->columns(12)
                                    ->schema([
                                        RepeatableEntry::make('preMedicalSessionApplications')
                                            ->columns(12)
                                            ->hiddenLabel(true)
                                            ->schema([
                                                TextEntry::make('preMedicalResult.overall_status')
                                                    ->label('Hasil')
                                                    ->columnSpan(4),
                                                TextEntry::make('preMedicalResult.examinedBy.name')
                                                    ->label('Diperiksa Oleh')
                                                    ->columnSpan(4),
                                                TextEntry::make('preMedicalResult.overall_note')
                                                    ->label('Diperiksa Oleh')
                                                    ->html()
                                                    ->columnSpanFull(),

                                                Section::make('Anamnesis')
                                                    ->collapsed()
                                                    ->label('Anamnesis')
                                                    ->columns(12)
                                                    ->schema([
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.complaint')
                                                            ->label('Keluhan Utama')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.anamesis')
                                                            ->label('Anamesis')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.personal_history')
                                                            ->label('Riwayat Pribadi')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.family_history')
                                                            ->label('Riwayat Keluarga')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.allergies')
                                                            ->label('Alergi')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.current_medications')
                                                            ->label('Obat yang sedang digunakan')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.past_surgeries')
                                                            ->label('Riwayat Operasi')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.other_notes')
                                                            ->label('Catatan Lain')
                                                            ->html()
                                                            ->columnSpan(4),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.smoking_status')
                                                            ->label('Status Merokok')
                                                            ->columnSpanFull(),
                                                        TextEntry::make('preMedicalResult.preMedicalHistory.alcohol_use')
                                                            ->label('Penggunaan Alkohol')
                                                            ->columnSpanFull(),
                                                    ])->columnSpanFull(),

                                                Section::make('Pemeriksaan Fisik')
                                                    ->collapsed()
                                                    ->label('Pemeriksaan Fisik')
                                                    ->columns(12)
                                                    ->schema([
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.height_cm')
                                                            ->label('Tinggi Badan')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.weight_kg')
                                                            ->label('Berat Badan')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.bp_systolic')
                                                            ->label('Tekanan Darah')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.bp_diastolic')
                                                            ->label('Tekanan Darah Diastolik')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.heart_rate_bpm')
                                                            ->label('Nadi')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.resp_rate_per_min')
                                                            ->label('Respirasi')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.temperature_c')
                                                            ->label('Suhu Tubuh')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.bmi')
                                                            ->label('Indeks Massa Tubuh')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.blood_type')
                                                            ->label('Golongan Darah')
                                                            ->columnSpanFull(),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.head_neck')
                                                            ->label('Lidah dan Mulut')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.chest_heart')
                                                            ->label('Jantung')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.chest_lung')
                                                            ->label('Paru-Paru')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.abdomen_spleen')
                                                            ->label('Abdomen')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.extremities')
                                                            ->label('Telinga, Kaki, dan Tangan')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalPhysical.others')
                                                            ->label('Lain-lain')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                    ])
                                                    ->columnSpanFull(),

                                                Section::make('Pemeriksaan THT')
                                                    ->collapsed()
                                                    ->label('Pemeriksaan THT')
                                                    ->columns(12)
                                                    ->schema([
                                                        TextEntry::make('preMedicalResult.preMedicalEnt.ear')
                                                            ->label('Telinga')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalEnt.nose')
                                                            ->label('Nose')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalEnt.throat')
                                                            ->label('Tenggorokan')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalEnt.others')
                                                            ->label('Lain-lain')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                    ])
                                                    ->columnSpanFull(),

                                                Section::make('Pemeriksaan Mata')
                                                    ->collapsed()
                                                    ->label('Pemeriksaan Mata')
                                                    ->columns(12)
                                                    ->schema([
                                                        TextEntry::make('preMedicalResult.preMedicalEye.color_vision')
                                                            ->label('Buta Warna')
                                                            ->badge()
                                                            ->columnSpanFull(),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.va_unaided_left')
                                                            ->label('Mata Kiri Tanpa Bantuan')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.va_unaided_right')
                                                            ->label('Mata Kanan Tanpa Bantuan')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.va_aided_left')
                                                            ->label('Mata Kanan Dengan Bantuan')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.va_aided_right')
                                                            ->label('Mata Kiri Dengan Bantuan')
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.conjuctiva')
                                                            ->label('Pemeriksaan Conjuctiva')
                                                            ->html()
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.sclera')
                                                            ->label('Pemeriksaan Sclera')
                                                            ->html()
                                                            ->columnSpan(3),
                                                        TextEntry::make('preMedicalResult.preMedicalEye.others')
                                                            ->label('Lain-lain')
                                                            ->html()
                                                            ->columnSpan(3),
                                                    ])
                                                    ->columnSpanFull(),

                                                Section::make('Pemeriksaan Gigi')
                                                    ->collapsed()
                                                    ->label('Pemeriksaan Gigi')
                                                    ->columns(12)
                                                    ->schema([
                                                        TextEntry::make('preMedicalResult.preMedicalDental.general_condititon')
                                                            ->label('Kondisi Umum')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalDental.occlusion')
                                                            ->label('Penempatan Gigi')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalDental.others')
                                                            ->label('Lain-lain')
                                                            ->columnSpan(3)
                                                            ->html(),

                                                        RepeatableEntry::make('preMedicalResult.preMedicalDental.preMedicalDentalFindings')
                                                            ->hiddenLabel()
                                                            ->table([
                                                                TableColumn::make('Gigi'),
                                                                TableColumn::make('Status'),
                                                                TableColumn::make('Lapisan'),
                                                                TableColumn::make('Kerusakan'),
                                                                TableColumn::make('Catatan'),
                                                            ])
                                                            ->schema([
                                                                TextEntry::make('dentalTeeth.name')
                                                                    ->label('Gigi')
                                                                    ->formatStateUsing(function ($state, $record) {
                                                                        $t = $record?->dentalTeeth;
                                                                        return $t
                                                                            ? "{$t->fdi_code} - {$t->name} ({$t->tooth_type}, {$t->dentition}) · No {$t->tooth_number} Q{$t->quadrant}"
                                                                            : '-';
                                                                    }),
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
                                                                    }),
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
                                                                    }),
                                                                TextEntry::make('notes')->label('Catatan')->placeholder('-'),
                                                            ])
                                                            ->columnSpanFull()
                                                    ])
                                                    ->columnSpanFull(),

                                                Section::make('Pemeriksaan Kandungan')
                                                    ->collapsed()
                                                    ->label('Pemeriksaan Kandungan')
                                                    ->columns(12)
                                                    ->schema([
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
                                                        TextEntry::make('preMedicalResult.preMedicalObgyn.uterus_exam')->label('Uterus')->html()->placeholder('-')->columnSpanFull(),
                                                        TextEntry::make('preMedicalResult.preMedicalObgyn.adnexa_exam')->label('Adnexa')->html()->placeholder('-')->columnSpanFull(),
                                                        TextEntry::make('preMedicalResult.preMedicalObgyn.cervix_exam')->label('Cervix')->html()->placeholder('-')->columnSpanFull(),
                                                        TextEntry::make('preMedicalResult.preMedicalObgyn.others')->label('Lainnya')->html()->placeholder('-')->columnSpanFull(),
                                                    ])
                                                    ->columnSpanFull(),

                                                Section::make('Pemeriksaan Penunjang')
                                                    ->collapsed()
                                                    ->label('Pemeriksaan Penunjang')
                                                    ->columns(12)
                                                    ->schema([
                                                        TextEntry::make('preMedicalResult.preMedicalSupportingExamination.complete_blood')
                                                            ->label('Pemeriksaan Darah Lengkap')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalSupportingExamination.colestrol')
                                                            ->label('Pemeriksaan Kolestrol')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalSupportingExamination.blood_sugar')
                                                            ->label('Pemeriksaan Gula Darah')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalSupportingExamination.gout')
                                                            ->label('Pemeriksaan Asam Urat')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalSupportingExamination.ro')
                                                            ->label('Pemeriksaan Thorax')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                        TextEntry::make('preMedicalResult.preMedicalSupportingExamination.others')
                                                            ->label('Pemeriksaan Lainnya')
                                                            ->columnSpan(3)
                                                            ->html(),
                                                    ])
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Hasil Psikotest')
                                    ->columns(12)
                                    ->schema(function ($record): array {
                                        $components = [];

                                        // 1. Ambil 1 attempt psikotest (misal terbaru) dari relasi
                                        $applicantTest = $record->applicantPsychotest; // relasi ke ApplicantTest
                                        $attempt = $applicantTest?->psychotestAttempts()
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
                            ]),
                    ]),
            ]);
    }
}
