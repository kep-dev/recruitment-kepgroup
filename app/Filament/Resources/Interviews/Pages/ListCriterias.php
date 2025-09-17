<?php

namespace App\Filament\Resources\Interviews\Pages;

use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\InterviewScale;
use Filament\Actions\EditAction;
use App\Models\InterviewCriteria;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\Concerns\HasRecord;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use App\Filament\Resources\Interviews\InterviewResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class ListCriterias extends Page implements HasActions, HasSchemas, HasTable
{
    use HasRecord;
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = InterviewResource::class;

    protected string $view = 'filament.resources.interviews.pages.list-criterias';
    public $label;
    public $key;

    public function mount(int|string $record): void
    {
        $this->record = InterviewCriteria::find($record);
        $this->label = $this->record->label;
        $this->key = $this->record->getKey();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('label')
                ->label('Nilai')
                ->placeholder('Kurang, Cukup, Baik, Sangat Baik'),
            TextInput::make('value')
                ->label('Bobot')
                ->placeholder('0.1, 0.2, 0.3, 0.4'),
            TextInput::make('order')
                ->label('Urutan'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url(fn(): string => route(
                    'filament.admin.resources.interviews.view',
                    ['record' => $this->record->interview_id] // sesuaikan
                )),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Nilai Kriteria')
            ->description($this->label)
            ->query(
                InterviewScale::query()
                    ->where('interview_criteria_id', $this->key)
            )
            // ->description($this->question_id->question_text)
            ->columns([
                TextColumn::make('label')
                    ->label('Nilai'),
                TextColumn::make('value')
                    ->label('Bobot'),
                TextColumn::make('order')
                    ->label('Urutan'),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([
                EditAction::make()
                    ->schema($this->getFormSchema())
                    ->action(function (array $data, $record) {
                        $record->update([
                            'label' => $data['label'],
                            'value' => $data['value'],
                            'order' => $data['order'],
                        ]);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Daftar Nilai')
                    ->icon(LucideIcon::Plus)
                    ->schema($this->getFormSchema())
                    ->action(function (array $data) {
                        InterviewScale::create([
                            'interview_criteria_id' => $this->key,
                            'label' => $data['label'],
                            'value' => $data['value'],
                            'order' => $data['order'],
                        ]);
                    }),
            ]);
    }
}
