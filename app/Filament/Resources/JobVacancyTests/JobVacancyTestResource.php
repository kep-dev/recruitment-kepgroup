<?php

namespace App\Filament\Resources\JobVacancyTests;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\JobVacancyTest;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\JobVacancyTests\Pages\EditJobVacancyTest;
use App\Filament\Resources\JobVacancyTests\Pages\ViewJobVacancyTest;
use App\Filament\Resources\JobVacancyTests\Pages\ListJobVacancyTests;
use App\Filament\Resources\JobVacancyTests\Pages\CreateJobVacancyTest;
use App\Filament\Resources\JobVacancyTests\Schemas\JobVacancyTestForm;
use App\Filament\Resources\JobVacancyTests\Tables\JobVacancyTestsTable;
use App\Filament\Resources\JobVacancyTests\Schemas\JobVacancyTestInfolist;
use App\Filament\Resources\JobVacancyTests\RelationManagers\ApplicantTestsRelationManager;
use App\Filament\Resources\JobVacancyTests\RelationManagers\JobVacancyTestItemsRelationManager;

class JobVacancyTestResource extends Resource
{
    protected static ?string $model = JobVacancyTest::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookOpen;
    protected static string | UnitEnum | null $navigationGroup = 'Test';
    protected static ?string $navigationLabel = 'Test Rekrutment';
    protected static ?string $modelLabel = 'Test Rekrutment';
    protected static ?string $pluralModelLabel = 'Test Rekrutment';

    public static function form(Schema $schema): Schema
    {
        return JobVacancyTestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobVacancyTestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobVacancyTestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            JobVacancyTestItemsRelationManager::class,
            ApplicantTestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobVacancyTests::route('/'),
            'create' => CreateJobVacancyTest::route('/create'),
            'view' => ViewJobVacancyTest::route('/{record}'),
            'edit' => EditJobVacancyTest::route('/{record}/edit'),
        ];
    }
}
