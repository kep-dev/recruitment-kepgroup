<?php

namespace App\Filament\Resources\Applications;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\Applications\Pages\EditApplication;
use App\Filament\Resources\Applications\Pages\ViewApplication;
use App\Filament\Resources\Applications\Pages\ListApplications;
use App\Filament\Resources\Applications\Pages\CreateApplication;
use App\Filament\Resources\Applications\Schemas\ApplicationForm;
use App\Filament\Resources\Applications\Tables\ApplicationsTable;
use App\Filament\Resources\Applications\Schemas\ApplicationInfolist;
use App\Filament\Resources\Applications\RelationManagers\StageProgressesRelationManager;
use App\Filament\Resources\Applications\RelationManagers\StatusHistoriesRelationManager;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Inbox;
    protected static string | UnitEnum | null $navigationGroup = 'Rekrutmen';
    protected static ?string $navigationLabel = 'Lamaran';
    protected static ?string $modelLabel = 'Lamaran';
    protected static ?string $pluralModelLabel = 'Lamaran';

    public static function form(Schema $schema): Schema
    {
        return ApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'stage_progresses' => StageProgressesRelationManager::class,
            'status_histories' => StatusHistoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplications::route('/'),
            'create' => CreateApplication::route('/create'),
            'view' => ViewApplication::route('/{record}'),
            'edit' => EditApplication::route('/{record}/edit'),
        ];
    }
}
