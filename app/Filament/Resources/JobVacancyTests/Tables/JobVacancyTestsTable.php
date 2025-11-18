<?php

namespace App\Filament\Resources\JobVacancyTests\Tables;

use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;

class JobVacancyTestsTable
{
    public static function configure(Table $table): Table
    {


        return $table
            ->columns([
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable()
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'all'),
                TextColumn::make('name')
                    ->label('Ujian Untuk')
                    ->searchable()
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'all'),
                TextColumn::make('active_from')
                    ->label('Mulai')
                    ->dateTime()
                    ->sortable()
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'all'),
                TextColumn::make('active_until')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable()
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'all'),
                ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'all'),

                TextColumn::make('application.user.name')
                    ->label('Nama kandidat')
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'active'),

                TextColumn::make('application.user.applicant.latestEducation.major')
                    ->label('Jurusan')
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'active'),

                TextColumn::make('jobVacancyTest.name')
                    ->label('Ujian Untuk')
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'active'),

                TextColumn::make('total_score')
                    ->label('Skor')
                    ->sortable()
                    ->visible(fn(Component $livewire) => $livewire->activeTab === 'active'),

            ])
            ->filters([])
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
