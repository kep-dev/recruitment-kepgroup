<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Date;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use App\Livewire\Applicant\ApplicantSnapshot;
use Filament\Infolists\Components\RepeatableEntry;
use App\Models\Psychotest\PsychotestCharacteristicScore;
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



                // Livewire::make(ApplicantSnapshot::class, ['snapshot' => $schema->getRecord()->profileSnapshot])
                // View::make('filament.schemas.components.applicant.applicant-snapshot')
                //     ->schema([
                //         Tabs::make('Tabs')
                //             ->tabs([
                //                 Tab::make('Tab 1')
                //                     ->schema([
                //                         TextEntry::make('snapshot_captured_at')
                //                             ->label('Diambil pada')
                //                             ->state(fn($record) => $record->profileSnapshot?->captured_at)
                //                             ->dateTime('d M Y H:i')
                //                             ->badge(),

                //                         TextEntry::make('snapshot_source_note')
                //                             ->label('Catatan Sumber')
                //                             ->state(fn($record) => $record->profileSnapshot?->source_note ?? '-'),
                //                     ]),
                //                 Tab::make('Tab 2')
                //                     ->schema([
                //                         // ...
                //                     ]),
                //                 Tab::make('Tab 3')
                //                     ->schema([
                //                         // ...
                //                     ]),
                //             ])
                //     ])
                //     ->columnSpanFull()

                // View::make('filament.schemas.components.applicant.applicant-snapshot')
                //     ->schema([
                //         Tabs::make('Tabs')
                //             ->tabs([
                //                 Tab::make('Profil')
                //                     ->schema([
                //                         TextEntry::make('place_of_birth')
                //                             ->label('Tempat, Tanggal Lahir')
                //                             ->state(fn($record) => $record?->applicant)
                //                             ->formatStateUsing(fn($state) => $state?->place_of_birth . ', ' . Date::make($state?->date_of_birth)->format('d M Y'))
                //                             ->placeholder('-'),

                //                         TextEntry::make('phone_numberr')
                //                             ->label('Nomor Telepon')
                //                             ->state(fn($record) => $record?->applicant?->phone_number)
                //                             ->placeholder('-'),

                //                         TextEntry::make('email')
                //                             ->label('Email')
                //                             ->state(fn($record) => $record?->user?->email)
                //                             ->placeholder('-'),

                //                         TextEntry::make('snapshot_source_note')
                //                             ->label('Catatan Sumber')
                //                             ->state(fn($record) => $record?->profileSnapshot?->source_note ?? '-')
                //                             ->placeholder('-'),
                //                     ]),

                //                 Tab::make('Pendidikan')
                //                     ->schema([
                //                         \Filament\Infolists\Components\RepeatableEntry::make('education_snapshots')
                //                             ->label('Riwayat Pendidikan')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->educations
                //                                     ?->sortByDesc('graduation_year')
                //                                     ?->map(fn($e) => [
                //                                         'education_level' => $e->education_level,
                //                                         'major'           => $e->major,
                //                                         'university'      => $e->university,
                //                                         'location'        => $e->location,
                //                                         'graduation_year' => $e->graduation_year,
                //                                         'gpa'             => $e->gpa,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('education_level')->label('Jenjang'),
                //                                 TextEntry::make('major')->label('Jurusan'),
                //                                 TextEntry::make('university')->label('Universitas'),
                //                                 TextEntry::make('location')->label('Lokasi'),
                //                                 TextEntry::make('graduation_year')->label('Lulus'),
                //                                 TextEntry::make('gpa')->label('GPA'),
                //                             ])
                //                             ->grid(2),
                //                     ]),

                //                 Tab::make('Pengalaman Kerja')
                //                     ->schema([
                //                         \Filament\Infolists\Components\RepeatableEntry::make('work_experience_snapshots')
                //                             ->label('Riwayat Kerja')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->workExperiences
                //                                     ?->sortByDesc('start_date')
                //                                     ?->map(fn($w) => [
                //                                         'job_title'    => $w->job_title,
                //                                         'company_name' => $w->company_name,
                //                                         'job_position' => $w->job_position,
                //                                         'industry'     => $w->industry,
                //                                         'start_date'   => $w->start_date,
                //                                         'end_date'     => $w->currently_working ? 'Sekarang' : ($w->end_date ?? '-'),
                //                                         'description'  => $w->description,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('job_title')->label('Jabatan'),
                //                                 TextEntry::make('company_name')->label('Perusahaan'),
                //                                 TextEntry::make('job_position')->label('Posisi'),
                //                                 TextEntry::make('industry')->label('Industri'),
                //                                 TextEntry::make('start_date')->label('Mulai')->date('d M Y'),
                //                                 TextEntry::make('end_date')->label('Selesai'),
                //                                 TextEntry::make('description')->label('Deskripsi'),
                //                             ])
                //                             ->grid(2),
                //                     ]),

                //                 Tab::make('Organisasi')
                //                     ->schema([
                //                         RepeatableEntry::make('organizational_experience_snapshots')
                //                             ->label('Organisasi')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->organizationalExperiences
                //                                     ?->sortByDesc('start_date')
                //                                     ?->map(fn($o) => [
                //                                         'organization_name' => $o->organization_name,
                //                                         'position'          => $o->position,
                //                                         'level'             => $o->level,
                //                                         'start_date'        => $o->start_date,
                //                                         'end_date'          => $o->end_date,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('organization_name')->label('Organisasi'),
                //                                 TextEntry::make('position')->label('Posisi'),
                //                                 TextEntry::make('level')->label('Level'),
                //                                 TextEntry::make('start_date')->label('Mulai')->date('d M Y'),
                //                                 TextEntry::make('end_date')->label('Selesai')->date('d M Y'),
                //                             ])
                //                             ->grid(2),
                //                     ]),

                //                 Tab::make('Pelatihan & Sertifikasi')
                //                     ->schema([
                //                         RepeatableEntry::make('training_certification_snapshots')
                //                             ->label('Pelatihan & Sertifikasi')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->trainings
                //                                     ?->sortByDesc('start_date')
                //                                     ?->map(fn($t) => [
                //                                         'title'       => $t->training_certification_title,
                //                                         'type'        => strtoupper($t->type),
                //                                         'institution' => $t->institution_name,
                //                                         'location'    => $t->location,
                //                                         'start_date'  => $t->start_date,
                //                                         'end_date'    => $t->end_date,
                //                                         'description' => $t->description,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('title')->label('Judul'),
                //                                 TextEntry::make('type')->label('Jenis'),
                //                                 TextEntry::make('institution')->label('Institusi'),
                //                                 TextEntry::make('location')->label('Lokasi'),
                //                                 TextEntry::make('start_date')->label('Mulai')->date('d M Y'),
                //                                 TextEntry::make('end_date')->label('Selesai')->date('d M Y'),
                //                                 TextEntry::make('description')->label('Deskripsi'),
                //                             ])
                //                             ->grid(2),
                //                     ]),
                //                 Tab::make('Prestasi')
                //                     ->schema([
                //                         RepeatableEntry::make('achievement_snapshots')
                //                             ->label('Prestasi')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->achievements
                //                                     ?->sortByDesc('year')
                //                                     ?->map(fn($a) => [
                //                                         'achievement_name'  => $a->achievement_name,
                //                                         'organization_name' => $a->organization_name,
                //                                         'year'              => $a->year,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('achievement_name')->label('Prestasi'),
                //                                 TextEntry::make('organization_name')->label('Organisasi'),
                //                                 TextEntry::make('year')->label('Tahun'),
                //                             ])
                //                             ->grid(2),
                //                     ]),
                //                 Tab::make('Bahasa')
                //                     ->schema([
                //                         RepeatableEntry::make('language_snapshots')
                //                             ->label('Bahasa')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->languages
                //                                     ?->map(fn($l) => [
                //                                         'language' => $l->language,
                //                                         'level'    => $l->level,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('language')->label('Bahasa'),
                //                                 TextEntry::make('level')->label('Level'),
                //                             ])
                //                             ->grid(2),
                //                     ]),
                //                 Tab::make('Skill')
                //                     ->schema([
                //                         RepeatableEntry::make('skill_snapshots')
                //                             ->label('Skill')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->skills
                //                                     ?->map(fn($s) => [
                //                                         'skill' => $s->skill,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('skill')->label('Skill')->badge(),
                //                             ])
                //                             ->grid(4),
                //                     ]),
                //                 Tab::make('Sosial Media')
                //                     ->schema([
                //                         RepeatableEntry::make('social_media_snapshots')
                //                             ->label('Sosial Media')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->socialMedias
                //                                     ?->map(fn($sm) => [
                //                                         'name' => $sm->name,
                //                                         'url'  => $sm->url,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('name')->label('Platform'),
                //                                 TextEntry::make('url')->label('URL'),
                //                             ])
                //                             ->grid(2),
                //                     ]),
                //                 Tab::make('Minat Fungsi')
                //                     ->schema([
                //                         RepeatableEntry::make('function_of_interest_snapshots')
                //                             ->label('Minat Fungsi')
                //                             ->state(
                //                                 fn($record) =>
                //                                 $record?->profileSnapshot?->functionOfInterests
                //                                     ?->map(fn($f) => [
                //                                         'function_of_interest' => $f->function_of_interest,
                //                                     ])
                //                                     ?->values()
                //                                     ?->all() ?? []
                //                             )
                //                             ->schema([
                //                                 TextEntry::make('function_of_interest')->label('Fungsi')->badge(),
                //                             ])
                //                             ->grid(3),
                //                     ]),
                //                 Tab::make('Gaji')
                //                     ->schema([
                //                         TextEntry::make('expected_salary')
                //                             ->label('Ekspektasi')
                //                             ->state(fn($r) => $r?->profileSnapshot?->salary?->expected_salary)
                //                             ->formatStateUsing(fn($v) => $v ? number_format($v, 2) : '-'),

                //                         TextEntry::make('current_salary')
                //                             ->label('Gaji Saat Ini')
                //                             ->state(fn($r) => $r?->profileSnapshot?->salary?->current_salary)
                //                             ->formatStateUsing(fn($v) => $v ? number_format($v, 2) : '-'),

                //                         TextEntry::make('currency')
                //                             ->label('Mata Uang')
                //                             ->state(fn($r) => $r?->profileSnapshot?->salary?->currency ?? 'IDR')
                //                             ->badge(),
                //                     ])
                //                     ->columns(3),

                //             ]),
                //     ])
                //     ->columnSpanFull(),

                View::make('filament.schemas.components.applicant.application-result')
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([
                        Tabs::make('Tabs')
                            ->columnSpanFull()
                            ->contained(false)
                            ->tabs([
                                Tab::make('Hasil Tes')
                                    ->schema([
                                        Section::make('Hasil tes potensi dasar akademik')
                                            ->schema([
                                                RepeatableEntry::make('applicantTests.attempts')
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
                                            ->columnSpanFull()
                                    ]),
                                Tab::make('Hasil Interview')
                                    ->columns(12)
                                    ->schema([
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
                                                        TextEntry::make('overall_comment')
                                                            ->label('Komentar')
                                                            ->columnSpanFull(),

                                                        RepeatableEntry::make('scores')
                                                            ->hiddenLabel()
                                                            ->contained(false)
                                                            ->table([
                                                                TableColumn::make('Kriteria'),
                                                                TableColumn::make('Nilai'),
                                                                TableColumn::make('Keterangan'),
                                                            ])
                                                            ->schema([
                                                                TextEntry::make('criteria.label'),
                                                                TextEntry::make('scaleOption.label'),
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
