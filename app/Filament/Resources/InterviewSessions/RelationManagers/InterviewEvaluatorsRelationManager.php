<?php

namespace App\Filament\Resources\InterviewSessions\RelationManagers;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\InterviewSessions\InterviewSessionResource;

class InterviewEvaluatorsRelationManager extends RelationManager
{
    protected static string $relationship = 'interviewEvaluators';
    protected static ?string $title = 'Pewawancara';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('user_id')
                ->label('Pewawancara')
                ->options(
                    // Get users who are not already assigned as evaluators in this interview session
                    User::query()
                        ->whereRelation('roles', 'name', '!=', 'applicant')
                        ->whereNotIn('id', $this->getOwnerRecord()->interviewEvaluators()->pluck('user_id'))
                        ->pluck('name', 'id')
                )
                ->multiple()
                ->searchable()
                ->required()
                ->hiddenOn('edit'),
            TextInput::make('role')->label('Role')
                ->placeholder('Penilai 1, Penilai 2, Observer')
                ->required(),

        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama')->searchable(),
                TextColumn::make('user.email')->label('Email')->searchable(),
                TextColumn::make('role')->label('Role')->searchable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pewawancara')
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        foreach ($data['user_id'] as $userId) {
                            $this->getOwnerRecord()->interviewEvaluators()->create([
                                'user_id' => $userId,
                                'role' => $data['role'],
                            ]);
                        }
                    })
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $record->update($data);
                    }),

                DeleteAction::make()
            ]);
    }
}
