<?php

namespace App\Filament\Resources\Interviews\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Interviews\InterviewResource;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Interviews\Pages\ListCriterias;

class CriteriasRelationManager extends RelationManager
{
    protected static string $relationship = 'criterias';
    protected static ?string $title = 'Kriteria penilaian wawancara';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('label')
                ->label('Kriteria')
                ->required(),
            Textarea::make('description')
                ->label('Deskripsi')
                ->required(),
            TextInput::make('order')
                ->label('Urutan')
                ->required()
                ->numeric(),
            TextInput::make('weight')
                ->label('Bobot')
                ->required()
                ->numeric(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Kriteria'),
                TextColumn::make('description')
                    ->label('Deskripsi'),
                TextColumn::make('order')
                    ->label('Urutan'),
                TextColumn::make('weight')
                    ->label('Bobot'),
            ])
             ->recordActions([
                Action::make('ViewCriteria')
                    ->label('Periksa Kriteria')
                    ->url(fn ($record) => ListCriterias::getUrl(['record' => $record->getKey()])),
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Kriteria')
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $this->getOwnerRecord()->criterias()->create($data);
                    }),
            ]);
    }
}
