<?php

namespace  App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\RelationManagers;

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
use Illuminate\Database\Eloquent\Model;

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
                ->searchable()
                ->required()
                ->options(function ($livewire, ?Model $record) {
                    $owner = $livewire->getOwnerRecord(); // parent (mis. JobVacancy)
                    $excluded = $owner->jobVacancyTestItems()->pluck('test_id')->all();

                    // Jika edit, pastikan nilai sekarang TIDAK di-exclude
                    if ($record && $record->test_id) {
                        $excluded = array_diff($excluded, [$record->test_id]);
                    }

                    return Test::query()
                        ->whereNotIn('id', $excluded)
                        ->orderBy('title')
                        ->pluck('title', 'id')
                        ->all();
                })
                // Guard tambahan: pastikan label tampil meski opsi belum ter‐load penuh
                ->getOptionLabelUsing(fn($value) => Test::find($value)?->title),
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
            TextInput::make('multiplier')
                ->label('Perkalian Nilai')
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
                TextColumn::make('multiplier')
                    ->label('Perkalian Nilai')
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
