<?php

namespace App\Filament\Resources\JobVacancies;

use UnitEnum;
use BackedEnum;
use App\Models\JobVacancy;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\JobVacancies\Pages\EditJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\ViewJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\CreateJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\ListJobVacancies;
use App\Filament\Resources\JobVacancies\Schemas\JobVacancyForm;
use App\Filament\Resources\JobVacancies\Tables\JobVacanciesTable;
use App\Filament\Resources\JobVacancies\Schemas\JobVacancyInfolist;
use App\Filament\Resources\JobVacancies\RelationManagers\JobVacancyStagesRelationManager;

class JobVacancyResource extends Resource
{
    protected static ?string $model = JobVacancy::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Newspaper;
    protected static string | UnitEnum | null $navigationGroup = 'Lowongan';
    protected static ?string $navigationLabel = 'Lowongan';
    protected static ?string $modelLabel = 'Lowongan';
    protected static ?string $pluralModelLabel = 'Lowongan';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return JobVacancyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobVacancyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobVacanciesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            JobVacancyStagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobVacancies::route('/'),
            'create' => CreateJobVacancy::route('/create'),
            'view' => ViewJobVacancy::route('/{record}'),
            'edit' => EditJobVacancy::route('/{record}/edit'),
        ];
    }
}
