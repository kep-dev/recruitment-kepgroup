<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Resources\RelationManagers\RelationManager;

class WorkExperiencesRelationManager extends RelationManager
{
    protected static string $relationship = 'workExperiences';
    protected static ?string $title = 'Pengalaman Kerja';
    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_title')
                    ->label('Jabatan'),
                TextColumn::make('company_name')
                    ->label('Perusahaan'),
                TextColumn::make('job_position')
                    ->label('Posisi'),
                TextColumn::make('industry')
                    ->label('Industri'),
                TextColumn::make('start_date')
                    ->date()
                    ->label('Mulai'),
                TextColumn::make('end_date')
                    ->date()
                    ->label('Selesai'),
                TextColumn::make('currently_working')
                    ->label('Saat Ini'),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column contents exceeds the length limit.
                        return $state;
                    }),
            ])
            ->headerActions([
                //
            ]);
    }
}
