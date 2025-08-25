<?php

namespace App\Filament\Resources\JobVacancies\Schemas;

use App\Models\JobLevel;
use App\Models\WorkType;
use App\Models\Placement;
use Illuminate\Support\Str;
use App\Models\EmployeeType;
use Filament\Schemas\Schema;
use App\Models\BenefitCategory;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\JobVacancies\JobVacancyResource;

class JobVacancyForm
{
    protected static string $resource = JobVacancyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        logger()->info('Mutated data before create', $data);
        return $data;
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([

                        Grid::make()
                            ->columns(8)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                                'lg' => 8,
                            ])->schema([
                                Section::make('Informasi Pekerjaan')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 8,
                                        'xl' => 9
                                    ])
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Judul')
                                            ->columnSpanFull()
                                            ->required(),

                                        RichEditor::make('description')
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('requirements')
                                            ->required()
                                            ->columnSpanFull(),
                                        TextInput::make('salary')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Keuntungan dan Manfaat')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 8,
                                        'xl' => 9
                                    ])
                                    ->schema([
                                        Repeater::make('benefits')
                                            ->relationship('benefits')
                                            ->columns(12)
                                            ->columnSpanFull()
                                            ->hiddenLabel()
                                            ->addActionLabel('Tambah Keuntungan dan Manfaat')
                                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                                $data['job_vacancy_id'] = $data['job_vacancy_id'] ?? null;

                                                return $data;
                                            })
                                            ->schema([
                                                Select::make('benefit_category_id')
                                                    ->label('Kategori Keuntungan')
                                                    ->options(BenefitCategory::all()->pluck('name', 'id'))
                                                    ->columnSpan([
                                                        'sm' => 12,
                                                        'md' => 6,
                                                        'lg' => 6,
                                                    ])
                                                    ->searchable()
                                                    ->required(),
                                                TextInput::make('description')
                                                    ->label('Deskripsi')
                                                    ->placeholder('Cont. BPJS Kesehatan, Asuransi, dll')
                                                    ->required()
                                                    ->columnSpan([
                                                        'sm' => 12,
                                                        'md' => 6,
                                                        'lg' => 6,
                                                    ]),
                                            ])
                                    ]),

                                Section::make('Penempatan')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 8,
                                        'xl' => 9
                                    ])
                                    ->schema([
                                        Repeater::make('placements')
                                            ->relationship('placements')
                                            ->columns(12)
                                            ->columnSpanFull()
                                            ->hiddenLabel()
                                            ->addActionLabel('Tambah Lokasi dan Penempatan')
                                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                                $data['job_vacancy_id'] = $data['job_vacancy_id'] ?? null;

                                                return $data;
                                            })
                                            ->schema([
                                                Select::make('placement_id')
                                                    ->label('Lokasi Penempatan')
                                                    ->options(Placement::all()->pluck('name', 'id'))
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required(),
                                            ])
                                    ]),
                            ]),

                        Grid::make()
                            ->columns(4)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                                'lg' => 4,
                            ])->schema([
                                Section::make('Informasi Tambahan')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 4,
                                        'xl' => 4
                                    ])
                                    ->schema([
                                        Select::make('work_type_id')
                                            ->relationship('workType', 'name')
                                            // ->searchable()
                                            ->options(WorkType::all()->pluck('name', 'id'))
                                            ->label('Jenis Pekerjaan')
                                            ->required()
                                            ->columnSpanFull(),
                                        Select::make('employee_type_id')
                                            ->relationship('employeeType', 'name')
                                            // ->searchable()
                                            ->options(EmployeeType::all()->pluck('name', 'id'))
                                            ->label('Jenis Karyawan')
                                            ->required()
                                            ->columnSpanFull(),
                                        Select::make('job_level_id')
                                        ->relationship('jobLevel', 'name')
                                            ->label('Level Jabatan')
                                            // ->searchable()
                                            ->options(JobLevel::all()->pluck('name', 'id'))
                                            ->required()
                                            ->columnSpanFull(),

                                        DatePicker::make('end_date')
                                            ->label('Tanggal Penutupan')
                                            ->columnSpanFull()
                                            ->required(),
                                        Toggle::make('status')
                                            ->label('Status Lowongan')
                                            ->columnSpanFull()
                                            ->required(),
                                    ]),

                                Section::make('Gambar Lowongan')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 4,
                                        'xl' => 4
                                    ])
                                    ->schema([
                                        FileUpload::make('image')
                                            ->required()
                                            ->image()
                                            ->columnSpanFull(),
                                    ])
                            ])
                    ])
            ]);
    }
}
