<?php

namespace App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\Pages;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use App\Models\Psychotest\PsychotestAspect;
use App\Models\Psychotest\PsychotestQuestion;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Models\Psychotest\PsychotestCharacteristic;
use App\Models\Psychotest\PsychotestQuestionOption;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Clusters\PsychoTests\Resources\PsychotestForms\PsychotestFormResource;

class PsychotestCharacteristicMapping extends Page implements HasActions, HasSchemas, HasTable
{

    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = PsychotestFormResource::class;

    protected string $view = 'filament.clusters.psycho-tests.resources.psychotest-forms.pages.psychotest-characteristic-mapping';
    protected static ?string $slug = '/{record?}/psychotest-characteristic-mapping';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Mapping Karakteristik';

    public ?PsychotestQuestion $record = null;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->url(route('filament.admin.psycho-tests.resources.psychotest-forms.view', ['record' => $this->record->psychotest_form_id])),
        ];
    }

    public function mount(): void
    {
        // dd($this->record);
    }

    public function getFormSchema(): array
    {
        return [
            Repeater::make('mappings')
                ->relationship('mappings')
                ->hiddenLabel()
                ->table([
                    TableColumn::make('Aspek'),
                    TableColumn::make('Karakteristik'),
                    TableColumn::make('Bobot'),
                ])
                ->compact()
                ->schema([

                    Select::make('characteristic_id')
                        ->label('Karakteristik')
                        ->options(
                            PsychotestCharacteristic::query()
                                ->get(['id', 'name', 'code'])
                                ->mapWithKeys(
                                    fn($char) => [
                                        $char['id'] => '(' . $char['code'] . ')' . ' ' . $char['name']
                                    ]
                                )
                                ->toArray()
                        )
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
                            if ($state) {
                                $char = PsychotestCharacteristic::with('psychotestAspect')->find($state);
                                $set('aspect_id', $char?->psychotest_aspect_id);
                            } else {
                                $set('aspect_id', null);
                            }
                        }),

                    Select::make('aspect_id')
                        ->label('Aspek')
                        ->options(
                            PsychotestAspect::query()
                                ->pluck('name', 'id')
                                ->toArray()
                        ), // hanya sebagai informasi, tidak bisa diubah manual

                    TextInput::make('weight')
                        ->label('Bobot')
                        ->integer(),
                ])

        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PsychotestQuestionOption::query()
                    ->when(
                        filled($this->record),
                        fn($q) => $q->where('psychotest_question_id', $this->record->id),
                        fn($q) => $q->whereKey([]) // kosong
                    )
            )
            ->columns([
                TextColumn::make('label'),
                TextColumn::make('statement'),
                TextColumn::make('order'),
            ])
            ->recordActions([
                Action::make('addMapping')
                    ->icon(LucideIcon::SquareChartGantt)
                    ->fillForm(fn(PsychotestQuestionOption $record): array => [
                        'mappings' => $record->mappings,
                    ])
                    ->modalHeading('Mapping')
                    ->label('Mapping')
                    ->schema($this->getFormSchema()),
            ])
            ->emptyStateHeading('Belum ada data');
    }
}
