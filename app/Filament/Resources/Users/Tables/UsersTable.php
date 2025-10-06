<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Ruolo')
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->colors(['info'])
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // SelectFilter::make('roles')
                //     ->label('Ruolo')
                //     ->relationship('roles', 'name')
                //     ->multiple()
                //     ->preload(),
            ])
            ->recordActions([
                Impersonate::make()
                    ->label('Impersonate')
                    ->hidden(function (User $user) {

                        $authUser = Auth::user();

                        // Non puoi impersonare te stesso
                        if ($authUser instanceof User && $authUser->getKey() === $user->getKey()) {
                            return true;
                        }

                        // Super admin può impersonare tutti gli utenti
                        // if ($authUser->hasRole('super_admin')) {
                        //     return false;
                        // }

                        // Esempio: Gli altri possono impersonare solo gli agenti
                        // return ! $user->hasRole('agent');

                        // Esempio 2: Gli altri possono impersonare tutti tranne 'super_admin' e 'admin'
                        // return ! $user->hasRole(['super_admin', 'admin']);

                        // solo i super_admin possono impersonare
                        // return true;
                    })
                    ->redirectTo(fn () => url('/admin')),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
