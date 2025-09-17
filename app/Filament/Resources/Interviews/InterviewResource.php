<?php

namespace App\Filament\Resources\Interviews;

use App\Filament\Resources\Interviews\Pages\CreateInterview;
use App\Filament\Resources\Interviews\Pages\EditInterview;
use App\Filament\Resources\Interviews\Pages\ListCriterias;
use App\Filament\Resources\Interviews\Pages\ListInterviews;
use App\Filament\Resources\Interviews\Pages\ViewInterview;
use App\Filament\Resources\Interviews\RelationManagers\CriteriasRelationManager;
use App\Filament\Resources\Interviews\Schemas\InterviewForm;
use App\Filament\Resources\Interviews\Schemas\InterviewInfolist;
use App\Filament\Resources\Interviews\Tables\InterviewsTable;
use App\Models\Interview;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InterviewResource extends Resource
{
    protected static ?string $model = Interview::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::MessageSquareMore;
    protected static string | UnitEnum | null $navigationGroup = 'Test';
    protected static ?string $navigationLabel = 'Form Interview';
    protected static ?string $modelLabel = 'Form Interview';
    protected static ?string $pluralModelLabel = 'Form Interview';

    public static function form(Schema $schema): Schema
    {
        return InterviewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InterviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CriteriasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInterviews::route('/'),
            'create' => CreateInterview::route('/create'),
            'view' => ViewInterview::route('/{record}'),
            'edit' => EditInterview::route('/{record}/edit'),
            'list-criterias' => ListCriterias::route('/{record}/criterias'),
        ];
    }
}
