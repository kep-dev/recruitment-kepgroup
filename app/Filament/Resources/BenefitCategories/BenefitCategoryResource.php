<?php

namespace App\Filament\Resources\BenefitCategories;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\BenefitCategory;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\BenefitCategories\Pages\ManageBenefitCategories;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use UnitEnum;


class BenefitCategoryResource extends Resource
{
    protected static ?string $model = BenefitCategory::class;
    protected static string | UnitEnum | null $navigationGroup = 'Lowongan';
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Handshake;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Kategori Manfaat';
    protected static ?string $modelLabel = 'Kategori Manfaat';
    protected static ?string $pluralModelLabel = 'Kategori Manfaat';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->placeholder('Cont. Kesehatan, Kesejahteraan, dll.')
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
                    ->size(TextSize::Large)
                    ->label('Nama Kategori'),
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
            ->recordTitleAttribute('Benefit Category')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable(),
                ImageColumn::make('icon'),
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
            'index' => ManageBenefitCategories::route('/'),
        ];
    }
}
