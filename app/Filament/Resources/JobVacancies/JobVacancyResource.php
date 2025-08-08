<?php

namespace App\Filament\Resources\JobVacancies;

use App\Filament\Resources\JobVacancies\Pages\CreateJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\EditJobVacancy;
use App\Filament\Resources\JobVacancies\Pages\ListJobVacancies;
use App\Filament\Resources\JobVacancies\Pages\ViewJobVacancy;
use App\Filament\Resources\JobVacancies\Schemas\JobVacancyForm;
use App\Filament\Resources\JobVacancies\Schemas\JobVacancyInfolist;
use App\Filament\Resources\JobVacancies\Tables\JobVacanciesTable;
use App\Models\JobVacancy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JobVacancyResource extends Resource
{
    protected static ?string $model = JobVacancy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;
    protected static string | UnitEnum | null $navigationGroup = 'Lowongan';
    protected static ?string $navigationLabel = 'Lowongan';
    protected static ?string $modelLabel = 'Lowongan';
    protected static ?string $pluralModelLabel = 'Lowongan';

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
            //
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
