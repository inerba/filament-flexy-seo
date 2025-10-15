<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('items')
                    ->label('Prodotti')
                    ->wrap()
                    ->bulleted()
                    ->formatStateUsing(function ($state) {
                        if ($state->quantity > 1) {
                            return $state->name.' x '.$state->quantity;
                        }

                        return $state->name;
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount_total')
                    ->label('Importo Totale')
                    ->money('eur', 100)
                    ->sortable(),

                TextColumn::make('shipping_address')
                    ->label('Indirizzo di Spedizione')
                    ->wrap()
                    // ->formatStateUsing(function ($state) {
                    //     dump($state);

                    //     return $state->line1.', '.$state->city.' ('.$state->postal_code.')';
                    // })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
