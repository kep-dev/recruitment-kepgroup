<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Tables;

use Livewire\Component;
use App\Models\JobVacancy;
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
use Filament\Tables\Filters\SelectFilter;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;

class JobVacancyTestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->latest())
            ->columns([
                TextColumn::make('jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Ujian Untuk')
                    ->searchable(),
                TextColumn::make('active_from')
                    ->label('Mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('active_until')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
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
                    FilamentExportBulkAction::make('export')
                ]),
            ]);
    }
}
