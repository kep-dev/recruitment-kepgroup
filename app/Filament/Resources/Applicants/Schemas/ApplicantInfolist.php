<?php

namespace App\Filament\Resources\Applicants\Schemas;

use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;

class ApplicantInfolist
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
                            ->columns(12)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                                'lg' => 8,
                                'xl' => 8,
                            ])
                            ->columnSpanFull()
                            ->schema([
                                // Header Profil
                                Section::make('Profil')
                                    ->icon('heroicon-o-user-circle')
                                    ->description('Informasi akun & identitas dasar.')
                                    ->columns(12)
                                    ->columnSpanFull()
                                    ->schema([
                                        // Avatar (opsional)
                                        ImageEntry::make('photo')
                                            ->label(' ')
                                            ->columnSpan(3)
                                            ->circular(),

                                        Grid::make()
                                            ->columns(12)
                                            ->columnSpan(fn($record) => data_get($record, 'photo') ? 9 : 12)
                                            ->schema([
                                                TextEntry::make('user.name')
                                                    ->label('Nama')
                                                    ->icon('heroicon-o-identification')
                                                    ->columnSpan(12),

                                                TextEntry::make('user.email')
                                                    ->label('Email')
                                                    ->icon('heroicon-o-envelope')
                                                    ->copyable()
                                                    ->copyMessage('Email disalin')
                                                    ->copyMessageDuration(1200)
                                                    ->url(fn($record) => 'mailto:' . data_get($record, 'user.email'), true)
                                                    ->openUrlInNewTab()
                                                    ->columnSpan(12),
                                            ]),
                                    ]),

                                // Identitas
                                Section::make('Identitas')
                                    ->icon('heroicon-o-identification')
                                    ->columns(12)
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('nik')
                                            ->label('NIK')
                                            ->placeholder('-')
                                            ->columnSpan(6),

                                        TextEntry::make('date_of_birth')
                                            ->label('Tanggal Lahir')
                                            ->date('d M Y')
                                            ->placeholder('-')
                                            ->icon('heroicon-o-calendar')
                                            ->columnSpan(6),
                                    ]),

                                // Kontak & Domisili
                                Section::make('Kontak & Domisili')
                                    ->icon('heroicon-o-map-pin')
                                    ->columns(12)
                                    ->columnSpanFull()
                                    ->schema([
                                        TextEntry::make('phone_number')
                                            ->label('Nomor Telepon')
                                            ->icon('heroicon-o-phone')
                                            ->placeholder('-')
                                            ->url(
                                                fn($record) => ($tel = preg_replace('/\D+/', '', (string) data_get($record, 'phone_number')))
                                                    ? 'tel:+' . $tel
                                                    : null,
                                                true
                                            )
                                            ->openUrlInNewTab()
                                            ->copyable()
                                            ->copyMessage('Nomor disalin')
                                            ->columnSpan(6),

                                        TextEntry::make('gender')
                                            ->label('Jenis Kelamin')
                                            ->placeholder('-')
                                            ->formatStateUsing(fn($state) => $state === 'male' ? 'Laki-laki' : 'Perempuan')
                                            ->badge()
                                            ->icon(fn($state) => match (strtolower((string) $state)) {
                                                'male' => LucideIcon::Venus,
                                                'female' => LucideIcon::Mars,
                                            })
                                            ->color(fn($state) => match (strtolower((string) $state)) {
                                                'l', 'laki-laki', 'male', 'm' => 'info',
                                                'p', 'perempuan', 'female', 'f' => 'pink',
                                                default => 'gray',
                                            })
                                            ->columnSpan(6),

                                        TextEntry::make('city')
                                            ->label('Kota')
                                            ->placeholder('-')
                                            ->icon('heroicon-o-building-office-2')
                                            ->columnSpan(6),

                                        TextEntry::make('province')
                                            ->label('Provinsi')
                                            ->formatStateUsing(function ($state, $record) {
                                                if (!$record) {
                                                    return '-';
                                                }

                                                return collect([
                                                    $record->province?->name,
                                                    $record->district?->name,
                                                    $record->regency?->name,
                                                    $record->village?->name,
                                                    $record->address_line,
                                                ])
                                                    ->filter() // hilangkan null
                                                    ->join(', ');
                                            })
                                            ->placeholder('-')
                                            ->icon('heroicon-o-map')
                                            ->columnSpan(6)
                                    ]),
                            ]),

                        // ====== KANAN (4 kolom) ======
                        Grid::make()
                            ->columns(12)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->columnSpanFull()
                            ->schema([
                                // Skills
                                Section::make('Keahlian')
                                    ->columnSpanFull()
                                    ->icon('heroicon-o-sparkles')
                                    ->description('Kemampuan utama kandidat.')
                                    ->schema([
                                        TextEntry::make('skills.skill')
                                            ->badge()
                                            ->listWithLineBreaks(),
                                    ]),

                                // Fungsi Minat
                                Section::make('Fungsi Minat')
                                    ->columnSpanFull()
                                    ->icon('heroicon-o-heart')
                                    ->schema([
                                        RepeatableEntry::make('functionOfInterests')
                                            ->label('Fungsi')
                                            ->schema([
                                                TextEntry::make('function_of_interest')
                                                    ->label(' ')
                                                    ->badge()
                                                    ->placeholder('-'),
                                            ]),
                                    ]),

                                // Bahasa
                                Section::make('Bahasa')
                                    ->columnSpanFull()
                                    ->icon('heroicon-o-language')
                                    ->schema([
                                        RepeatableEntry::make('languages')
                                            ->hiddenLabel(true)
                                            ->table([
                                                TableColumn::make('Bahasa'),
                                                TableColumn::make('Level'),
                                            ])
                                            ->schema([
                                                TextEntry::make('language'),
                                                TextEntry::make('level'),
                                            ])

                                    ]),

                                // Sosial Media
                                Section::make('Sosial Media')
                                    ->columnSpanFull()
                                    ->icon('heroicon-o-share')
                                    ->schema([
                                        RepeatableEntry::make('socialMedias')
                                            ->hiddenLabel(true)
                                            ->table([
                                                TableColumn::make('Platform'),
                                                TableColumn::make('URL'),
                                            ])
                                            ->schema([
                                                TextEntry::make('name')
                                                    ->label('Platform'),
                                                TextEntry::make('url')
                                                    ->label('URL')
                                                    ->url(fn($state) => filled($state) ? $state : null, true)
                                                    ->openUrlInNewTab(),
                                            ])

                                    ]),

                                // Gaji
                                Section::make('Informasi Gaji')
                                    ->columnSpanFull()
                                    ->icon('heroicon-o-banknotes')
                                    ->columns(12)
                                    ->schema([
                                        TextEntry::make('salaries.0.expected_salary')
                                            ->label('Ekspektasi')
                                            ->icon('heroicon-o-currency-dollar')
                                            ->formatStateUsing(fn($state) => filled($state)
                                                ? 'Rp ' . number_format((float) $state, 0, ',', '.')
                                                : '-')
                                            ->badge()
                                            ->color('info')
                                            ->columnSpan(6),

                                        TextEntry::make('salaries.0.current_salary')
                                            ->label('Saat Ini')
                                            ->formatStateUsing(fn($state) => filled($state)
                                                ? 'Rp ' . number_format((float) $state, 0, ',', '.')
                                                : '-')
                                            ->badge()
                                            ->color('gray')
                                            ->columnSpan(6),
                                    ]),
                            ]),
                    ])
            ]);
    }
}
