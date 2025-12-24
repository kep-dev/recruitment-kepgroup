<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Tables;

use App\Models\JobVacancy;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Radio;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use App\Models\PreMedical\DentalTeeth;
use Filament\Actions\DeleteBulkAction;
use App\Models\PreMedical\DentalStatus;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use App\Models\PreMedical\PreMedicalExamItem;
use App\Models\PreMedical\PreMedicalExamSection;
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
                    ->closeModalByClickingAway(false)
                    ->databaseTransaction()
                    ->steps([
                        Step::make('Anamesis')
                            ->schema([
                                RichEditor::make('preMedicalHistory.anamesis')
                                    ->label('Anamesis'),
                                RichEditor::make('preMedicalHistory.personal_history')
                                    ->label('Riwayat Penyakit Terdahulu'),
                                RichEditor::make('preMedicalHistory.family_history')
                                    ->label('Riwayat Penyakit Keluarga'),
                                RichEditor::make('preMedicalHistory.allergies')
                                    ->label('Alergi'),
                                RichEditor::make('preMedicalHistory.current_medications')
                                    ->label('Obat yang sedang digunakan'),
                                RichEditor::make('preMedicalHistory.past_surgeries')
                                    ->label('Riwayat Operasi'),
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
                                    ->label('Catatan Lain'),
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

                                        Section::make('Pemeriksaan Fisik')
                                            ->columns(12)
                                            ->schema([
                                                TextInput::make('preMedicalPhysical.height_cm')
                                                    ->label('Tinggi (cm)')
                                                    ->numeric()
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                                        $weight = $get('preMedicalPhysical.weight_kg');
                                                        $height = $state;
                                                        if (! $weight || ! $height) {
                                                            $set('preMedicalPhysical.bmi', null);
                                                            return;
                                                        }
                                                        $h = (float) $height / 100.0;
                                                        if ($h <= 0) {
                                                            $set('preMedicalPhysical.bmi', null);
                                                            return;
                                                        }
                                                        $bmi = $weight / ($h * $h);
                                                        $set('preMedicalPhysical.bmi', round($bmi, 1));
                                                    })
                                                    ->columnSpan(4),

                                                TextInput::make('preMedicalPhysical.weight_kg')
                                                    ->label('Berat (kg)')
                                                    ->numeric()
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                                        $height = $get('preMedicalPhysical.height_cm');
                                                        $weight = $state;
                                                        if (! $weight || ! $height) {
                                                            $set('preMedicalPhysical.bmi', null);
                                                            return;
                                                        }
                                                        $h = (float) $height / 100.0;
                                                        if ($h <= 0) {
                                                            $set('preMedicalPhysical.bmi', null);
                                                            return;
                                                        }
                                                        $bmi = $weight / ($h * $h);
                                                        $set('preMedicalPhysical.bmi', round($bmi, 1));
                                                    })
                                                    ->columnSpan(4),
                                                TextInput::make('preMedicalPhysical.temperature_c')
                                                    ->label('Suhu (°C)')
                                                    ->columnSpan(4),
                                                TextInput::make('preMedicalPhysical.bp_systolic')
                                                    ->label('Tekanan Darah Sistolik (mmHg)')
                                                    ->columnSpan(3),
                                                TextInput::make('preMedicalPhysical.bp_diastolic')
                                                    ->label('Tekanan Darah Diastolik (mmHg)')
                                                    ->columnSpan(3),
                                                TextInput::make('preMedicalPhysical.heart_rate_bpm')
                                                    ->label('Nadi (bpm)')
                                                    ->columnSpan(3),
                                                TextInput::make('preMedicalPhysical.resp_rate_per_min')
                                                    ->label('Respirasi (per menit)')
                                                    ->columnSpan(3),
                                                Repeater::make('preMedicalPhysical.itemChecks')
                                                    ->minItems(1)
                                                    ->maxItems(1)
                                                    ->defaultItems(1)
                                                    ->schema(function () {
                                                        $components = [];

                                                        $sections = PreMedicalExamSection::query()
                                                            ->where('type', 'physic')
                                                            ->orderBy('order')
                                                            ->with(['subSections' => function ($q) {
                                                                $q
                                                                    ->orderBy('order')->with(['items' => function ($q2) {
                                                                        $q2->orderBy('order');
                                                                    }]);
                                                            }])
                                                            ->get();

                                                        foreach ($sections as $section) {
                                                            $subSectionComponents = [];

                                                            foreach ($section->subSections as $sub) {
                                                                $itemComponents = [];

                                                                foreach ($sub->items as $item) {
                                                                    $itemComponents[] = Hidden::make('pre_medical_exam_item_id_' . $item->id)->default($item->id);

                                                                    $itemComponents[] = Radio::make("value_{$item->id}")
                                                                        ->label($item->name)
                                                                        ->live()
                                                                        ->options(
                                                                            $item->value_type === 'yes_no'
                                                                                ? ['yes' => 'Ya', 'no' => 'Tidak']
                                                                                : ['normal' => 'Normal', 'abnormal' => 'Abnormal']
                                                                        )
                                                                        ->columnSpanFull();

                                                                    $itemComponents[] = Textarea::make("note_{$item->id}")
                                                                        ->visible(fn($get) => in_array($get("value_{$item->id}"), ['no', 'abnormal']))
                                                                        ->columnSpanFull();
                                                                }

                                                                $subSectionComponents[] = Section::make($sub->name)
                                                                    ->schema($itemComponents)
                                                                    ->columns(12)
                                                                    ->columnSpanFull();
                                                            }

                                                            $components[] = Section::make($section->name)
                                                                ->schema($subSectionComponents)
                                                                ->columns(12)
                                                                ->columnSpanFull();
                                                        }

                                                        return $components;
                                                    })
                                                    ->columnSpanFull(),
                                                TextInput::make('preMedicalPhysical.bmi')
                                                    ->label('BMI')
                                                    ->readOnly()
                                                    ->numeric()
                                                    ->columnSpan(6),
                                                TextInput::make('preMedicalPhysical.blood_type')
                                                    ->label('Golongan Darah')
                                                    ->columnSpan(6),
                                            ])
                                            ->columnSpanFull(),

                                        Section::make('Pemeriksaan THT')
                                            ->schema([
                                                // RichEditor::make('preMedicalEnt.ear')
                                                //     ->label('Pemeriksaan Telinga')
                                                //     ->columnSpanFull(),
                                                // RichEditor::make('preMedicalEnt.nose')
                                                //     ->label('Pemeriksaan Hidung')
                                                //     ->columnSpanFull(),
                                                // RichEditor::make('preMedicalEnt.throat')
                                                //     ->label('Pemeriksaan Tenggorokan')
                                                //     ->columnSpanFull(),

                                                Repeater::make('preMedicalEnt.itemChecks')
                                                    ->maxItems(1)
                                                    ->schema(function () {
                                                        $components = [];

                                                        $sections = PreMedicalExamSection::query()
                                                            ->where('type', 'ent')
                                                            ->orderBy('order')
                                                            ->with(['subSections' => function ($q) {
                                                                $q
                                                                    ->orderBy('order')->with(['items' => function ($q2) {
                                                                        $q2->orderBy('order');
                                                                    }]);
                                                            }])
                                                            ->get();

                                                        foreach ($sections as $section) {
                                                            $subSectionComponents = [];

                                                            foreach ($section->subSections as $sub) {
                                                                $itemComponents = [];

                                                                foreach ($sub->items as $item) {
                                                                    $itemComponents[] = Hidden::make('pre_medical_exam_item_id_' . $item->id)->default($item->id);

                                                                    $itemComponents[] = Radio::make("value_{$item->id}")
                                                                        ->label($item->name)
                                                                        ->live()
                                                                        ->options(
                                                                            $item->value_type === 'yes_no'
                                                                                ? ['yes' => 'Ya', 'no' => 'Tidak']
                                                                                : ['normal' => 'Normal', 'abnormal' => 'Abnormal']
                                                                        )
                                                                        ->columnSpanFull();

                                                                    $itemComponents[] = Textarea::make("note_{$item->id}")
                                                                        ->visible(fn($get) => in_array($get("value_{$item->id}"), ['no', 'abnormal']))
                                                                        ->columnSpanFull();
                                                                }

                                                                $subSectionComponents[] = Section::make($sub->name)
                                                                    ->schema($itemComponents)
                                                                    ->columns(12)
                                                                    ->columnSpanFull();
                                                            }

                                                            $components[] = Section::make($section->name)
                                                                ->schema($subSectionComponents)
                                                                ->columns(12)
                                                                ->columnSpanFull();
                                                        }

                                                        return $components;
                                                    })
                                                    ->columnSpanFull(),

                                                RichEditor::make('preMedicalEnt.others')
                                                    ->label('Pemeriksaan lainnya')

                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),

                                        Section::make('Pemeriksaan Mata')
                                            ->schema([
                                                Section::make('Tanpa Kacamata')
                                                    ->columns(12)
                                                    ->schema([
                                                        Select::make('preMedicalEyes.va_unaided_right')
                                                            ->label('Tanpa Kacamata Kanan')
                                                            ->options([
                                                                '6/15' => '6/15',
                                                                '6/20' => '6/20',
                                                                '6/25' => '6/25',
                                                                '6/30' => '6/30',
                                                                '6/40' => '6/40',
                                                                '6/50' => '6/50',
                                                                '6/60' => '6/60',
                                                                '6/80' => '6/80',
                                                                '6/120' => '6/120',
                                                            ])
                                                            ->columnSpan(6),

                                                        Select::make('preMedicalEyes.va_unaided_left')
                                                            ->label('Tanpa Kacamata Kiri')
                                                            ->options([
                                                                '6/15' => '6/15',
                                                                '6/20' => '6/20',
                                                                '6/25' => '6/25',
                                                                '6/30' => '6/30',
                                                                '6/40' => '6/40',
                                                                '6/50' => '6/50',
                                                                '6/60' => '6/60',
                                                                '6/80' => '6/80',
                                                                '6/120' => '6/120',
                                                            ])
                                                            ->columnSpan(6),
                                                    ])
                                                    ->columnSpanFull(),

                                                Section::make('Dengan Kacamata')
                                                    ->columns(12)
                                                    ->schema([
                                                        Select::make('preMedicalEyes.va_aided_right')
                                                            ->label('Dengan Kacamata Kanan')
                                                            ->options([
                                                                '6/15' => '6/15',
                                                                '6/20' => '6/20',
                                                                '6/25' => '6/25',
                                                                '6/30' => '6/30',
                                                                '6/40' => '6/40',
                                                                '6/50' => '6/50',
                                                                '6/60' => '6/60',
                                                                '6/80' => '6/80',
                                                                '6/120' => '6/120',
                                                            ])
                                                            ->columnSpan(6),

                                                        Select::make('preMedicalEyes.va_aided_left')
                                                            ->label('Tanpa Kacamata Kiri')
                                                            ->options([
                                                                '6/15' => '6/15',
                                                                '6/20' => '6/20',
                                                                '6/25' => '6/25',
                                                                '6/30' => '6/30',
                                                                '6/40' => '6/40',
                                                                '6/50' => '6/50',
                                                                '6/60' => '6/60',
                                                                '6/80' => '6/80',
                                                                '6/120' => '6/120',
                                                            ])
                                                            ->columnSpan(6),
                                                    ])
                                                    ->columnSpanFull(),
                                                // ToggleButtons::make('preMedicalEyes.color_vision')
                                                //     ->label('Buta Warna')
                                                //     ->options([
                                                //         'normal' => 'Normal',
                                                //         'partial' => 'Sebagian',
                                                //         'total' => 'Total'
                                                //     ])
                                                //     ->columnSpanFull()
                                                //     ->inline(),
                                                // RichEditor::make('preMedicalEyes.conjunctiva')
                                                //     ->label('Ketajaman Penglihatan')
                                                //     ->columnSpanFull(),
                                                // RichEditor::make('preMedicalEyes.sclera')
                                                //     ->label('Sclera')
                                                //     ->columnSpanFull(),
                                                Repeater::make('preMedicalEyes.itemChecks')
                                                    ->label('Pemeriksaan Mata')
                                                    ->maxItems(1)
                                                    ->schema(function () {
                                                        $components = [];

                                                        $sections = PreMedicalExamSection::query()
                                                            ->where('type', 'eye')
                                                            ->orderBy('order')
                                                            ->with(['subSections' => function ($q) {
                                                                $q
                                                                    ->orderBy('order')->with(['items' => function ($q2) {
                                                                        $q2->orderBy('order');
                                                                    }]);
                                                            }])
                                                            ->get();

                                                        foreach ($sections as $section) {
                                                            $subSectionComponents = [];

                                                            foreach ($section->subSections as $sub) {
                                                                $itemComponents = [];

                                                                foreach ($sub->items as $item) {
                                                                    $itemComponents[] = Hidden::make('pre_medical_exam_item_id_' . $item->id)->default($item->id);

                                                                    $itemComponents[] = Radio::make("value_{$item->id}")
                                                                        ->label($item->name)
                                                                        ->live()
                                                                        ->options(
                                                                            $item->value_type === 'yes_no'
                                                                                ? ['yes' => 'Ya', 'no' => 'Tidak']
                                                                                : ['normal' => 'Normal', 'abnormal' => 'Abnormal']
                                                                        )
                                                                        ->columnSpanFull();

                                                                    $itemComponents[] = Textarea::make("note_{$item->id}")
                                                                        ->visible(fn($get) => in_array($get("value_{$item->id}"), ['no', 'abnormal']))
                                                                        ->columnSpanFull();
                                                                }

                                                                $subSectionComponents[] = Section::make($sub->name)
                                                                    ->schema($itemComponents)
                                                                    ->columns(12)
                                                                    ->columnSpanFull();
                                                            }

                                                            $components[] = Section::make($section->name)
                                                                ->schema($subSectionComponents)
                                                                ->columns(12)
                                                                ->columnSpanFull();
                                                        }

                                                        return $components;
                                                    })
                                                    ->columnSpanFull(),

                                                RichEditor::make('preMedicalEyes.others')
                                                    ->label('Pemeriksaan lainnya')

                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),

                                        Section::make('Pemeriksaan Gigi')
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
                                                            ),
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
                                                    ->columnSpanFull(),
                                                RichEditor::make('preMedicalDentals.occlusion')
                                                    ->label('Pemeriksaan Oklusif')
                                                    ->columnSpanFull(),
                                                RichEditor::make('preMedicalDentals.others')
                                                    ->label('Pemeriksaan lainnya')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),

                                        Section::make('Pemeriksaan Kandungan')
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
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Step::make('Pemeriksaan Penunjang')
                            ->schema([
                                RichEditor::make('preMedicalSupportExaminations.complete_blood')
                                    ->label('Darah Lengkap')
                                    ->required(),
                                RichEditor::make('preMedicalSupportExaminations.colesterol')
                                    ->label('Kolesterol')
                                    ->required(),
                                RichEditor::make('preMedicalSupportExaminations.blood_sugar')
                                    ->label('Gula Darah')
                                    ->required(),
                                RichEditor::make('preMedicalSupportExaminations.gout')
                                    ->label('Asam Urat')
                                    ->required(),
                                RichEditor::make('preMedicalSupportExaminations.ro')
                                    ->label('Rongen Thorax')
                                    ->required(),
                                RichEditor::make('preMedicalSupportExaminations.others')
                                    ->label('Pemeriksaan lainnya')
                                    ->required(),
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
                    ->fillForm(function ($record): array {
                        $pre = $record->preMedicalResult()
                            ->with([
                                'preMedicalHistory',
                                'preMedicalPhysical',
                                'preMedicalEnt',
                                'preMedicalEye',
                                'preMedicalDental.preMedicalDentalFindings',
                                'preMedicalObgyn',
                            ])->first();

                        if (! $pre) {
                            return []; // pertama kali (create), biarkan kosong
                        }

                        $only = fn($model, array $fields) =>
                        Arr::only(($model?->toArray() ?? []), $fields);

                        return [
                            'preMedicalResults' => $only($pre, [
                                'overall_status',
                                'overall_note',
                                'examined_at',
                            ]),

                            'preMedicalHistory' => $only($pre->preMedicalHistory, [
                                'complaint',
                                'anamesis',
                                'personal_history',
                                'family_history',
                                'allergies',
                                'current_medications',
                                'past_surgeries',
                                'smoking_status',
                                'alcohol_use',
                                'other_notes',
                            ]),

                            'preMedicalPhysical' => (function () use ($pre, $only) {
                                $physical = $only($pre->preMedicalPhysical, [
                                    'height_cm',
                                    'weight_kg',
                                    'temperature_c',
                                    'bp_systolic',
                                    'bp_diastolic',
                                    'heart_rate_bpm',
                                    'resp_rate_per_min',
                                    'head_neck',
                                    'chest_heart',
                                    'chest_lung',
                                    'abdomen_liver',
                                    'abdomen_spleen',
                                    'extremities',
                                    'others',
                                    'bmi',
                                    'blood_type'
                                ]);

                                $itemChecks = [];
                                if ($pre->preMedicalPhysical?->itemChecks) {
                                    $itemChecks = [
                                        collect($pre->preMedicalPhysical->itemChecks->map(function ($c) {
                                            return [
                                                "pre_medical_exam_item_id_{$c->pre_medical_exam_item_id}" => $c->pre_medical_exam_item_id,
                                                "value_{$c->pre_medical_exam_item_id}" => $c->value,
                                                "note_{$c->pre_medical_exam_item_id}" => $c->note,
                                            ];
                                        })->all())->collapse()->toArray()
                                    ];
                                }

                                $physical['itemChecks'] = $itemChecks;

                                return $physical;
                            })(),

                            'preMedicalEnt' => (function () use ($pre, $only) {
                                $ent = $only($pre->preMedicalEnt, [
                                    'ear',
                                    'nose',
                                    'throat',
                                    'others',
                                ]);

                                $itemChecks = [];
                                if ($pre->preMedicalEnt?->itemChecks) {
                                    $itemChecks = [
                                        collect($pre->preMedicalEnt->itemChecks->map(function ($c) {
                                            return [
                                                "pre_medical_exam_item_id_{$c->pre_medical_exam_item_id}" => $c->pre_medical_exam_item_id,
                                                "value_{$c->pre_medical_exam_item_id}" => $c->value,
                                                "note_{$c->pre_medical_exam_item_id}" => $c->note,
                                            ];
                                        })->all())->collapse()->toArray()
                                    ];
                                }

                                $ent['itemChecks'] = $itemChecks;

                                return $ent;
                            })(),

                            'preMedicalEyes' => (function () use ($pre, $only) {
                                $eyes = $only($pre->preMedicalEye, [
                                    'va_unaided_right',
                                    'va_unaided_left',
                                    'va_aided_right',
                                    'va_aided_left',
                                    'color_vision',
                                    'conjunctiva',
                                    'sclera',
                                    'others',
                                ]);

                                $itemChecks = [];
                                if ($pre->preMedicalEye?->itemChecks) {
                                    $itemChecks = [
                                        collect($pre->preMedicalEye->itemChecks->map(function ($c) {
                                            return [
                                                "pre_medical_exam_item_id_{$c->pre_medical_exam_item_id}" => $c->pre_medical_exam_item_id,
                                                "value_{$c->pre_medical_exam_item_id}" => $c->value,
                                                "note_{$c->pre_medical_exam_item_id}" => $c->note,
                                            ];
                                        })->all())->collapse()->toArray()
                                    ];
                                }

                                $eyes['itemChecks'] = $itemChecks;

                                return $eyes;
                            })(),

                            'preMedicalSupportExaminations' => $only($pre->preMedicalSupportExaminations, [
                                'complete_blood',
                                'colesterol',
                                'blood_sugar',
                                'gout',
                                'ro',
                                'others',
                            ]),

                            'preMedicalDentals' => $only($pre->preMedicalDental, [
                                'general_condition',
                                'occlusion',
                                'others',
                            ]),

                            'preMedicalDentalFindings' => $pre->preMedicalDental?->preMedicalDentalFindings
                                ->map(fn($f) => Arr::only($f->toArray(), [
                                    'dental_teeth_id',
                                    'dental_status_id',
                                    'surfaces',
                                    'severity',
                                    'notes',
                                ]))->all() ?? [],

                            'preMedicalObgyns' => $only($pre->preMedicalObgyn, [
                                'is_pregnant',
                                'lmp_date',
                                'gravida',
                                'para',
                                'abortus',
                                'uterus_exam',
                                'adnexa_exam',
                                'cervix_exam',
                                'others',
                            ]),
                        ];
                    })

                    ->action(function (array $data, $record) {
                        // header (result)
                        $pre = $record->preMedicalResult()->first();

                        if (! $pre) {
                            $pre = $record->preMedicalResult()->create(array_merge(
                                $data['preMedicalResults'] ?? [],
                                ['examined_by' => auth()->id()],
                            ));
                        } else {
                            $pre->update(array_merge(
                                $data['preMedicalResults'] ?? [],
                                ['examined_by' => auth()->id()],
                            ));
                        }

                        // hasOne: aman gunakan updateOrCreate([],...)
                        $pre->preMedicalHistory()->updateOrCreate([], $data['preMedicalHistory'] ?? []);
                        $physicalData = $data['preMedicalPhysical'] ?? [];
                        if (is_array($physicalData) && array_key_exists('itemChecks', $physicalData)) {
                            unset($physicalData['itemChecks']);
                        }
                        $pre->preMedicalPhysical()->updateOrCreate([], $physicalData ?? []);
                        $pre->preMedicalEnt()->updateOrCreate([], $data['preMedicalEnt'] ?? []);
                        $pre->preMedicalEye()->updateOrCreate([], $data['preMedicalEyes'] ?? []);
                        $pre->preMedicalObgyn()->updateOrCreate([], $data['preMedicalObgyns'] ?? []);
                        $pre->preMedicalSupportingExamination()->updateOrCreate([], $data['preMedicalSupportExaminations'] ?? []);

                        // Helper to persist itemChecks for a given form path and relation
                        $processChecks = function (string $formPath, string $relationMethod) use ($data, $pre) {
                            $group = data_get($data, $formPath);
                            if (! is_array($group) || empty($group)) {
                                return;
                            }

                            // repeater structure: first element contains collapsed keys
                            $fields = $group[0] ?? [];
                            $collected = [];
                            foreach ($fields as $k => $v) {
                                if (preg_match('/^value_(\d+)$/', $k, $m)) {
                                    $id = $m[1];
                                    $collected[$id]['value'] = $v;
                                }
                                if (preg_match('/^note_(\d+)$/', $k, $m)) {
                                    $id = $m[1];
                                    $collected[$id]['note'] = $v;
                                }
                                if (preg_match('/^pre_medical_exam_item_id_(\d+)$/', $k, $m)) {
                                    $id = $m[1];
                                    $collected[$id]['pre_medical_exam_item_id'] = $v;
                                }
                            }

                            $model = $pre->{$relationMethod}()->first();
                            if (! $model) {
                                return;
                            }

                            $model->itemChecks()->delete();
                            foreach ($collected as $itemId => $row) {
                                $physicalExamItemId = $row['pre_medical_exam_item_id'] ?? $itemId;
                                $model->itemChecks()->create([
                                    'pre_medical_exam_item_id' => $physicalExamItemId,
                                    'value' => $row['value'] ?? null,
                                    'note' => $row['note'] ?? null,
                                ]);
                            }
                        };

                        $processChecks('preMedicalPhysical.itemChecks', 'preMedicalPhysical');
                        $processChecks('preMedicalEnt.itemChecks', 'preMedicalEnt');
                        $processChecks('preMedicalEyes.itemChecks', 'preMedicalEye');

                        // dental header + findings (hasMany): replace sederhana
                        $dental = $pre->preMedicalDental()->updateOrCreate([], $data['preMedicalDentals'] ?? []);
                        $dental->preMedicalDentalFindings()->delete();
                        if (! empty($data['preMedicalDentalFindings'])) {
                            $dental->preMedicalDentalFindings()->createMany($data['preMedicalDentalFindings']);
                        }
                    }),
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
