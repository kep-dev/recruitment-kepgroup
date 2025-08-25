<?php

namespace App\Filament\Resources\Tests;

use BackedEnum;
use App\Models\Test;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Tests\Pages\EditTest;
use App\Filament\Resources\Tests\Pages\ViewTest;
use App\Filament\Resources\Tests\Pages\ListTests;
use App\Filament\Resources\Tests\Pages\CreateTest;
use App\Filament\Resources\Tests\Schemas\TestForm;
use App\Filament\Resources\Tests\Tables\TestsTable;
use App\Filament\Resources\Tests\Schemas\TestInfolist;
use App\Filament\Resources\Tests\RelationManagers\QuestionsRelationManager;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use UnitEnum;

class TestResource extends Resource
{
    protected static ?string $model = Test::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ClipboardList;
    protected static string | UnitEnum | null $navigationGroup = 'Test';
    protected static ?string $navigationLabel = 'Test';
    protected static ?string $modelLabel = 'Test';
    protected static ?string $pluralModelLabel = 'Test';

    public static function form(Schema $schema): Schema
    {
        return TestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTests::route('/'),
            'create' => CreateTest::route('/create'),
            'view' => ViewTest::route('/{record}'),
            'edit' => EditTest::route('/{record}/edit'),
        ];
    }
}
