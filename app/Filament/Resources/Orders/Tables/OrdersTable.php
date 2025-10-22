<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Numero')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Stato')
                    ->toggleable()
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->toggleable()
                    ->description(fn ($record) => $record->customer->email)
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('items.count')
                //     ->label('Prodotti')
                //     ->wrap()
                //     ->bulleted()
                //     ->formatStateUsing(function ($state) {
                //         if ($state->quantity > 1) {
                //             return $state->name.' x '.$state->quantity;
                //         }

                //         return $state->name;
                //     })
                //     ->sortable()
                //     ->searchable(),
                TextColumn::make('items_count')
                    ->label('Prodotti')
                    ->toggleable()
                    ->counts('items'),
                TextColumn::make('amount_total')
                    ->label('Importo Totale')
                    ->toggleable()
                    ->money('eur')
                    ->sortable(),

                TextColumn::make('shipping_address')
                    ->label('Indirizzo di Spedizione')
                    ->toggleable(true, true)
                    ->wrap()
                    // ->formatStateUsing(function ($state) {
                    //     dump($state);

                    //     return $state->line1.', '.$state->city.' ('.$state->postal_code.')';
                    // })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->toggleable()
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('changeStatus')
                    ->label('Cambia stato')
                    ->schema([
                        Select::make('status')
                            ->options(\App\Enums\Shop\OrderStatus::class)
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->status = $data['status'];
                        $record->save();
                    })
                    ->requiresConfirmation(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
