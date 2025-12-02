<?php

namespace App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\ApplicantTest;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Clusters\JobVacancyTests\JobVacancyTestsCluster;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages\EditApplicantTest;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages\ViewApplicantTest;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages\ListApplicantTests;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Pages\CreateApplicantTest;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Schemas\ApplicantTestForm;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Tables\ApplicantTestsTable;
use App\Filament\Clusters\JobVacancyTests\Resources\ApplicantTests\Schemas\ApplicantTestInfolist;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class ApplicantTestResource extends Resource
{
    protected static ?string $model = ApplicantTest::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Users;

    protected static ?string $cluster = JobVacancyTestsCluster::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Kandidat yang sudah melalui tes';

    protected static ?string $modelLabel = 'Kandidat yang sudah melalui tes';

    protected static ?string $pluralModelLabel = 'Kandidat yang sudah melalui tes';

    public static function form(Schema $schema): Schema
    {
        return ApplicantTestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicantTestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicantTestsTable::configure($table);
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
            'index' => ListApplicantTests::route('/'),
            'create' => CreateApplicantTest::route('/create'),
            'view' => ViewApplicantTest::route('/{record}'),
            'edit' => EditApplicantTest::route('/{record}/edit'),
        ];
    }
}
