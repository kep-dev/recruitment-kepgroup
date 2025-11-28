<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Models\Psychotest\PsychotestForm;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Clusters\PsychoTests\PsychoTestsCluster;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages\EditPsychotestForm;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages\ViewPsychotestForm;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages\ListPsychotestForms;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages\CreatePsychotestForm;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Schemas\PsychotestFormForm;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Tables\PsychotestFormsTable;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Schemas\PsychotestFormInfolist;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages\PsychotestCharacteristicMapping;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\RelationManagers\QuestionsRelationManager;

class PsychotestFormResource extends Resource
{
    protected static ?string $model = PsychotestForm::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::BookText;
    protected static ?string $navigationLabel = 'Form Psikotest';
    protected static ?string $modelLabel = 'Form Psikotest';
    protected static ?string $pluralModelLabel = 'Form Psikotest';

    protected static ?string $cluster = PsychoTestsCluster::class;

    public static function form(Schema $schema): Schema
    {
        return PsychotestFormForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PsychotestFormInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PsychotestFormsTable::configure($table);
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
            'index' => ListPsychotestForms::route('/'),
            'create' => CreatePsychotestForm::route('/create'),
            'view' => ViewPsychotestForm::route('/{record}'),
            'edit' => EditPsychotestForm::route('/{record}/edit'),
            'mapping' => PsychotestCharacteristicMapping::route('/{record?}/psychotest-characteristic-mapping'),
        ];
    }
}
