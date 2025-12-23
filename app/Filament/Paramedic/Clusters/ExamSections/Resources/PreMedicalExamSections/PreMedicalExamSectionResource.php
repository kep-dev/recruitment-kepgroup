<?php

namespace App\Filament\Paramedic\Clusters\ExamSections\Resources\PreMedicalExamSections;

use BackedEnum;
use Filament\Tables\Table;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use App\Models\PreMedical\PreMedicalExamSection;
use Filament\Forms\Components\Repeater\TableColumn;
use App\Filament\Paramedic\Clusters\ExamSections\ExamSectionsCluster;
use App\Filament\Paramedic\Clusters\ExamSections\Resources\PreMedicalExamSections\Pages\ManagePreMedicalExamSections;

class PreMedicalExamSectionResource extends Resource
{
    protected static ?string $model = PreMedicalExamSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = ExamSectionsCluster::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Name')
                        ->description('Give the category a unique name')
                        ->schema([
                            TextInput::make('code')
                                ->label('Kode')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('name')
                                ->label('Nama')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('order')
                                ->label('Urutan')
                                ->required()
                                ->numeric(),
                            Select::make('type')
                                ->label('Tipe')
                                ->options([
                                    'physic' => 'Pemeriksaan Fisik',
                                    'ent' => 'Pemeriksaan Telinga, Hidung, Tenggorokan',
                                    'tooth' => 'Pemeriksaan Gigi',
                                    'eye' => 'Pemeriksaan Mata',
                                    'gyanaecolonical' => 'Pemeriksaan Ginekologi',
                                ])
                                ->required(),

                        ])
                        ->columns(2),
                    Step::make('Description')
                        ->description('Add some extra details')
                        ->schema([
                            Repeater::make('subSections')
                                ->relationship('subSections')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Nama Sub Bagian')
                                        ->placeholder('Jantung, Paru, hati, Limpa, dll')
                                        ->required(),
                                    TextInput::make('code')
                                        ->label('Kode Sub Bagian')
                                        ->required(),
                                    TextInput::make('order')
                                        ->label('Urutan Sub Bagian')
                                        ->required()->numeric(),

                                    Repeater::make('items')
                                        ->relationship('items')
                                        ->table([
                                            TableColumn::make('Nama'),
                                            TableColumn::make('Kode'),
                                            TableColumn::make('Urutan'),
                                            TableColumn::make('Tipe Nilai'),
                                        ])
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('Nama Sub Bagian')
                                                ->placeholder('Jantung, Paru, hati, Limpa, dll')
                                                ->required(),
                                            TextInput::make('code')
                                                ->label('Kode Sub Bagian')
                                                ->required(),
                                            TextInput::make('order')
                                                ->label('Urutan Sub Bagian')
                                                ->required()->numeric(),
                                            Select::make('value_type')
                                                ->label('Tipe Nilai')
                                                ->options([
                                                    'yes_no' => 'Ya / Tidak',
                                                    'normal_abnormal' => 'Normal / Abnormal',
                                                ])
                                                ->required(),
                                        ])

                                ]),

                        ]),
                ])
                    ->columnSpanFull()

            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code')
                    ->label('Kode'),
                TextEntry::make('name')
                    ->label('Nama'),
                TextEntry::make('order')
                    ->label('Urutan'),
                TextEntry::make('type')
                    ->label('Tipe'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'physic' => 'Pemeriksaan Fisik',
                        'ent' => 'Pemeriksaan Telinga, Hidung, Tenggorokan',
                        'tooth' => 'Pemeriksaan Gigi',
                        'eye' => 'Pemeriksaan Mata',
                        'gyanaecolonical' => 'Pemeriksaan Ginekologi',
                    })
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => ManagePreMedicalExamSections::route('/'),
        ];
    }
}
