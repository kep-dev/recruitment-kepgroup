<?php

namespace App\Filament\Resources\EmployeeTypes;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\EmployeeType;
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
use App\Filament\Resources\EmployeeTypes\Pages\ManageEmployeeTypes;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class EmployeeTypeResource extends Resource
{
    protected static ?string $model = EmployeeType::class;

    protected static string | UnitEnum | null $navigationGroup = 'Lowongan';
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Users;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Jenis Karyawan';
    protected static ?string $modelLabel = 'Jenis Karyawan';
    protected static ?string $pluralModelLabel = 'Jenis Karyawan';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->label('Jenis Karyawan')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('icon')
                    ->columnSpanFull()
                    ->label('Icon')
                    ->image()
                    ->disk('public')
                    ->directory('employee-types')
                    ->preserveFilenames()
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Jenis Karyawan'),
                TextEntry::make('description')
                    ->label('Deskripsi'),
                ImageEntry::make('icon')
                    ->disk('public'),
                TextEntry::make('created_at')
                    ->hidden()
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->hidden()
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Jenis Karyawan')
            ->columns([
                TextColumn::make('name')
                    ->label('Jenis Karyawan')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
                ImageColumn::make('icon')
                ->disk('public'),
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
            'index' => ManageEmployeeTypes::route('/'),
        ];
    }
}
