<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\InterviewSessionApplication;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages\GiveAnAssessmentPage;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages\EditInterviewSessionApplication;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages\ViewInterviewSessionApplication;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages\ListInterviewSessionApplications;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages\CreateInterviewSessionApplication;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Schemas\InterviewSessionApplicationForm;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Tables\InterviewSessionApplicationsTable;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Schemas\InterviewSessionApplicationInfolist;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class InterviewSessionApplicationResource extends Resource
{
    protected static ?string $model = InterviewSessionApplication::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::MessagesSquare;
    protected static ?string $navigationLabel = 'Penilaian Wawancara';
    protected static ?string $modelLabel = 'Penilaian Wawancara';
    protected static ?string $pluralModelLabel = 'Penilaian Wawancara';

    public static function form(Schema $schema): Schema
    {
        return InterviewSessionApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InterviewSessionApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterviewSessionApplicationsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('interviewSession.interviewEvaluators', function (Builder $query) {
                $query->where('user_id', Auth::user()->id);
            });
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
            'index' => ListInterviewSessionApplications::route('/'),
            'create' => CreateInterviewSessionApplication::route('/create'),
            'view' => ViewInterviewSessionApplication::route('/{record}'),
            'edit' => EditInterviewSessionApplication::route('/{record}/edit'),
            'give-assessment' => GiveAnAssessmentPage::route('/{record}/give-assessment'),
        ];
    }
}
