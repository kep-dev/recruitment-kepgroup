<?php

namespace App\Filament\Resources\PreMedicalSessions\RelationManagers;

use Filament\Tables\Table;
use App\Models\Application;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\PreMedicalSessions\PreMedicalSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;

class PreMedicalSessionApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'preMedicalSessionApplications';

    // protected static ?string $relatedResource = PreMedicalSessionResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            Grid::make()
                ->columns(12)
                ->columnSpan([
                    'sm' => 12,
                    'md' => 12,
                    'lg' => 12,
                ])->schema([
                    Select::make('application_id')
                        ->label('Pelamar')
                        ->options(
                            Application::query()
                                ->whereNotIn('id', $this->getOwnerRecord()->preMedicalSessionApplications()->pluck('application_id'))
                                ->where('job_vacancy_id', $this->getOwnerRecord()->job_vacancy_id)
                                ->get()
                                ->mapWithKeys(fn($application) => [$application->id => $application->user->name])
                        )
                        ->searchable()
                        ->multiple()
                        ->columnSpanFull()
                        ->hiddenOn('edit'),

                    DateTimePicker::make('timeslot_start')
                        ->label('Tanggal Mulai Pre Medical Checkup')
                        ->columnSpan(6),

                    DateTimePicker::make('timeslot_end')
                        ->label('Tanggal Selesai Pre Medical Checkup')
                        ->columnSpan(6),
                    /*
                    ToggleButtons::make('status')
                        ->label('Status')
                        ->options([
                            'scheduled' => 'Terjadwal',
                            'checked_in' => 'Datang',
                            'completed' => 'Selesai',
                            'no_show' => 'Tidak Hadir',
                            'rescheduled' => 'Penjadwalan Ulang',
                            'canceled' => 'Dibatalkan',
                        ])
                        ->inline()
                        ->columnSpanFull(),

                    ToggleButtons::make('result_status')
                        ->label('Status')
                        ->options([
                            'pending' => 'Ditunda',
                            'fit' => 'Sehat',
                            'fit_with_notes' => 'Sehat Dengan Catatan',
                            'unfit' => 'Tidak Sehat',
                        ])
                        ->inline()
                        ->columnSpanFull(), */
                ])
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Daftar pelamar untuk pre medical checkup')
            ->columns([
                TextColumn::make('application.user.name')
                    ->label('Nama'),
                TextColumn::make('timeslot_start')
                    ->label('Tanggal Mulai')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('timeslot_end')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('status')
                    ->label('Status'),
                TextColumn::make('result_status')
                    ->label('Hasil'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pelamar')
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        $application = collect($data['application_id']);
                        $application->each(function ($id) use ($data) {
                            // ds($id);
                            $this->getOwnerRecord()->preMedicalSessionApplications()->create([
                                'application_id' => $id,
                                'timeslot_start' => $data['timeslot_start'],
                                'timeslot_end' => $data['timeslot_end'],
                            ]);
                        });
                    })
            ])
            ->recordActions([
                ViewAction::make()
                    ->schema([
                        Section::make('Data Kandidat')
                            ->columns(3)
                            ->schema([
                                // TextEntry::make('application.code')
                                //     ->label('Kode Aplikasi')
                                //     ->placeholder('-')
                                //     ->copyable(),
                                TextEntry::make('application.user.name')
                                    ->label('Nama Pelamar')
                                    ->placeholder('-'),

                                TextEntry::make('application.user.email')
                                    ->label('Email')
                                    ->placeholder('-'),
                                TextEntry::make('application.user.applicant.phone_number')
                                    ->label('Telepon')
                                    ->placeholder('-'),
                            ]),

                        Section::make('Informasi Sesi')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('preMedicalSession.title')
                                    ->html()
                                    ->label('Judul Sesi')
                                    ->placeholder('-'),
                                TextEntry::make('preMedicalSession.jobVacancy.title')
                                    ->label('Lowongan')
                                    ->placeholder('-'),

                                TextEntry::make('preMedicalSession.scheduled_at')
                                    ->label('Jadwal Mulai')
                                    ->dateTime('d M Y H:i'),
                                TextEntry::make('preMedicalSession.scheduled_end_at')
                                    ->label('Jadwal Selesai')
                                    ->dateTime('d M Y H:i')
                                    ->placeholder('-'),

                                TextEntry::make('preMedicalSession.location')
                                    ->label('Lokasi')
                                    ->columnSpanFull()
                                    ->placeholder('-'),
                            ]),

                        Section::make('Slot Individu')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('timeslot_start')
                                    ->label('Timeslot Mulai')
                                    ->dateTime('d M Y H:i')
                                    ->placeholder('-'),
                                TextEntry::make('timeslot_end')
                                    ->label('Timeslot Selesai')
                                    ->dateTime('d M Y H:i')
                                    ->placeholder('-'),
                            ]),

                        Section::make('Status Pelaksanaan')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Status Kehadiran/Proses')
                                    ->badge()
                                    ->colors([
                                        'info'     => 'scheduled',
                                        'warning'  => 'checked_in',
                                        'success'  => 'completed',
                                        'secondary' => 'no_show',
                                        'gray'     => 'rescheduled',
                                        'danger'   => 'canceled',
                                    ]),
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->since(), // tampilkan relative time
                            ]),

                        Section::make('Hasil Pemeriksaan')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('result_status')
                                    ->label('Status Hasil')
                                    ->badge()
                                    ->colors([
                                        'gray'    => 'pending',
                                        'success' => 'fit',
                                        'warning' => 'fit_with_notes',
                                        'danger'  => 'unfit',
                                    ]),

                                TextEntry::make('result_file_path')
                                    ->label('File Hasil (PDF)')
                                    ->icon('heroicon-m-arrow-down-tray')
                                    ->url(
                                        fn($record) =>
                                        $record->result_file_path
                                            ? Storage::url($record->result_file_path)
                                            : null,
                                        shouldOpenInNewTab: true
                                    )
                                    ->visible(fn($record) => filled($record->result_file_path))
                                    ->placeholder('-'),

                                TextEntry::make('result_note')
                                    ->label('Catatan Hasil')
                                    ->columnSpanFull()
                                    ->placeholder('-'),
                            ]),

                        Section::make('Review Internal')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('reviewer.name')
                                    ->label('Direview Oleh')
                                    ->placeholder('-'),
                                TextEntry::make('reviewed_at')
                                    ->label('Tanggal Review')
                                    ->dateTime('d M Y H:i')
                                    ->placeholder('-'),
                            ]),
                    ]),
                EditAction::make()
                    ->schema($this->getFormSchema()),
                DeleteAction::make(),
            ]);
    }
}
