<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects;

use App\Filament\Clusters\PsychoTests\PsychoTestsCluster;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages\CreatePsychotestAspect;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages\EditPsychotestAspect;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages\ListPsychotestAspects;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Pages\ViewPsychotestAspect;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Schemas\PsychotestAspectForm;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Schemas\PsychotestAspectInfolist;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestAspects\Tables\PsychotestAspectsTable;
use App\Models\Psychotest\PsychotestAspect;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class PsychotestAspectResource extends Resource
{
    protected static ?string $model = PsychotestAspect::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Brain;
    protected static ?string $navigationLabel = 'Aspek Psikotest';
    protected static ?string $modelLabel = 'Aspek Psikotest';
    protected static ?string $pluralModelLabel = 'Aspek Psikotest';

    protected static ?string $cluster = PsychoTestsCluster::class;

    public static function form(Schema $schema): Schema
    {
        return PsychotestAspectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PsychotestAspectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PsychotestAspectsTable::configure($table);
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
            'index' => ListPsychotestAspects::route('/'),
            'create' => CreatePsychotestAspect::route('/create'),
            'view' => ViewPsychotestAspect::route('/{record}'),
            'edit' => EditPsychotestAspect::route('/{record}/edit'),
        ];
    }
}
