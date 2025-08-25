<?php

namespace App\Filament\Resources\JobVacancies\RelationManagers;

use App\Models\StageType;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\JobVacancies\JobVacancyResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class JobVacancyStagesRelationManager extends RelationManager
{
    protected static string $relationship = 'jobVacancyStages';

    // protected static ?string $relatedResource = JobVacancyResource::class;

    protected function getFormSchema(): array
    {
        return [
            Select::make('stage_type_id')
                ->label('Tahap')
                ->options(fn() => StageType::query()->pluck('name', 'id')->toArray())
                ->searchable()
                ->preload()
                ->required()
                // pastikan 1 stage_type hanya sekali per job_vacancy
                ->rule(function (RelationManager $livewire) {
                    return Rule::unique('job_vacancy_stages', 'stage_type_id')
                        ->where('job_vacancy_id', $livewire->getOwnerRecord()->getKey())
                        ->ignore($this->record); // saat edit
                }),

            TextInput::make('order')
                ->label('Urutan')
                ->numeric()
                ->minValue(1)
                ->default(function (RelationManager $livewire) {
                    return (int) ($livewire->getOwnerRecord()
                        ->jobVacancyStages()
                        ->max('order') ?? 0) + 1;
                })
                ->required()
                // unique "order" per job_vacancy
                ->rule(function (RelationManager $livewire) {
                    return Rule::unique('job_vacancy_stages', 'order')
                        ->where('job_vacancy_id', $livewire->getOwnerRecord()->getKey())
                        ->ignore($this->record);
                }),

            Toggle::make('is_required')
                ->label('Wajib')
                ->default(true),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Tahap Lamaran')
            ->columns([
                TextColumn::make('stageType.name')
                    ->label('Tahap'),
                TextColumn::make('order')
                    ->label('Urutan'),
                IconColumn::make('is_required')
                    ->label('Dibutuhkan')
                    ->boolean()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        default => 'gray',
                    })
            ])
            ->headerActions([
                Action::make('createStage')
                    ->label('Tambah Tahap')
                    ->icon(LucideIcon::ArrowDown01)
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->jobVacancyStages()->create([
                            'stage_type_id' => $data['stage_type_id'],
                            'order' => $data['order'],
                            'is_required' => $data['is_required'],
                        ]);
                    })
            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->jobVacancyStages()->update([
                            'stage_type_id' => $data['stage_type_id'],
                            'order' => $data['order'],
                            'is_required' => $data['is_required'],
                        ]);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
