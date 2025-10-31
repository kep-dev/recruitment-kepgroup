<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\View;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use App\Livewire\Applicant\ApplicantSnapshot;
use Filament\Infolists\Components\RepeatableEntry;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Nama'),
                TextEntry::make('user.email')
                    ->label('Email'),
                TextEntry::make('jobVacancy.title')
                    ->label('Pekerjaan'),
                TextEntry::make('final_status')
                    ->label('Status'),

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

                View::make('filament.schemas.components.applicant.applicant-snapshot')
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tab::make('Profil')
                                    ->schema([
                                        TextEntry::make('snapshot_captured_at')
                                            ->label('Diambil pada')
                                            ->state(fn($record) => $record?->profileSnapshot?->captured_at ?? null)
                                            ->dateTime('d M Y H:i')
                                            ->badge()
                                            ->placeholder('-'),

                                        TextEntry::make('snapshot_source_note')
                                            ->label('Catatan Sumber')
                                            ->state(fn($record) => $record?->profileSnapshot?->source_note ?? '-')
                                            ->placeholder('-'),
                                    ]),

                                Tab::make('Pendidikan')
                                    ->schema([
                                        \Filament\Infolists\Components\RepeatableEntry::make('education_snapshots')
                                            ->label('Riwayat Pendidikan')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->educations
                                                    ?->sortByDesc('graduation_year')
                                                    ?->map(fn($e) => [
                                                        'education_level' => $e->education_level,
                                                        'major'           => $e->major,
                                                        'university'      => $e->university,
                                                        'location'        => $e->location,
                                                        'graduation_year' => $e->graduation_year,
                                                        'gpa'             => $e->gpa,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('education_level')->label('Jenjang'),
                                                TextEntry::make('major')->label('Jurusan'),
                                                TextEntry::make('university')->label('Universitas'),
                                                TextEntry::make('location')->label('Lokasi'),
                                                TextEntry::make('graduation_year')->label('Lulus'),
                                                TextEntry::make('gpa')->label('GPA'),
                                            ])
                                            ->grid(2),
                                    ]),

                                Tab::make('Pengalaman Kerja')
                                    ->schema([
                                        \Filament\Infolists\Components\RepeatableEntry::make('work_experience_snapshots')
                                            ->label('Riwayat Kerja')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->workExperiences
                                                    ?->sortByDesc('start_date')
                                                    ?->map(fn($w) => [
                                                        'job_title'    => $w->job_title,
                                                        'company_name' => $w->company_name,
                                                        'job_position' => $w->job_position,
                                                        'industry'     => $w->industry,
                                                        'start_date'   => $w->start_date,
                                                        'end_date'     => $w->currently_working ? 'Sekarang' : ($w->end_date ?? '-'),
                                                        'description'  => $w->description,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('job_title')->label('Jabatan'),
                                                TextEntry::make('company_name')->label('Perusahaan'),
                                                TextEntry::make('job_position')->label('Posisi'),
                                                TextEntry::make('industry')->label('Industri'),
                                                TextEntry::make('start_date')->label('Mulai')->date('d M Y'),
                                                TextEntry::make('end_date')->label('Selesai'),
                                                TextEntry::make('description')->label('Deskripsi'),
                                            ])
                                            ->grid(2),
                                    ]),

                                Tab::make('Organisasi')
                                    ->schema([
                                        RepeatableEntry::make('organizational_experience_snapshots')
                                            ->label('Organisasi')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->organizationalExperiences
                                                    ?->sortByDesc('start_date')
                                                    ?->map(fn($o) => [
                                                        'organization_name' => $o->organization_name,
                                                        'position'          => $o->position,
                                                        'level'             => $o->level,
                                                        'start_date'        => $o->start_date,
                                                        'end_date'          => $o->end_date,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('organization_name')->label('Organisasi'),
                                                TextEntry::make('position')->label('Posisi'),
                                                TextEntry::make('level')->label('Level'),
                                                TextEntry::make('start_date')->label('Mulai')->date('d M Y'),
                                                TextEntry::make('end_date')->label('Selesai')->date('d M Y'),
                                            ])
                                            ->grid(2),
                                    ]),

                                // =======================================================
                                Tab::make('Pelatihan & Sertifikasi')
                                    ->schema([
                                        RepeatableEntry::make('training_certification_snapshots')
                                            ->label('Pelatihan & Sertifikasi')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->trainings
                                                    ?->sortByDesc('start_date')
                                                    ?->map(fn($t) => [
                                                        'title'       => $t->training_certification_title,
                                                        'type'        => strtoupper($t->type),
                                                        'institution' => $t->institution_name,
                                                        'location'    => $t->location,
                                                        'start_date'  => $t->start_date,
                                                        'end_date'    => $t->end_date,
                                                        'description' => $t->description,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('title')->label('Judul'),
                                                TextEntry::make('type')->label('Jenis'),
                                                TextEntry::make('institution')->label('Institusi'),
                                                TextEntry::make('location')->label('Lokasi'),
                                                TextEntry::make('start_date')->label('Mulai')->date('d M Y'),
                                                TextEntry::make('end_date')->label('Selesai')->date('d M Y'),
                                                TextEntry::make('description')->label('Deskripsi'),
                                            ])
                                            ->grid(2),
                                    ]),

                                // =======================================================
                                Tab::make('Prestasi')
                                    ->schema([
                                        RepeatableEntry::make('achievement_snapshots')
                                            ->label('Prestasi')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->achievements
                                                    ?->sortByDesc('year')
                                                    ?->map(fn($a) => [
                                                        'achievement_name'  => $a->achievement_name,
                                                        'organization_name' => $a->organization_name,
                                                        'year'              => $a->year,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('achievement_name')->label('Prestasi'),
                                                TextEntry::make('organization_name')->label('Organisasi'),
                                                TextEntry::make('year')->label('Tahun'),
                                            ])
                                            ->grid(2),
                                    ]),

                                // =======================================================
                                Tab::make('Bahasa')
                                    ->schema([
                                        RepeatableEntry::make('language_snapshots')
                                            ->label('Bahasa')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->languages
                                                    ?->map(fn($l) => [
                                                        'language' => $l->language,
                                                        'level'    => $l->level,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('language')->label('Bahasa'),
                                                TextEntry::make('level')->label('Level'),
                                            ])
                                            ->grid(2),
                                    ]),

                                // =======================================================
                                Tab::make('Skill')
                                    ->schema([
                                        RepeatableEntry::make('skill_snapshots')
                                            ->label('Skill')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->skills
                                                    ?->map(fn($s) => [
                                                        'skill' => $s->skill,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('skill')->label('Skill')->badge(),
                                            ])
                                            ->grid(4),
                                    ]),

                                // =======================================================
                                Tab::make('Sosial Media')
                                    ->schema([
                                        RepeatableEntry::make('social_media_snapshots')
                                            ->label('Sosial Media')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->socialMedias
                                                    ?->map(fn($sm) => [
                                                        'name' => $sm->name,
                                                        'url'  => $sm->url,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('name')->label('Platform'),
                                                TextEntry::make('url')->label('URL'),
                                            ])
                                            ->grid(2),
                                    ]),

                                // =======================================================
                                Tab::make('Minat Fungsi')
                                    ->schema([
                                        RepeatableEntry::make('function_of_interest_snapshots')
                                            ->label('Minat Fungsi')
                                            ->state(
                                                fn($record) =>
                                                $record?->profileSnapshot?->functionOfInterests
                                                    ?->map(fn($f) => [
                                                        'function_of_interest' => $f->function_of_interest,
                                                    ])
                                                    ?->values()
                                                    ?->all() ?? []
                                            )
                                            ->schema([
                                                TextEntry::make('function_of_interest')->label('Fungsi')->badge(),
                                            ])
                                            ->grid(3),
                                    ]),

                                // =======================================================
                                Tab::make('Gaji')
                                    ->schema([
                                        TextEntry::make('expected_salary')
                                            ->label('Ekspektasi')
                                            ->state(fn($r) => $r?->profileSnapshot?->salary?->expected_salary)
                                            ->formatStateUsing(fn($v) => $v ? number_format($v, 2) : '-'),

                                        TextEntry::make('current_salary')
                                            ->label('Gaji Saat Ini')
                                            ->state(fn($r) => $r?->profileSnapshot?->salary?->current_salary)
                                            ->formatStateUsing(fn($v) => $v ? number_format($v, 2) : '-'),

                                        TextEntry::make('currency')
                                            ->label('Mata Uang')
                                            ->state(fn($r) => $r?->profileSnapshot?->salary?->currency ?? 'IDR')
                                            ->badge(),
                                    ])
                                    ->columns(3),

                            ]),
                    ])
                    ->columnSpanFull(),


            ]);
    }
}
