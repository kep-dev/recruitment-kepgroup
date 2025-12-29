<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use Dom\Text;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Applicants\ApplicantResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class EducationsRelationManager extends RelationManager
{
    protected static string $relationship = 'educations';
    protected static ?string $title = 'Pendidikan Terakhir';
    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('education_level')
                    ->label('Tingkat Pendidikan'),
                TextColumn::make('major')
                    ->label('Jurusan'),
                TextColumn::make('university')
                    ->label('Universitas'),
                TextColumn::make('location')
                    ->label('Lokasi'),
                TextColumn::make('graduation_year')
                    ->label('Tahun Lulus'),
                TextColumn::make('certificate_number')
                    ->label('No. Ijazah'),
                TextColumn::make('main_number')
                    ->label('NIM/NIP'),
                TextColumn::make('gpa')
                    ->label('IPK'),
                TextColumn::make('education_verification_link')
                    ->color('primary')
                    ->label('Link Verifikasi Pendidikan')
                    ->icon(LucideIcon::Link)
                    ->formatStateUsing(fn ($state) => $state ? 'Terverifikasi oleh PDDIKTI' : 'belum dilakukan verifikasi')
                    ->url(fn ($record) => $record->education_verification_link)
                    ->openUrlInNewTab(),
            ])
            ->headerActions([])
            ->recordActions([
                Action::make('addVerificationLink')
                    ->label(fn ($record) => $record->education_verification_link ? 'Edit Verifikasi Pendidikan' : 'Tambah Verifikasi Pendidikan')
                    ->icon(LucideIcon::ShieldCheck)
                    ->schema([
                        TextInput::make('education_verification_link')
                            ->label('Link Verifikasi Pendidikan')
                            ->required()
                            ->url()
                            ->default(fn ($record) => $record->education_verification_link),
                    ])
                    ->modalHeading(fn ($record) => $record->education_verification_link ? 'Edit Link Verifikasi' : 'Tambah Link Verifikasi')
                    ->action(function ($record, array $data) {
                        $record->education_verification_link = $data['education_verification_link'];
                        $record->save();
                    }),
            ]);
    }
}
