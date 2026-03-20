<?php

namespace App\Filament\Resources\Customers\Tables;

use App\Filament\Actions\VerifyCustomerEmailAction;
use App\Models\Customer;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->label('Verificato il')
                    ->badge(fn (Customer $record): bool => ! $record->hasVerifiedEmail())
                    ->color(fn (Customer $record): string => $record->hasVerifiedEmail() ? 'gray' : 'success')
                    ->state(fn (Customer $record): string => $record->hasVerifiedEmail()
                        ? ($record->email_verified_at?->format('d/m/Y H:i') ?? '-')
                        : 'Segna come verificato')
                    ->disabledClick(fn (Customer $record): bool => $record->hasVerifiedEmail())
                    ->action(VerifyCustomerEmailAction::make())
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Aggiornato il')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
