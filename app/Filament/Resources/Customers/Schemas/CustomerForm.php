<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Filament\Actions\GeneratePasswordAction;
use App\Filament\Resources\Customers\Pages\CreateCustomer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni di Accesso')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome e cognome')
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Telefono')
                            ->required(),
                        // DateTimePicker::make('email_verified_at'),
                        TextInput::make('password')
                            ->label(__('Password'))
                            ->hintIcon('phosphor-info')
                            ->hintColor('info')
                            ->hintIconTooltip('Non puoi vedere la password di un cliente, ma puoi reimpostarla se necessario.')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof CreateCustomer)
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation')
                            ->columnSpan(fn (callable $get): int => filled($get('password')) ? 1 : 2)
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
                    ]),

                Section::make('Indirizzo di Fatturazione')
                    ->columns(2)
                    ->schema([
                        TextInput::make('address.street')->label('Indirizzo')->columnSpanFull()->required(),
                        TextInput::make('address.city')->label('Città')->required(),
                        TextInput::make('address.province')->label('Provincia/Stato')->required(),
                        TextInput::make('address.postal_code')->label('CAP')->required(),
                        TextInput::make('address.country')->label('Paese')->required(),
                    ]),

            ]);
    }
}
