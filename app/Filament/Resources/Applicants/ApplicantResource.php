<?php

namespace App\Filament\Resources\Applicants;

use UnitEnum;
use BackedEnum;
use App\Models\Applicant;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\Applicants\Pages\EditApplicant;
use App\Filament\Resources\Applicants\Pages\ViewApplicant;
use App\Filament\Resources\Applicants\Pages\ListApplicants;
use App\Filament\Resources\Applicants\Pages\CreateApplicant;
use App\Filament\Resources\Applicants\Schemas\ApplicantForm;
use App\Filament\Resources\Applicants\Tables\ApplicantsTable;
use App\Filament\Resources\Applicants\Schemas\ApplicantInfolist;
use App\Filament\Resources\Applicants\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\LanguagesRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\EducationsRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\AchievmentsRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\AchievementsRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\WorkExperiencesRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\TrainingCertificationsRelationManager;
use App\Filament\Resources\Applicants\RelationManagers\OrganizationalExperiencesRelationManager;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BadgeCheck;
    protected static string | UnitEnum | null $navigationGroup = 'Rekrutmen';
    protected static ?string $navigationLabel = 'Pelamar';
    protected static ?string $modelLabel = 'Pelamar';
    protected static ?string $pluralModelLabel = 'Pelamar';

    public static function form(Schema $schema): Schema
    {
        return ApplicantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EducationsRelationManager::class,
            WorkExperiencesRelationManager::class,
            OrganizationalExperiencesRelationManager::class,
            TrainingCertificationsRelationManager::class,
            AchievementsRelationManager::class,
            DocumentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplicants::route('/'),
            'create' => CreateApplicant::route('/create'),
            'view' => ViewApplicant::route('/{record}'),
            'edit' => EditApplicant::route('/{record}/edit'),
        ];
    }
}
