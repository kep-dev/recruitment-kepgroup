<?php

namespace App\Filament\Resources\StageTypes;

use UnitEnum;
use BackedEnum;
use App\Models\StageType;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\StageTypes\Pages\ManageStageTypes;

class StageTypeResource extends Resource
{
    protected static ?string $model = StageType::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ArrowDown01;
    protected static string | UnitEnum | null $navigationGroup = 'Lowongan';
    protected static ?string $navigationLabel = 'Alur Lowongan';
    protected static ?string $modelLabel = 'Alur Lowongan';
    protected static ?string $pluralModelLabel = 'Alur Lowongan';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_terminal')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('code')
                            ->label('Kode'),
                        TextEntry::make('name')
                            ->label('Nama'),
                        IconEntry::make('is_terminal')
                            ->label('Tahap Terakhir')
                            ->boolean(),
                        TextEntry::make('description')
                            ->label('Keterangan'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->rowIndex()
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                IconColumn::make('is_terminal')
                    ->label('Tahap Terakhir')
                    ->boolean(),
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
            'index' => ManageStageTypes::route('/'),
        ];
    }
}
