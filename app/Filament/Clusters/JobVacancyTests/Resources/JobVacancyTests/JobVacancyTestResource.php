<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\JobVacancyTest;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Clusters\JobVacancyTests\JobVacancyTestsCluster;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages\EditJobVacancyTest;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages\ViewJobVacancyTest;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages\ListJobVacancyTests;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Pages\CreateJobVacancyTest;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Schemas\JobVacancyTestForm;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Tables\JobVacancyTestsTable;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\Schemas\JobVacancyTestInfolist;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\RelationManagers\ApplicantTestsRelationManager;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\RelationManagers\PsychotestFormsRelationManager;
use App\Filament\Clusters\JobVacancyTests\Resources\JobVacancyTests\RelationManagers\JobVacancyTestItemsRelationManager;


class JobVacancyTestResource extends Resource
{
    protected static ?string $model = JobVacancyTest::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookOpenCheck;
    protected static ?string $cluster = JobVacancyTestsCluster::class;
    protected static ?int $navigationSort = 1;

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
            'jobVacancyTestItems' => JobVacancyTestItemsRelationManager::class,
            'applicantTests' => ApplicantTestsRelationManager::class,
            'psychotestForms' => PsychotestFormsRelationManager::class,
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
