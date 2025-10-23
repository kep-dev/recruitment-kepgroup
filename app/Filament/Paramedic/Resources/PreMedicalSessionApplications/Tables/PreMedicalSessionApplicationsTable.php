<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Tables;

use App\Models\JobVacancy;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use App\Models\PreMedical\DentalTeeth;
use Filament\Actions\DeleteBulkAction;
use App\Models\PreMedical\DentalStatus;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater\TableColumn;

class PreMedicalSessionApplicationsTable
{
    protected static function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('Riwayat Kesehatan')
                    ->schema([
                        RichEditor::make('personal_history')
                            ->label('Riwayat Penyakit Terdahulu')
                            ->required(),
                        RichEditor::make('family_history')
                            ->label('Riwayat Keluarga')
                            ->required(),
                        RichEditor::make('allergies')
                            ->label('Alergi')
                            ->required(),
                        RichEditor::make('current_medications')
                            ->label('Obat yang sedang digunakan')
                            ->required(),
                        RichEditor::make('past_surgeries')
                            ->label('Riwayat Operasi')
                            ->required(),
                        ToggleButtons::make('smoking_status')
                            ->label('Status Merokok')
                            ->options([
                                'never' => 'Tidak Pernah',
                                'former' => 'Lama Pernah',
                                'current' => 'Masih Aktif'
                            ])
                            ->inline(),
                        ToggleButtons::make('alcohol_use')
                            ->label('Penggunaan Alkohol')
                            ->options([
                                'never' => 'Tidak Pernah',
                                'occasional' => 'Sedikit',
                                'regular' => 'Sering'
                            ])
                            ->inline(),
                        RichEditor::make('other_notes')
                            ->label('Catatan Lain')
                            ->required(),
                    ]),
                // 'pre_medical_result_id',
                // 'height_cm',
                // 'weight_kg',
                // 'bp_systolic',
                // 'bp_diastolic',
                // 'heart_rate_bpm',
                // 'resp_rate_per_min',
                // 'temperature_c',
                // 'head_neck',
                // 'chest_heart',
                // 'chest_lung',
                // 'abdomen_liver',
                // 'abdomen_spleen',
                // 'extremities',
                // 'others',
                // 'bmi',
                Step::make('Pemeriksaan Fisik')
                    ->schema([

                        Grid::make()
                            ->columns(12)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ])->schema([
                                TextInput::make('height_cm')
                                    ->label('Tinggi (cm)')
                                    ->required()
                                    ->columnSpan(6),
                                TextInput::make('weight_kg')
                                    ->label('Berat (kg)')
                                    ->required()
                                    ->columnSpan(6),
                            ])

                    ]),
                Step::make('Pemeriksaan THT')
                    ->schema([
                        // ...
                    ]),
                Step::make('Pemeriksaan Mata')
                    ->schema([
                        // ...
                    ]),
                Step::make('Pemeriksaan Gigi')
                    ->schema([
                        // ...
                    ]),
                Step::make('Pemeriksaan Kandungan')
                    ->schema([
                        // ...
                    ]),
                Step::make('Kesimpulan')
                    ->schema([
                        // ...
                    ]),
            ])
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application.user.name')
                    ->label('Nama'),
                TextColumn::make('application.jobVacancy.title')
                    ->label('Lowongan'),
                TextColumn::make('timeslot_start')
                    ->label('Tanggal Mulai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
                TextColumn::make('timeslot_end')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('-'),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Terjadwal',
                        'checked_in' => 'Datang',
                        'no_show' => 'Tidak Hadir',
                        'completed' => 'Selesai',
                        'canceled' => 'Dibatalkan',
                        'rescheduled' => 'Penjadwalan Ulang',
                    ])
            ])
            ->filters([
                SelectFilter::make('application.jobVacancy.title')
                    ->relationship('application.jobVacancy', 'title')
                    ->label('Lowongan')
                    ->options(
                        JobVacancy::query()
                            ->where('status', true)
                            ->pluck('title', 'id')
                    )
            ])
            ->recordActions([
                Action::make('medicalCheckUp')
                    ->databaseTransaction()
                    ->steps([
                        Step::make('Riwayat Kesehatan')
                            ->schema([
                                RichEditor::make('preMedicalHistory.personal_history')
                                    ->label('Riwayat Penyakit Terdahulu')
                                    ->required(),
                                RichEditor::make('preMedicalHistory.family_history')
                                    ->label('Riwayat Keluarga')
                                    ->required(),
                                RichEditor::make('preMedicalHistory.allergies')
                                    ->label('Alergi')
                                    ->required(),
                                RichEditor::make('preMedicalHistory.current_medications')
                                    ->label('Obat yang sedang digunakan')
                                    ->required(),
                                RichEditor::make('preMedicalHistory.past_surgeries')
                                    ->label('Riwayat Operasi')
                                    ->required(),
                                ToggleButtons::make('preMedicalHistory.smoking_status')
                                    ->label('Status Merokok')
                                    ->options([
                                        'never' => 'Tidak Pernah',
                                        'former' => 'Lama Pernah',
                                        'current' => 'Masih Aktif'
                                    ])
                                    ->inline(),
                                ToggleButtons::make('preMedicalHistory.alcohol_use')
                                    ->label('Penggunaan Alkohol')
                                    ->options([
                                        'never' => 'Tidak Pernah',
                                        'occasional' => 'Sedikit',
                                        'regular' => 'Sering'
                                    ])
                                    ->inline(),
                                RichEditor::make('preMedicalHistory.other_notes')
                                    ->label('Catatan Lain')
                                    ->required(),
                            ]),
                        Step::make('Pemeriksaan Fisik')
                            ->schema([

                                Grid::make()
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                    ])->schema([
                                        TextInput::make('preMedicalPhysical.height_cm')
                                            ->label('Tinggi (cm)')
                                            ->required()
                                            ->columnSpan(4),
                                        TextInput::make('preMedicalPhysical.weight_kg')
                                            ->label('Berat (kg)')
                                            ->required()
                                            ->columnSpan(4),
                                        TextInput::make('preMedicalPhysical.temperature_c')
                                            ->label('Suhu (°C)')
                                            ->required()
                                            ->columnSpan(4),
                                        TextInput::make('preMedicalPhysical.bp_systolic')
                                            ->label('Tekanan Darah Sistolik (mmHg)')
                                            ->required()
                                            ->columnSpan(3),
                                        TextInput::make('preMedicalPhysical.bp_diastolic')
                                            ->label('Tekanan Darah Diastolik (mmHg)')
                                            ->required()
                                            ->columnSpan(3),
                                        TextInput::make('preMedicalPhysical.heart_rate_bpm')
                                            ->label('Nadi (bpm)')
                                            ->required()
                                            ->columnSpan(3),
                                        TextInput::make('preMedicalPhysical.resp_rate_per_min')
                                            ->label('Respirasi (per menit)')
                                            ->required()
                                            ->columnSpan(3),
                                        RichEditor::make('preMedicalPhysical.head_neck')
                                            ->label('Pemeriksaan kepala dan leher')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalPhysical.chest_heart')
                                            ->label('Pemeriksaan dada dan jantung')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalPhysical.chest_lung')
                                            ->label('Pemeriksaan dada dan paru-paru')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalPhysical.abdomen_liver')
                                            ->label('Pemeriksaan abdomen dan ginjal')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalPhysical.abdomen_spleen')
                                            ->label('Pemeriksaan abdomen dan perut')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalPhysical.extremities')
                                            ->label('Pemeriksaan ekstremitas')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalPhysical.others')
                                            ->label('Pemeriksaan lainnya')
                                            ->required()
                                            ->columnSpanFull(),
                                        TextInput::make('preMedicalPhysical.bmi')
                                            ->label('BMI')
                                            ->required()
                                            ->columnSpanFull(),
                                    ])

                            ]),
                        Step::make('Pemeriksaan THT')
                            ->schema([
                                RichEditor::make('preMedicalEnt.ear')
                                    ->label('Pemeriksaan Telinga')
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalEnt.nose')
                                    ->label('Pemeriksaan Hidung')
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalEnt.throat')
                                    ->label('Pemeriksaan Tenggorokan')
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalEnt.others')
                                    ->label('Pemeriksaan lainnya')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Step::make('Pemeriksaan Mata')
                            ->schema([
                                Grid::make()
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'md' => 12,
                                        'lg' => 12,
                                    ])->schema([
                                        Section::make('Tanpa Kacamata')
                                            ->columns(12)
                                            ->schema([
                                                TextInput::make('preMedicalEyes.va_unaided_right')
                                                    ->label('Tanpa Kacamata Kanan')
                                                    ->required()
                                                    ->columnSpan(6),
                                                TextInput::make('preMedicalEyes.va_unaided_left')
                                                    ->label('Tanpa Kacamata Kiri')
                                                    ->required()
                                                    ->columnSpan(6),
                                            ])
                                            ->columnSpanFull(),
                                        Section::make('Dengan Kacamata')
                                            ->columns(12)
                                            ->schema([
                                                TextInput::make('preMedicalEyes.va_aided_right')
                                                    ->label('Dengan Kacamata Kanan')
                                                    ->required()
                                                    ->columnSpan(6),
                                                TextInput::make('preMedicalEyes.va_aided_left')
                                                    ->label('Dengan Kacamata Kiri')
                                                    ->required()
                                                    ->columnSpan(6),
                                            ])
                                            ->columnSpanFull(),
                                        ToggleButtons::make('preMedicalEyes.color_vision')
                                            ->label('Buta Warna')
                                            ->options([
                                                'normal' => 'Normal',
                                                'partial' => 'Sebagian',
                                                'total' => 'Total'
                                            ])
                                            ->columnSpanFull()
                                            ->inline(),
                                        RichEditor::make('preMedicalEyes.conjunctiva')
                                            ->label('Ketajaman Penglihatan')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalEyes.sclera')
                                            ->label('Sclera')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('preMedicalEyes.others')
                                            ->label('Pemeriksaan lainnya')
                                            ->required()
                                            ->columnSpanFull(),
                                    ])
                            ]),
                        Step::make('Pemeriksaan Gigi')
                            ->schema([
                                Repeater::make('preMedicalDentalFindings')
                                    ->table([
                                        TableColumn::make('Gigi'),
                                        TableColumn::make('Status'),
                                        TableColumn::make('Lapisan'),
                                        TableColumn::make('Kerusakan'),
                                        TableColumn::make('Catatan'),
                                    ])
                                    ->compact()
                                    ->addActionLabel('Tambah Gigi')
                                    ->reorderable(false)
                                    ->schema([
                                        Select::make('dental_teeth_id')
                                            ->label('Gigi')
                                            ->options(
                                                DentalTeeth::query()
                                                    ->select('id', 'name', 'tooth_type', 'tooth_number', 'quadrant', 'fdi_code', 'dentition')
                                                    ->get()
                                                    ->mapWithKeys(function ($tooth) {
                                                        return [
                                                            $tooth->id => "{$tooth->fdi_code} - {$tooth->name} ({$tooth->tooth_type}, {$tooth->dentition}) - No: {$tooth->tooth_number} Q{$tooth->quadrant}"
                                                        ];
                                                    })
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->placeholder('Pilih gigi'),
                                        Select::make('dental_status_id')
                                            ->options(
                                                DentalStatus::query()
                                                    ->pluck('description', 'id')
                                            )
                                            ->required(),
                                        Select::make('surfaces')
                                            ->label('Lapisan')
                                            ->options([
                                                'O' => 'Occlusal (permukaan kunyah)',
                                                'M' => 'Mesial (depan)',
                                                'D' => 'Distal (belakang)',
                                                'B' => 'Buccal (pipih luar pipi)',
                                                'L' => 'Lingual (dalam lidah)',
                                                'P' => 'Palatal (dalam langit-langit)',
                                                'I' => 'Incisal (tepi potong gigi depan)',
                                                'F' => 'Facial (permukaan depan)',
                                                'W' => 'Whole tooth (seluruh gigi)',
                                            ]),
                                        Select::make('severity')
                                            ->label('Kerusakan')
                                            ->options([
                                                'mild' => 'Ringan',
                                                'moderate' => 'Sedang',
                                                'severe' => 'Parah',
                                            ]),
                                        TextInput::make('notes')
                                    ]),
                                RichEditor::make('preMedicalDentals.general_condition')
                                    ->label('Pemeriksaan Umum')
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalDentals.occlusion')
                                    ->label('Pemeriksaan Oklusif')
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalDentals.others')
                                    ->label('Pemeriksaan lainnya')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Step::make('Pemeriksaan Kandungan')
                            ->schema([
                                ToggleButtons::make('preMedicalObgyns.is_pregnant')
                                    ->label('Apakah sedang hamil?')
                                    ->boolean()
                                    ->nullable()
                                    ->inline(),
                                DatePicker::make('preMedicalObgyns.lmp_date')
                                    ->label('Tanggal Terakhir Menstruasi')
                                    ->nullable(),
                                TextInput::make('preMedicalObgyns.gravida')
                                    ->label('G')
                                    ->nullable()
                                    ->numeric(),
                                TextInput::make('preMedicalObgyns.para')
                                    ->label('P')
                                    ->nullable()
                                    ->numeric(),
                                TextInput::make('preMedicalObgyns.abortus')
                                    ->label('A')
                                    ->nullable()
                                    ->numeric(),
                                RichEditor::make('preMedicalObgyns.uterus_exam')
                                    ->label('Pemeriksaan Uterus')
                                    ->nullable()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalObgyns.adnexa_exam')
                                    ->label('Pemeriksaan Adnexa')
                                    ->nullable()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalObgyns.cervix_exam')
                                    ->label('Pemeriksaan Cervix')
                                    ->nullable()
                                    ->columnSpanFull(),
                                RichEditor::make('preMedicalObgyns.others')
                                    ->label('Pemeriksaan lainnya')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ]),
                        Step::make('Kesimpulan')
                            ->schema([
                                ToggleButtons::make('preMedicalResults.overall_status')
                                    ->label('Status Keseluruhan')
                                    ->options([
                                        'pending' => 'Ditunda',
                                        'fit' => 'Sehat',
                                        'fit_with_notes' => 'Sehat Dengan Catatan',
                                        'unfit' => 'Tidak Sehat',
                                    ])
                                    ->inline(),
                                RichEditor::make('preMedicalResults.overall_note')
                                    ->label('Catatan Keseluruhan')
                                    ->required(),
                                DateTimePicker::make('preMedicalResults.examined_at')
                                    ->label('Tanggal Pemeriksaan')
                                    ->required(),
                            ]),
                    ])
                    ->label('Pemeriksaan')
                    ->modalWidth(Width::SevenExtraLarge)
                    ->action(function (array $data, $record) {
                        // dd($data);
                        $preMedicalResult = $record->preMedicalResult()->create(array_merge($data['preMedicalResults'], [
                            'examined_by' => auth()->id(),
                        ]));

                        $preMedicalResult->preMedicalHistory()->create($data['preMedicalHistory']);
                        $preMedicalResult->preMedicalPhysical()->create($data['preMedicalPhysical']);
                        $preMedicalResult->preMedicalEnt()->create($data['preMedicalEnt']);
                        $preMedicalResult->preMedicalEye()->create($data['preMedicalEyes']);
                        $preMedicalDental = $preMedicalResult->preMedicalDental()->create($data['preMedicalDentals']);
                        $preMedicalDental->preMedicalDentalFindings()->createMany($data['preMedicalDentalFindings']);
                        $preMedicalResult->preMedicalObgyn()->create($data['preMedicalObgyns']);
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
