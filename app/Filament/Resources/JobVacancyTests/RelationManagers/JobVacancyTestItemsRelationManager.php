<?php

namespace App\Filament\Resources\JobVacancyTests\RelationManagers;

use PgSql\Lob;
use App\Models\Test;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\JobVacancyTest;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\JobVacancyTests\JobVacancyTestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;

class JobVacancyTestItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobVacancyTestItems';
    protected static ?string $title = 'Daftar Soal';

    // protected static ?string $relatedResource = JobVacancyTestResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('test_id')
                ->label('Soal')
                ->options(
                    Test::all()
                        ->whereNotIn('id', $this->getOwnerRecord()->jobVacancyTestItems()->pluck('test_id'))
                        ->pluck('title', 'id')
                )
                // ->hidden(EditAction::class)
                ->searchable()
                ->required(),
            TextInput::make('number_of_question')
                ->label('Jumlah Soal')
                ->required()
                ->numeric(),
            TextInput::make('minimum_score')
                ->label('Skor Minimal')
                ->required()
                ->numeric(),
            TextInput::make('duration_in_minutes')
                ->label('Durasi (menit)')
                ->required()
                ->numeric(),
            TextInput::make('order')
                ->label('Urutan')
                ->required()
                ->numeric()
                ->columnSpanFull(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Daftar soal untuk tes ini')
            ->columns([
                TextColumn::make('test.title')
                    ->label('Soal')
                    ->searchable(),
                TextColumn::make('number_of_question')
                    ->label('Jumlah Soal')
                    ->sortable(),
                TextColumn::make('minimum_score')
                    ->label('Skor Minimal')
                    ->sortable(),
                TextColumn::make('duration_in_minutes')
                    ->label('Durasi (menit)')
                    ->sortable(),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),

                DeleteAction::make()
            ])
            ->headerActions([
                Action::make('createTestItem')
                    ->icon(LucideIcon::Plus)
                    ->label('Tambah Soal')
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->jobVacancyTestItems()->create($data);
                    }),
            ]);
    }
}
