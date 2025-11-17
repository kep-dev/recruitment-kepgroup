<?php

namespace App\Filament\Resources\ErpIntegrations;

use App\Filament\Resources\ErpIntegrations\Pages\ManageErpIntegrations;
use App\Models\ErpIntegration;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ErpIntegrationResource extends Resource
{
    protected static ?string $model = ErpIntegration::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Workflow;

    protected static ?string $recordTitleAttribute = 'company_name';
    protected static ?string $navigationLabel = 'Integrasi';
    protected static ?string $modelLabel = 'Integrasi';
    protected static ?string $pluralModelLabel = 'Integrasi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_name')
                    ->label('Perusahaan')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('company_code')
                    ->label('Kode Perusahaan')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('base_url')
                    ->label('Base URL')
                    ->columnSpanFull()
                    ->url()
                    ->required(),
                Textarea::make('bearer_token_encrypted')
                    ->label('Akses Token')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('company_name')
                    ->label('Perusahaan')
                    ->columnSpanFull(),
                TextEntry::make('company_code')
                    ->label('Kode Perusahaan')
                    ->columnSpanFull(),
                TextEntry::make('base_url')
                    ->label('Base URL')
                    ->label('Base URL'),
                TextEntry::make('bearer_token_encrypted')
                    ->columnSpanFull()
                    ->copyable()
                    ->copyMessage('Token disalin')
                    ->copyMessageDuration(1500),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('company_name')
            ->columns([
                TextColumn::make('company_name')
                    ->label('Perusahaan')
                    ->searchable(),
                TextColumn::make('company_code')
                    ->label('Kode Perusahaan')
                    ->searchable(),
                TextColumn::make('base_url')
                    ->label('Base URL')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
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
            'index' => ManageErpIntegrations::route('/'),
        ];
    }
}
