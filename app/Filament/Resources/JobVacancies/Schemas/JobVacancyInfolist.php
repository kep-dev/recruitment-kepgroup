<?php

namespace App\Filament\Resources\JobVacancies\Schemas;

use App\Models\JobVacancy;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;

class JobVacancyInfolist
{

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
                                Section::make('Informasi Tambahan')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 8,
                                        'xl' => 8
                                    ])
                                    ->afterHeader([
                                        Action::make('updateStatus')
                                            ->label('Perbarui Status')
                                            ->icon(Heroicon::OutlinedPencilSquare)
                                            ->successNotification(
                                                Notification::make()
                                                    ->success()
                                                    ->title('Sukses')
                                                    ->body('Status lowongan pekerjaan berhasil diperbarui!'),
                                            )
                                            ->schema([
                                                Select::make('status')
                                                    ->label('status')
                                                    ->options([
                                                        '1' => 'Aktif',
                                                        '2' => 'Tidak Aktif',
                                                    ])
                                                    ->default(fn(JobVacancy $record): bool => $record->status)
                                                    ->required(),
                                            ])
                                            ->action(function (array $data, JobVacancy $record): void {
                                                $record->update($data);
                                            }),
                                    ])
                                    ->schema([
                                        TextEntry::make('title')
                                            ->label('Judul Lowongan')
                                            ->columnSpanFull(),

                                        TextEntry::make('end_date')
                                            ->date('d/m/Y')
                                            ->label('Tanggal Penutupan')
                                            ->columnSpan(4),

                                        TextEntry::make('status')
                                            ->label('Status Lowongan')
                                            ->columnSpan(4)
                                            ->formatStateUsing(fn(string $state): string => $state === '1' ? 'Aktif' : 'Tidak Aktif')
                                            ->badge(),

                                        TextEntry::make('description')
                                            ->label('Deskripsi')
                                            ->columnSpanFull()
                                            ->html(),

                                        TextEntry::make('requirements')
                                            ->label('Persyaratan')
                                            ->columnSpanFull()
                                            ->html(),
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
                                        TextEntry::make('workType.name')
                                            ->label('Jenis Pekerjaan')
                                            ->columnSpan([
                                                'sm' => 12,
                                                'md' => 4,
                                                'lg' => 4
                                            ]),
                                        TextEntry::make('employeeType.name')
                                            ->label('Jenis Pegawai')
                                            ->columnSpan([
                                                'sm' => 12,
                                                'md' => 4,
                                                'lg' => 4
                                            ]),
                                        TextEntry::make('jobLevel.name')
                                            ->label('Level Jabatan')
                                            ->columnSpan([
                                                'sm' => 12,
                                                'md' => 4,
                                                'lg' => 4
                                            ]),

                                        RepeatableEntry::make('placements')
                                            ->label('Penempatan')
                                            ->columns(12)
                                            ->columnSpanFull()
                                            ->hiddenLabel()
                                            ->schema([
                                                TextEntry::make('placement.name')
                                                    ->label('Penempatan Pekerjaan')
                                                    ->badge()
                                                    ->columnSpanFull(),
                                            ]),

                                        RepeatableEntry::make('benefits')
                                            ->columns(12)
                                            ->columnSpanFull()
                                            ->hiddenLabel()
                                            ->schema([
                                                TextEntry::make('benefitCategory.name')
                                                    ->label('Benefit dan Manfaat')
                                                    ->badge()
                                                    ->columnSpan(6),
                                                TextEntry::make('description')
                                                    ->label('Deskripsi')
                                                    ->columnSpan(6),
                                            ])
                                    ]),

                                Section::make('Poster')
                                    ->columns(12)
                                    ->columnSpan([
                                        'sm' => 12,
                                        'lg' => 4,
                                        'xl' => 4
                                    ])
                                    ->schema([
                                        ImageEntry::make('image')
                                            ->label('Poster')
                                            ->disk('public')
                                            ->hiddenLabel()
                                    ]),
                            ])
                    ])
            ]);
    }
}
