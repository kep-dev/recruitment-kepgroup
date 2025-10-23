<?php

namespace App\Filament\Resources\PreMedicalSessions;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Models\PreMedical\PreMedicalSession;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\PreMedicalSessions\Pages\EditPreMedicalSession;
use App\Filament\Resources\PreMedicalSessions\Pages\ViewPreMedicalSession;
use App\Filament\Resources\PreMedicalSessions\Pages\ListPreMedicalSessions;
use App\Filament\Resources\PreMedicalSessions\Pages\CreatePreMedicalSession;
use App\Filament\Resources\PreMedicalSessions\Schemas\PreMedicalSessionForm;
use App\Filament\Resources\PreMedicalSessions\Tables\PreMedicalSessionsTable;
use App\Filament\Resources\PreMedicalSessions\Schemas\PreMedicalSessionInfolist;
use App\Filament\Resources\PreMedicalSessions\RelationManagers\PreMedicalSessionApplicationsRelationManager;

class PreMedicalSessionResource extends Resource
{
    protected static ?string $model = PreMedicalSession::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Hospital;
    protected static string | UnitEnum | null $navigationGroup = 'Pre Medical Checkup';
    protected static ?string $navigationLabel = 'Pre Medical Checkup';
    protected static ?string $modelLabel = 'Pre Medical Checkup';
    protected static ?string $pluralModelLabel = 'Pre Medical Checkup';

    public static function form(Schema $schema): Schema
    {
        return PreMedicalSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PreMedicalSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreMedicalSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PreMedicalSessionApplicationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreMedicalSessions::route('/'),
            'create' => CreatePreMedicalSession::route('/create'),
            'view' => ViewPreMedicalSession::route('/{record}'),
            'edit' => EditPreMedicalSession::route('/{record}/edit'),
        ];
    }
}
