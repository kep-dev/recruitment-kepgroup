<?php

namespace App\Filament\Resources\Applicants\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Applicants\ApplicantResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\RelationManagers\RelationManager;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';
    protected static ?string $title = 'Dokumen Pendukung';
    // protected static ?string $relatedResource = ApplicantResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vacancyDocument.name')
                    ->label('Dokumen')
                    ->icon(LucideIcon::Download)
                    ->url(fn($record) => $record->getFirstMediaUrl($record->vacancyDocument->name))
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn($state) => $state ?? 'Tidak ada dokumen')
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
