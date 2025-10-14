<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Filament\Actions\GeneratePasswordAction;
use App\Filament\Resources\Customers\Pages\CreateCustomer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome e cognome')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                // DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof CreateCustomer)
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
                    ->visible(fn (callable $get): bool => filled($get('password')))
                    ->dehydrated(false),
            ]);
    }
}
