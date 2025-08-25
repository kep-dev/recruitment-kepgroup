<?php

namespace App\Filament\Resources\Tests\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use App\Filament\Pages\QuestionChoices;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\Tests\TestResource;
use App\Filament\Resources\Tests\Pages\QuestionChoice;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\RelationManagers\RelationManager;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';
    protected static ?string $title = 'Pertanyaan';

    // protected static ?string $relatedResource = TestResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('question_text')
                    ->label('Pertanyaan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('type')
                    ->label('Tipe')
                    ->required()
                    ->options([
                        'multiple_choice' => 'Pilihan Ganda',
                        'essay' => 'Essay',
                        'true_false' => 'Benar/Salah',
                        'fill_in_blank' => 'Isi Kosong',
                        'matching' => 'Penyesuaian',
                    ])
                    ->columnSpanFull(),
                TextInput::make('points')
                    ->label('Poin')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->columnSpanFull()
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->hidden(),
                TextEntry::make('question_text')
                    ->label('Pertanyaan')
                    ->columnSpanFull(),
                TextEntry::make('type')
                    ->label('Tipe'),
                TextEntry::make('points')
                    ->label('Poin'),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->rowIndex()
                    ->label('No')
                    ->searchable(),
                TextColumn::make('question_text')
                    ->label('Pertanyaan')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->searchable(),
                TextColumn::make('points')
                    ->label('Poin')
                    ->numeric()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('ViewChoices')
                    ->label('Lihat Jawaban')
                    ->icon(LucideIcon::Eye)
                    ->url(fn($record) => QuestionChoices::getUrl(['question_id' => $record->getKey()])),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pertanyaan')
                    ->icon(LucideIcon::Plus)
            ]);
    }
}
