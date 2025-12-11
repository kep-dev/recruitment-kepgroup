<?php

namespace App\Filament\Clusters\InterviewSessions\Resources\InterviewSessionApplications;

use BackedEnum;
use App\Enums\status;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use App\Models\InterviewSessionApplication;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Clusters\InterviewSessions\InterviewSessionsCluster;
use App\Filament\Clusters\InterviewSessions\Resources\InterviewSessionApplications\Pages\ManageInterviewSessionApplications;

class InterviewSessionApplicationResource extends Resource
{
    protected static ?string $model = InterviewSessionApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = InterviewSessionsCluster::class;

    protected static ?string $navigationLabel = 'Kandidat yang sudah melalui interview';
    protected static ?string $modelLabel = 'Kandidat yang sudah melalui interview';
    protected static ?string $pluralModelLabel = 'Kandidat yang sudah melalui interview';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('interview_session_id')
                    ->required(),
                TextInput::make('application_id')
                    ->required(),
                Select::make('mode')
                    ->options(['onsite' => 'Onsite', 'online' => 'Online', 'hybrid' => 'Hybrid']),
                TextInput::make('location'),
                TextInput::make('meeting_link'),
                Select::make('status')
                    ->options(status::class)
                    ->default('scheduled')
                    ->required(),
                TextInput::make('avg_score')
                    ->numeric(),
                Select::make('recommendation')
                    ->options(['hire' => 'Hire', 'hold' => 'Hold', 'no_hire' => 'No hire']),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('interview_session_id'),
                TextEntry::make('application_id'),
                TextEntry::make('mode')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('location')
                    ->placeholder('-'),
                TextEntry::make('meeting_link')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('avg_score')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('recommendation')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('id')
                //     ->label('ID')
                //     ->searchable(),
                TextColumn::make('interviewSession.title')
                    ->label('Sesi Interview')
                    ->searchable(),
                TextColumn::make('application.user.name')
                    ->label('Pelamar')
                    ->searchable(),
                TextColumn::make('application.jobVacancy.title')
                    ->label('Melamar Pada Posisi')
                    ->searchable(),
                TextColumn::make('mode')
                    ->label('Mode')
                    ->badge(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Dijadwalkan',
                        'in_progress' => 'Dalam Proses',
                        'completed' => 'Selesai',
                        'no_show' => 'Tidak Hadir',
                        'canceled' => 'Dibatalkan',
                    ])
                    ->disabled(function ($record) {
                        if ($record->status->value === 'completed' && !Auth::user()->hasRole('super_admin')) {
                            return true;
                        }
                    }),

                TextColumn::make('avg_score')
                    ->label('Skor Rata-rata')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('recommendation')
                    ->badge(),
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
                //
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageInterviewSessionApplications::route('/'),
        ];
    }
}
