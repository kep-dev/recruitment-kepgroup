<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages;

use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\InterviewScale;
use Filament\Support\Enums\Width;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Models\InterviewEvaluation;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use App\Models\InterviewEvaluationScore;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use App\Models\InterviewSessionEvaluator;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Validation\ValidationException;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use App\Models\Psychotest\PsychotestCharacteristicScore;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\InterviewSessionApplicationResource;

class GiveAnAssessmentPage extends Page implements HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = InterviewSessionApplicationResource::class;

    protected string $view = 'filament.interviewer.resources.interview-session-applications.pages.give-an-assessment-page';

    protected static ?string $title = 'Penilaian Interview';

    public array $data = [
        'scores' => [],
        'recommendation' => null,
        'overall_comment' => null,
    ];

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function mount(int|string $record): void
    {
        // $this->form->fill();
        $this->record = $record = $this->resolveRecord($record)->load(['interviewSession.interviewForm', 'application.user']);

        $isEvaluator = InterviewSessionEvaluator::query()
            ->where('interview_session_id', $record->interview_session_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (! $isEvaluator) {
            abort(403, 'Anda bukan evaluator pada sesi ini.');
        }

        // Prefill jika sudah pernah menilai
        $existingEval = InterviewEvaluation::query()
            ->where('interview_session_application_id', $record->id)
            ->where('interview_session_evaluator_id', function ($q) use ($record) {
                $q->select('id')
                    ->from('interview_session_evaluators')
                    ->where('interview_session_id', $record->interview_session_id)
                    ->where('user_id', Auth::id());
            })
            ->with('scores') // pastikan relasi ada
            ->first();

        if ($existingEval) {
            $this->data['recommendation']  = $existingEval->recommendation;
            $this->data['overall_comment'] = $existingEval->overall_comment;
            $this->data['scores'] = $existingEval->scores->map(function ($s) {
                return [
                    'interview_criteria_id'  => $s->interview_criteria_id,
                    'interview_scale_id'     => $s->interview_scale_id,
                    'scale_label_snapshot'   => $s->scale_label_snapshot,
                    'scale_value_snapshot'   => $s->scale_value_snapshot,
                    'score_numeric'          => (float) $s->score_numeric,
                    'comment'                => $s->comment,
                ];
            })->values()->all();
        } else {
            // Prefill baris kosong: semua kriteria dari interview
            $criteria = DB::table('interview_criterias')
                ->where('interview_id', $record->interviewSession->interview_id)
                ->orderBy('order')
                ->get(['id']);

            $this->data['scores'] = $criteria->map(fn($c) => [
                'interview_criteria_id'  => $c->id,
                'interview_scale_id'     => null,
                'scale_label_snapshot'   => null,
                'scale_value_snapshot'   => null,
                'score_numeric'          => null,
                'comment'                => null,
            ])->toArray();
        }
    }

    public function testSchema(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Tabs')
                    ->contained(false)
                    ->tabs([
                        Tab::make('Informasi Kandidat')
                            ->schema([
                                Section::make('Informasi')
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('candidate')
                                            ->label('Kandidat')
                                            ->state(fn() => $this->record?->application?->user?->name ?? '-'),

                                        TextEntry::make('session')
                                            ->label('Sesi')
                                            ->state(fn() => $this->record?->interviewSession?->title ?? '-'),

                                        TextEntry::make('interview')
                                            ->label('Form Wawancara')
                                            ->state(fn() => $this->record?->interviewSession?->interview?->name ?? '-'),
                                    ])
                                    ->columnSpanFull(),

                                Section::make('Informasi Pribadi')
                                    ->description('Ringkasan identitas karyawan.')
                                    ->icon(LucideIcon::UserCircle)
                                    ->collapsible()
                                    ->columns(12)
                                    ->schema([
                                        ImageEntry::make('photo')
                                            ->state(fn() => $this->record?->application?->user?->applicant?->photo ?? '-')
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
                                                TextEntry::make('nik')
                                                    ->state(fn() => $this->record?->application?->user?->applicant?->nik ?? '-')
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

                                                TextEntry::make('phone_number')
                                                    ->state(fn() => $this->record?->application?->user?->applicant?->phone_number ?? '-')
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

                                                TextEntry::make('email')
                                                    ->state(fn() => $this->record?->application?->user?->email ?? '-')
                                                    ->label('Email')
                                                    ->icon('heroicon-o-map-pin')
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('place_of_birth')
                                                    ->state(fn() => $this->record?->application?->user?->applicant?->place_of_birth ?? '-')
                                                    ->label('Tempat Lahir')
                                                    ->icon('heroicon-o-map-pin')
                                                    ->placeholder('—')
                                                    ->columnSpan([
                                                        'default' => 1,
                                                        'lg' => 3,
                                                    ]),

                                                TextEntry::make('date_of_birth')
                                                    ->state(fn() => $this->record?->application?->user?->applicant?->date_of_birth ?? '-')
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

                                                TextEntry::make('gender')
                                                    ->state(fn() => $this->record?->application?->user?->applicant?->gender ?? '-')
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
                                                            $this->record?->application?->user?->applicant?->address_line,
                                                            // Tambahkan baris kecil untuk kode pos / kode desa jika ada
                                                            collect([
                                                                $this->record?->application?->user?->applicant?->postal_code ?  $this->record?->application?->user?->applicant?->postal_code : null,
                                                                $this->record?->application?->user?->applicant?->village?->name ?  $this->record?->application?->user?->applicant?->village?->name : null,
                                                                $this->record?->application?->user?->applicant?->regency?->name ?  $this->record?->application?->user?->applicant?->regency?->name : null,
                                                                $this->record?->application?->user?->applicant?->district?->name ?  $this->record?->application?->user?->applicant?->district?->name : null,
                                                                $this->record?->application?->user?->applicant?->province?->name ?  $this->record?->application?->user?->applicant?->province?->name : null,
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
                                        RepeatableEntry::make('educations')
                                            ->state(fn() => $this->record->application?->user?->educations)
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
                                        RepeatableEntry::make('workExperiences')
                                            ->state(fn() => $this->record->application?->user?->workExperiences)
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
                                        RepeatableEntry::make('organizationalExperiences')
                                            ->state(fn() => $this->record->application?->user?->organizationalExperiences)
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
                                        RepeatableEntry::make('trainingCertifications')
                                            ->state(fn() => $this->record->application?->user?->trainingCertifications)
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
                                        RepeatableEntry::make('achievements')
                                            ->state(fn() => $this->record->application?->user?->achievements)
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
                                        RepeatableEntry::make('languages')
                                            ->state(fn() => $this->record->application?->user?->languages)
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
                                        RepeatableEntry::make('skills')
                                            ->state(fn() => $this->record->application?->user?->skills)
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
                                        RepeatableEntry::make('socialMedias')
                                            ->state(fn() => $this->record->application?->user?->socialMedias)
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
                                        RepeatableEntry::make('documents')
                                            ->state(fn() => $this->record->application?->user?->documents)
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
                            ->columns(12)
                            ->schema(function ($record): array {
                                // ds($this->record);
                                $application = $this->record->application ?? null;

                                if (! $application) {
                                    return [
                                        Section::make()
                                            ->schema([
                                                TextEntry::make('no_test')
                                                    ->label('Hasil Tes')
                                                    ->default('Pelamar ini belum memiliki data tes.'),
                                            ])
                                            ->columnSpanFull(),
                                    ];
                                }

                                // Ambil semua ApplicantTest + attempts-nya
                                $tests = $application->applicantTests->attempts;

                                $testResults = $tests->map(function ($test) {
                                    return [
                                        'id' => $test->id,
                                        'test_title' => $test->test->title,
                                        'minimum_score' => $test->jobVacancyTestItem->minimum_score,
                                        'score' => $test->score * $test->jobVacancyTestItem->multiplier,
                                        'description' => ($test->score * $test->jobVacancyTestItem->multiplier) > $test->jobVacancyTestItem->minimum_score ? 'Diatas Skor Minimal' : 'Dibawah Skor Minimal',
                                    ];
                                });

                                // ds($tests->values()->toArray());

                                if ($tests->isEmpty()) {
                                    return [
                                        Section::make()
                                            ->schema([
                                                TextEntry::make('no_attempt')
                                                    ->label('Hasil Tes')
                                                    ->default('Belum ada attempt yang dikerjakan.'),
                                            ])
                                            ->columnSpanFull(),
                                    ];
                                }

                                return [
                                    TextEntry::make('avg')
                                        ->size(TextSize::Large)
                                        ->label('Rata-rata Skor')
                                        ->state(function () use ($testResults) {
                                            $values = collect($testResults)->pluck('score')
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
                                        }),

                                    RepeatableEntry::make('attempt_rows')
                                        ->hiddenLabel()
                                        ->state($testResults->values()->toArray())
                                        ->table([
                                            TableColumn::make('Test'),
                                            TableColumn::make('Skor Minimal'),
                                            TableColumn::make('Skor'),
                                            TableColumn::make('Keterangan'),
                                        ])
                                        ->schema([
                                            TextEntry::make('test_title')
                                                ->label('Soal'),

                                            TextEntry::make('minimum_score')
                                                ->label('Skor Minimal'),

                                            TextEntry::make('score')
                                                ->label('Skor × Bobot'),

                                            TextEntry::make('description')
                                                ->label('Keterangan'),
                                        ])
                                        ->columnSpanFull(),
                                ];
                            }),

                        Tab::make('Hasil Tes Karakter')
                            ->columns(12)
                            ->schema(function ($record): array {
                                $components = [];

                                // 1. Ambil ApplicantTest psikotest dari relasi, lalu 1 attempt terbaru
                                $attempt = optional($this->record->application->applicantPsychotest->psychotestAttempts()->first());
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

                                $aspectResults = $attempt?->aspects;         // relasi PsychotestResultAspect
                                $charResults   = $attempt?->characteristics; // relasi PsychotestResultCharacteristic
                                // dd( $aspectResults);
                                // ===== Ringkasan Umum =====
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

                                if ($aspectResults) {
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
                                }

                                if ($charResults) {
                                    //
                                    // ========== HASIL PER KARAKTERISTIK, DIKELOMPOKKAN PER ASPEK ==========
                                    //
                                    if ($charResults->isNotEmpty()) {
                                        // Grouping karakteristik berdasarkan nama aspek
                                        $groupedByAspect = $charResults->groupBy(
                                            fn($item) => $item->characteristic->psychotestAspect->name ?? 'Tanpa Aspek'
                                        );

                                        $i = 0;
                                        foreach ($groupedByAspect as $aspectName => $chars) {
                                            $charState = $chars->map(function ($item) {
                                                // Interpretasi skor dari relasi psychotestCharacteristicScores (sudah eager loaded)
                                                $scoreDesc = optional(
                                                    $item->characteristic->psychotestCharacteristicScores
                                                        ->firstWhere('score', $item->scaled_score)
                                                )->description ?? '-';

                                                return [
                                                    'name'              => $item->characteristic->name,
                                                    'raw'               => $item->raw_score,
                                                    'scaled'            => $item->scaled_score,
                                                    'final_description' => $scoreDesc,
                                                    'detail'            => $item->characteristic->description ?? '-',
                                                ];
                                            })->values()->toArray();

                                            $components[] = Section::make("{$aspectName}")
                                                ->columnSpanFull()
                                                ->schema([
                                                    RepeatableEntry::make("char_results_{$i}")
                                                        ->label("Hasil Per Karakteristik ({$aspectName})")
                                                        ->hiddenLabel()
                                                        ->state($charState)
                                                        ->table([
                                                            TableColumn::make('Karakteristik'),
                                                            // TableColumn::make('Skor Mentah'),
                                                            TableColumn::make('Skor Skala'),
                                                            TableColumn::make('Interpretasi Skor'),
                                                            TableColumn::make('Deskripsi Karakteristik'),
                                                        ])
                                                        ->schema([
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

                                            $i++;
                                        }
                                    }
                                }


                                return $components;
                            }),

                        Tab::make('Form Penilaian')
                            ->schema([
                                Section::make('Penilaian per Kriteria')
                                    ->schema([
                                        Repeater::make('scores')
                                            ->hiddenLabel()
                                            ->columns(12)
                                            ->deletable(false)->addable(false)->reorderable(false)
                                            ->schema([
                                                // Kriteria (readonly)
                                                Select::make('interview_criteria_id')
                                                    ->label('Kriteria')
                                                    ->columnSpan(5)
                                                    ->options(function () {
                                                        if (! $this->record) return [];
                                                        return DB::table('interview_criterias')
                                                            ->where('interview_id', $this->record->interviewSession->interview_id)
                                                            ->orderBy('order')
                                                            ->pluck('label', 'id')
                                                            ->toArray();
                                                    })
                                                    ->disabled()
                                                    ->dehydrated(true),

                                                // Skala per-kriteria
                                                Select::make('interview_scale_id')
                                                    ->label('Nilai')
                                                    ->columnSpan(3)
                                                    ->required()
                                                    ->options(function (Get $get) {
                                                        $critId = $get('interview_criteria_id');
                                                        if (! $critId) return [];
                                                        return DB::table('interview_scales')
                                                            ->where('interview_criteria_id', $critId)
                                                            ->orderBy('order')
                                                            ->get(['id', 'label', 'value'])
                                                            ->mapWithKeys(fn($o) => [$o->id => "{$o->label} ({$o->value})"])
                                                            ->toArray();
                                                    })
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                                        if (! $state) return;

                                                        $critId = $get('interview_criteria_id');

                                                        $opt = DB::table('interview_scales')->where('id', $state)->first();
                                                        if (! $opt) return;

                                                        // Snapshot
                                                        $set('scale_label_snapshot', $opt->label);
                                                        $set('scale_value_snapshot', (int) $opt->value);

                                                        // Skor numerik: (value / max_value_of_criteria) * weight * 100
                                                        $maxVal = (int) (DB::table('interview_scales')
                                                            ->where('interview_criteria_id', $critId)
                                                            ->max('value') ?: 1);

                                                        $weight = (float) (DB::table('interview_criterias')
                                                            ->where('id', $critId)
                                                            ->value('weight') ?: 1.0);

                                                        $normalized = $maxVal > 0 ? ($opt->value / $maxVal) : 0;

                                                        // ds([
                                                        //     'maxVal' => $maxVal,
                                                        //     'weight' => $weight,
                                                        //     'normalized' => $normalized,
                                                        // ]);

                                                        $score = round($normalized * $weight * 10, 2);
                                                        // $score = $opt->value;

                                                        $set('score_numeric', $score);
                                                    }),

                                                Hidden::make('scale_label_snapshot')->dehydrated(true),
                                                Hidden::make('scale_value_snapshot')->dehydrated(true),

                                                TextInput::make('score_numeric')
                                                    ->label('Skor')
                                                    ->numeric()->readOnly()
                                                    ->columnSpan(4),

                                                Textarea::make('comment')
                                                    ->label('Catatan')
                                                    ->rows(2)
                                                    ->columnSpan(12),
                                            ]),
                                    ])
                                    ->columnSpanFull(),

                                Section::make('Ringkasan')
                                    ->schema([

                                        Checkbox::make('status')
                                            ->label('Sudah selesai melakukan penilaian?'),


                                        Radio::make('recommendation')
                                            ->label('Rekomendasi')
                                            ->options([
                                                'hire'    => 'Hire',
                                                'hold'    => 'Hold',
                                                'no_hire' => 'No Hire',
                                            ])
                                            ->inline(),

                                        Textarea::make('overall_comment')
                                            ->label('Komentar Umum')
                                            ->rows(3),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                    ]),

                // Grid::make()
                //     ->columns(12)
                //     ->schema([

                //         Grid::make()
                //             ->columnSpan([
                //                 'sm' => 12,
                //                 'md' => 4,
                //                 'lg' => 4,
                //             ])
                //             ->schema([]),

                //         Grid::make()
                //             ->columnSpan([
                //                 'sm' => 12,
                //                 'md' => 8,
                //                 'lg' => 8,
                //             ])
                //             ->schema([]),
                //     ]),
            ])
            ->statePath('data');
    }

    /** Tombol di footer form (v4) */
    // protected function getFormActions(): array
    // {
    //     return [
    //         Action::make('save')
    //             ->label('Simpan Penilaian')
    //             ->submit('save')
    //             ->icon('heroicon-m-check'),
    //     ];
    // }

    public function save(): void
    {
        $state = $this->testSchema->getState();
        // dd($state);
        // Pastikan semua kriteria terisi
        foreach ($state['scores'] as $row) {
            if (empty($row['interview_criteria_id']) || empty($row['interview_scale_id'])) {
                throw ValidationException::withMessages([
                    'data.scores' => 'Semua kriteria wajib diberi nilai.',
                ]);
            }
        }

        DB::transaction(function () use ($state) {
            $sessionEvaluatorId = InterviewSessionEvaluator::query()
                ->where('interview_session_id', $this->record->interview_session_id)
                ->where('user_id', Auth::id())
                ->value('id');

            if (! $sessionEvaluatorId) {
                throw new \RuntimeException('Anda bukan evaluator pada sesi ini.');
            }

            // Upsert evaluation (1 evaluator x 1 kandidat per sesi)
            $evaluation = InterviewEvaluation::query()->firstOrCreate(
                [
                    'interview_session_application_id' => $this->record->id,
                    'interview_session_evaluator_id'   => $sessionEvaluatorId,
                ],
                [
                    'submitted_at'    => now(),
                ]
            );

            if ($state['status'] === true) {
                $this->record->update([
                    'status' => 'completed'
                ]);
            } else {
                $this->record->update([
                    'status' => 'in_progress'
                ]);
            }

            // Simpan nilai ringkasan
            $evaluation->update([
                // 'status'          => $state['status'] === true ? 'completed' : 'in_progress',
                'recommendation'  => $state['recommendation'] ?? null,
                'overall_comment' => $state['overall_comment'] ?? null,
                'submitted_at'    => now(),
            ]);

            // Simpan/Upsert skor per-kriteria
            $total = 0;
            foreach ($state['scores'] as $row) {
                // dd($state['scores']);
                $score = (float) ($row['score_numeric'] ?? 0);
                $scale = InterviewScale::find($row['interview_scale_id']);

                InterviewEvaluationScore::query()->updateOrCreate(
                    [
                        'interview_evaluation_id' => $evaluation->id,
                        'interview_criteria_id'   => $row['interview_criteria_id'], // <- gunakan FK kriteria (bukan interview_id)
                    ],
                    [
                        'interview_scale_id'     => $row['interview_scale_id'],
                        'scale_label_snapshot'   => $scale->label ?? null,
                        'scale_value_snapshot'   => $scale->value ?? null,
                        'score_numeric'          => $score,
                        'comment'                => $row['comment'] ?? null,
                    ]
                );

                $total += $score;
            }

            $avgTotal = $total / count($state['scores']);

            // Update total evaluator
            $evaluation->update(['total_score' => $avgTotal]);

            // Update avg_score kandidat di sesi ini
            // $avg = InterviewEvaluation::query()
            //     ->where('interview_session_application_id', $this->record->id)
            //     ->avg('total_score');
            $this->record->update(['avg_score' => $avgTotal]);
        });

        Notification::make()
            ->title('Penilaian tersimpan')
            ->success()
            ->send();

        $this->redirect(
            route(
                'filament.interviewer.resources.interview-session-applications.index'
            ),
            true
        );
    }

    // public function getHeading(): string
    // {
    //     $name = $this->record?->application?->user?->name ?? 'Kandidat';
    //     return "Penilaian: {$name}";
    // }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url(fn(): string => route(
                    'filament.interviewer.resources.interview-session-applications.view',
                    ['record' => $this->record] // sesuaikan
                )),
        ];
    }
}
