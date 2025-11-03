<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\Role;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Facades\Hash;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->rowIndex(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('two_factor_confirmed_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('roles')
                    ->state(fn($record) => $record->getRoleNames()->join(', ')),
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
                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name') // otomatis whereHas('roles', ...)
                    ->multiple()
                    ->preload()
                    ->searchable()
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('resetPassword')
                    ->label('Reset Password')
                    ->icon(LucideIcon::TimerReset)
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->label('Password Baru')
                            ->required(),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Konfirmasi Password Baru')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'password' => Hash::make($data['password']),
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
