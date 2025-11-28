<?php

namespace App\Filament\Resources\JobVacancyTests\RelationManagers;

use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;
use App\Models\Psychotest\PsychotestForm;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PsychotestFormsRelationManager extends RelationManager
{
    protected static string $relationship = 'psychotestForms';

    protected static ?string $title = 'Daftar Psikotest';

    public function isReadOnly(): bool
    {
        return false;
    }

    // protected static ?string $relatedResource = JobVacancyTestResource::class;

    public function getFormSchema(): array
    {
        return [
            Select::make('psychotest_form_id')
                ->label('Formulir Psikotest')
                ->options(PsychotestForm::all()->pluck('name', 'id'))
                ->required(),

            TextInput::make('order')
                ->label('Urutan')
                ->required(),

            TextInput::make('duration_minutes')
                ->label('Durasi (Menit)')
                ->required(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('psychotestForm.name')
                    ->label('Formulir Psikotest'),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Durasi (Menit)')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Psikotest')
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->psychotestForms()->create($data);
                    }),
            ]);
    }
}
