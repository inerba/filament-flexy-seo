<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Actions\GeneratePasswordAction;
use App\Filament\Resources\Users\Pages\CreateUser;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof CreateUser)
                    ->revealable(filament()->arePasswordsRevealable())
                    ->rule(Password::default())
                    ->autocomplete('new-password')
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                    ->live(debounce: 500)
                    ->same('passwordConfirmation')
                    ->suffixActions([
                        GeneratePasswordAction::make(),
                    ]),
                TextInput::make('passwordConfirmation')
                    ->label(__('Password Confirmation'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->visible(fn (Get $get): bool => filled($get('password')))
                    ->dehydrated(false),

                // Select::make('roles')
                //     ->label('Ruolo')
                //     ->relationship(name: 'roles', titleAttribute: 'name', modifyQueryUsing: function (Builder $query) {
                //         // Solo gli utenti super_admin possono creare utenti con ruolo super_admin
                //         if (Auth::user()->hasRole('super_admin')) {
                //             return $query->whereNotIn('name', ['filament_user']);
                //         } else {
                //             return $query->whereNotIn('name', ['filament_user', 'super_admin']);
                //         }
                //     })
                //     ->multiple()
                //     ->preload()
                //     ->native(false),

                Select::make('roles')
                    ->label('Ruolo')
                    ->relationship(name: 'roles', titleAttribute: 'name', modifyQueryUsing: function (Builder $query) {
                        // Solo gli utenti super_admin possono creare utenti con ruolo super_admin
                        if (Auth::user()->hasRole('super_admin')) {
                            return $query->whereNotIn('name', ['filament_user']);
                        } else {
                            return $query->whereNotIn('name', ['filament_user', 'super_admin']);
                        }
                    })
                    ->multiple()
                    ->preload()
                    ->native(false),
            ]);
    }
}
