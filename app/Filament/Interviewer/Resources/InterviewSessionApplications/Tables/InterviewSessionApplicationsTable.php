<?php

namespace App\Filament\Interviewer\Resources\InterviewSessionApplications\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Interviewer\Resources\InterviewSessionApplications\Pages\GiveAnAssessmentPage;

class InterviewSessionApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn(Builder $query) => $query
                    ->whereHas('interviewSession.interviewEvaluators', function (Builder $query) {
                        $query->where('user_id', auth()->id());
                    })
            )
            ->columns([
                TextColumn::make('application.user.name')
                    ->label('Pelamar')
                    ->searchable(),
                TextColumn::make('application.jobVacancy.title')
                    ->label('Lowongan')
                    ->searchable(),
                TextColumn::make('interviewSession.title')
                    ->label('Sesi Interview')
                    ->searchable(),
                TextColumn::make('mode'),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('meeting_link')
                    ->searchable(),
                TextColumn::make('status'),
                TextColumn::make('total_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('recommendation'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('application.job_vacancy_id')
                    ->label('Lowongan')
                    ->relationship('application.jobVacancy', 'title')
                    ->searchable(),
            ])
            ->recordActions([
                Action::make('GiveAnAssessment')
                    ->color('primary')
                    ->icon(LucideIcon::ClipboardPenLine)
                    ->label('Berikan Penilaian')
                    ->url(fn($record) => GiveAnAssessmentPage::getUrl(['record' => $record->getKey()])),
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
