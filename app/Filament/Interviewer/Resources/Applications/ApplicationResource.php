<?php

namespace App\Filament\Interviewer\Resources\Applications;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Interviewer\Resources\Applications\Pages\EditApplication;
use App\Filament\Interviewer\Resources\Applications\Pages\ViewApplication;
use App\Filament\Interviewer\Resources\Applications\Pages\ListApplications;
use App\Filament\Interviewer\Resources\Applications\Pages\CreateApplication;
use App\Filament\Interviewer\Resources\Applications\Schemas\ApplicationForm;
use App\Filament\Interviewer\Resources\Applications\Tables\ApplicationsTable;
use App\Filament\Interviewer\Resources\Applications\Schemas\ApplicationInfolist;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::CircleUser;
    protected static ?string $navigationLabel = 'Pelamar';
    protected static ?string $modelLabel = 'Pelamar';
    protected static ?string $pluralModelLabel = 'Pelamar';

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
            //
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
