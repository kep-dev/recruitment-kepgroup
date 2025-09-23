<?php

namespace App\Filament\Resources\InterviewSessions;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\InterviewSession;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\InterviewSessions\Pages\EditInterviewSession;
use App\Filament\Resources\InterviewSessions\Pages\ViewInterviewSession;
use App\Filament\Resources\InterviewSessions\Pages\ListInterviewSessions;
use App\Filament\Resources\InterviewSessions\Pages\CreateInterviewSession;
use App\Filament\Resources\InterviewSessions\Pages\DetailInterviewPage;
use App\Filament\Resources\InterviewSessions\Schemas\InterviewSessionForm;
use App\Filament\Resources\InterviewSessions\Tables\InterviewSessionsTable;
use App\Filament\Resources\InterviewSessions\Schemas\InterviewSessionInfolist;
use App\Filament\Resources\InterviewSessions\RelationManagers\InterviewEvaluatorsRelationManager;
use App\Filament\Resources\InterviewSessions\RelationManagers\InterviewApplicationsRelationManager;

class InterviewSessionResource extends Resource
{
    protected static ?string $model = InterviewSession::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::MessagesSquare;
    protected static string | UnitEnum | null $navigationGroup = 'Test';
    protected static ?string $navigationLabel = 'Sesi Interview';
    protected static ?string $modelLabel = 'Sesi Interview';
    protected static ?string $pluralModelLabel = 'Sesi Interview';


    public static function form(Schema $schema): Schema
    {
        return InterviewSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InterviewSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterviewSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InterviewEvaluatorsRelationManager::class,
            InterviewApplicationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInterviewSessions::route('/'),
            'create' => CreateInterviewSession::route('/create'),
            'view' => ViewInterviewSession::route('/{record}'),
            'edit' => EditInterviewSession::route('/{record}/edit'),
            'detail-interview' => DetailInterviewPage::route('/{record}/detail-interview'),
        ];
    }
}
