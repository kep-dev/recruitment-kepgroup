<?php

namespace App\Filament\Resources\JobLevels;

use UnitEnum;
use BackedEnum;
use App\Models\JobLevel;
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
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\JobLevels\Pages\ManageJobLevels;
use Filament\Tables\Columns\ImageColumn;

class JobLevelResource extends Resource
{
    protected static ?string $model = JobLevel::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ChevronsUpDown;
    // protected static ?string $navigationParentItem = 'Lowongan';
    protected static string | UnitEnum | null $navigationGroup = 'Lowongan';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Level Jabatan';
    protected static ?string $modelLabel = 'Level Jabatan';
    protected static ?string $pluralModelLabel = 'Level Jabatan';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Level Jabatan')
                    ->placeholder('Cont. Supervisor, Staff, Manager, dll')
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('icon')
                    ->columnSpanFull()
                    ->label('Icon')
                    ->image()
                    ->disk('public')
                    ->directory('job-levels')
                    ->preserveFilenames()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Level Jabatan'),
                ImageEntry::make('icon')
                    ->disk('public'),
                TextEntry::make('description')
                    ->label('Deskripsi'),
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
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Level Jabatan')
                    ->searchable(),
                ImageColumn::make('icon')
                    ->disk('public'),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),
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
            'index' => ManageJobLevels::route('/'),
        ];
    }
}
