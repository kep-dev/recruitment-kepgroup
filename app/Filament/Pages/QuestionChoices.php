<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Tests\TestResource;
use App\Models\Question;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\QuestionChoice;
use GuzzleHttp\Promise\Create;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\DeleteAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Tables\Columns\ToggleColumn;

class QuestionChoices extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected string $view = 'filament.pages.question-choices';
    protected static ?string $title;
    protected static ?string $slug = 'tests/{question_id?}/choices';
    protected static bool $shouldRegisterNavigation = false;

    public ?Question $question_id = null; // <-- nullable

    public function mount(): void
    {
        $question = $this->question_id;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('tambahJawaban')
                ->label('Tambah Jawaban')
                ->modalHeading('Tambah Jawaban')
                ->form([
                    TextInput::make('choice_label')
                        ->label('Pilihan Jawaban')
                        ->required(),
                    TextInput::make('choice_text')
                        ->label('Jawaban')
                        ->required(),
                    Toggle::make('is_correct')
                        ->label('Benar'),
                ])
                ->action(function (array $data) {
                    QuestionChoice::create([
                        // jika properti yang Anda punya adalah string UUID:
                        'question_id' => $this->question_id->id,   // <— perbaiki ini
                        'choice_label' => $data['choice_label'],
                        'choice_text'  => $data['choice_text'],
                        'is_correct'   => $data['is_correct'] ?? false,
                    ]);
                }),

            Action::make('back')
                ->label('Kembali')
                ->url(fn(): string => route(
                    'filament.admin.resources.tests.view',
                    ['record' => $this->question_id->test_id ?? $this->record->test_id ?? null] // sesuaikan
                )),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('choice_label')
                ->label('Pilihan Jawaban')
                ->required(),
            TextInput::make('choice_text')
                ->label('Jawaban')
                ->required(),
            TextInput::make('is_correct')
                ->label('Benar'),
        ]);
    }

    protected function getTableQuery(): Builder
    {
        // Aman dipakai setelah mount(), tapi tetap kasih guard
        return QuestionChoice::query()
            ->whereBelongsTo($this->question_id)
            ->orderBy('id', 'asc');
    }

    public function table(Table $table): Table
    {
        return $table
            // ->heading('Pertanyaan')
            // ->description($this->question_id->question_text)
            ->columns([
                TextColumn::make('id')->rowIndex()
                    ->label('No'),
                TextColumn::make('choice_label')
                    ->label('Pilihan Jawaban')
                    ->searchable(),
                TextColumn::make('choice_text')
                    ->label('Jawaban')->searchable(),
                ToggleColumn::make('is_correct')
                    ->label('Benar'),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        TextInput::make('choice_label')
                            ->label('Pilihan Jawaban')
                            ->required(),
                        TextInput::make('choice_text')
                            ->label('Jawaban')
                            ->required(),
                        Toggle::make('is_correct')
                            ->label('Benar'),
                    ])
                    ->action(function (array $data, $record) {
                        $record->update([
                            'choice_label' => $data['choice_label'],
                            'choice_text' => $data['choice_text'],
                            'is_correct' => $data['is_correct'],
                        ]);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
