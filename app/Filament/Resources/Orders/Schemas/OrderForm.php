<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\Shop\OrderStatus;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        //     "billing_address" => "{"name":"Francesco Apruzzese","city":"Recusandae Incididu","country":"IT","line1":"407 Nobel Boulevard","line2":"Molestiae aliqua Ma","postal_code":"Qui et elit ▶"
        // "shipping_address" => "{"name":"Kirby Silva","city":"Recusandae Incididu","country":"IT","line1":"407 Nobel Boulevard","line2":"Molestiae aliqua Ma","postal_code":"Qui et elit id ad","state":"PV"} ◀"
        return $schema
            ->columns(3)
            ->components([
                Grid::make()
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->disabledOn('edit')
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->label('Stato')
                            ->options(OrderStatus::class)
                            ->required(),
                        Repeater::make('items')
                            ->label('Prodotti')
                            ->disabledOn('edit')
                            ->relationship()
                            ->columnSpanFull()
                            ->columns(3)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Prodotto')
                                    ->relationship('product', 'name')
                                    ->columnSpanFull()
                                    ->required(),
                                TextInput::make('amount_subtotal')
                                    ->label('Prezzo Unitario')
                                    ->numeric()
                                    ->required()
                                    ->suffix('€'),
                                TextInput::make('quantity')
                                    ->label('Quantità')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required(),
                                TextInput::make('amount_total')
                                    ->label('Totale')
                                    ->numeric()
                                    ->required()
                                    ->suffix('€'),
                            ]),
                        Section::make('Indirizzo di Spedizione')
                            ->collapsible()

                            ->columns(2)
                            ->schema([
                                TextInput::make('shipping_address.name')->label('Nome Completo')->columnSpanFull()->required(),
                                TextInput::make('shipping_address.line1')->label('Indirizzo Linea 1')->columnSpanFull()->required(),
                                TextInput::make('shipping_address.line2')->label('Indirizzo Linea 2')->columnSpanFull(),
                                TextInput::make('shipping_address.city')->label('Città')->required(),
                                TextInput::make('shipping_address.state')->label('Provincia'),
                                TextInput::make('shipping_address.postal_code')->label('CAP')->required(),
                                TextInput::make('shipping_address.country')->label('Paese')->required(),
                            ]),
                        Section::make('Indirizzo di Fatturazione')
                            ->collapsible()

                            ->columns(2)
                            ->schema([
                                TextInput::make('billing_address.name')->label('Nome Completo')->columnSpanFull()->required(),
                                TextInput::make('billing_address.line1')->label('Indirizzo Linea 1')->columnSpanFull()->required(),
                                TextInput::make('billing_address.line2')->label('Indirizzo Linea 2')->columnSpanFull(),
                                TextInput::make('billing_address.city')->label('Città')->required(),
                                TextInput::make('billing_address.state')->label('Provincia'),
                                TextInput::make('billing_address.postal_code')->label('CAP')->required(),
                                TextInput::make('billing_address.country')->label('Paese')->required(),
                            ]),
                    ]),
                Section::make('Riepilogo Ordine')
                    ->columns(2)
                    ->schema([
                        TextInput::make('amount_subtotal')
                            ->label('Subtotale')
                            ->suffix('€')
                            ->disabled(),
                        TextInput::make('amount_shipping')
                            ->label('Spese di Spedizione')
                            ->suffix('€')
                            ->disabled(),
                        TextInput::make('amount_total')
                            ->label('Totale')
                            ->columnSpanFull()
                            ->suffix('€')
                            ->disabled(),
                    ])->columnSpan(1),
            ]);
    }
}
