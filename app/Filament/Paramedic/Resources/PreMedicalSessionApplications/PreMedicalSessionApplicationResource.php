<?php

namespace App\Filament\Paramedic\Resources\PreMedicalSessionApplications;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Models\PreMedical\PreMedicalSessionApplication;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Widgets\SelectPreMedicalWidget;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages\EditPreMedicalSessionApplication;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages\ViewPreMedicalSessionApplication;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages\ListPreMedicalSessionApplications;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Pages\CreatePreMedicalSessionApplication;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Schemas\PreMedicalSessionApplicationForm;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Tables\PreMedicalSessionApplicationsTable;
use App\Filament\Paramedic\Resources\PreMedicalSessionApplications\Schemas\PreMedicalSessionApplicationInfolist;

class PreMedicalSessionApplicationResource extends Resource
{
    protected static ?string $model = PreMedicalSessionApplication::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Hospital;
    // protected static string | UnitEnum | null $navigationGroup = 'Pre Medical Checkup';
    protected static ?string $navigationLabel = 'Pre Medical Checkup';
    protected static ?string $modelLabel = 'Pre Medical Checkup';
    protected static ?string $pluralModelLabel = 'Pre Medical Checkup';

    public static function form(Schema $schema): Schema
    {
        return PreMedicalSessionApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PreMedicalSessionApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreMedicalSessionApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            SelectPreMedicalWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreMedicalSessionApplications::route('/'),
            'create' => CreatePreMedicalSessionApplication::route('/create'),
            'view' => ViewPreMedicalSessionApplication::route('/{record}'),
            'edit' => EditPreMedicalSessionApplication::route('/{record}/edit'),
        ];
    }
}
