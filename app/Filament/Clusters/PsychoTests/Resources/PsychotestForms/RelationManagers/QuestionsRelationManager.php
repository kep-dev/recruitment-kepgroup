<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\PsychotestFormResource;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages\PsychotestCharacteristicMapping;


class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    // protected static ?string $relatedResource = PsychotestFormResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('number')
                ->label('Nomor Soal'),
            Toggle::make('is_active')
                ->label('Aktif'),

            Repeater::make('options')
                ->relationship('options')
                ->table([
                    TableColumn::make('label'),
                    TableColumn::make('statement'),
                    TableColumn::make('order'),
                ])
                ->compact()
                ->schema([
                    TextInput::make('label')
                        ->label('Jawaban'),
                    TextInput::make('statement')
                        ->label('Pertanyaan'),
                    TextInput::make('order')
                        ->label('Urutan Jawaban')
                        ->integer(),
                ])
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('Nomor Soal'),
                TextColumn::make('options.statement')
                    ->label('Pertanyaan')
                    ->listWithLineBreaks(),
                TextColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Pertanyaan Psikotest')
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        // dd($this->getOwnerRecord()->id);
                        $form = $this->getOwnerRecord();
                        // $formId = $record->id;
                        $question = $form->questions()->create([
                            'number' => $data['number'],
                            'is_active' => $data['is_active'],
                        ]);

                        foreach ($data['options'] as $option) {
                            $question->options()->create([
                                'label' => $option['label'],
                                'statement' => $option['statement'],
                                'order' => $option['order'],
                            ]);
                        }
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->url(fn($record) => PsychotestCharacteristicMapping::getUrl(['record' => $record])),
                ViewAction::make(),
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function ($record, array $data) {
                        $form = $record;

                        $question = $form->questions()->create([
                            'number' => $data['number'],
                            'is_active' => $data['is_active'],
                        ]);

                        foreach ($data['options'] as $option) {
                            $question->options()->create([
                                'label' => $option['label'],
                                'statement' => $option['statement'],
                                'order' => $option['order'],
                            ]);
                        }
                    }),
            ])
        ;
    }
}
