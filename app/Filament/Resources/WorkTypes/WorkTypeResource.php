<?php

namespace App\Filament\Resources\WorkTypes;

use BackedEnum;
use App\Models\WorkType;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\WorkTypes\Pages\ManageWorkTypes;
use UnitEnum;

class WorkTypeResource extends Resource
{
    protected static ?string $model = WorkType::class;
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Lowongan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowRight;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Jenis Pekerjaan';
    protected static ?string $modelLabel = 'Jenis Pekerjaan';
    protected static ?string $pluralModelLabel = 'Jenis Pekerjaan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Jenis Pekerjaan')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('icon')
                    ->label('Icon')
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Jenis Pekerjaan'),
                TextEntry::make('description')
                    ->label('Deskripsi'),
                ImageEntry::make('icon'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->hidden(),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Jenis Pekerjaan')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Jenis Pekerjaan')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
                ImageColumn::make('icon'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
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
            'index' => ManageWorkTypes::route('/'),
        ];
    }
}
