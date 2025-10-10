<?php

namespace App\Filament\Resources\Events\Tables;

use App\Models\Event;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titolo')
                    ->description(fn (Event $record) => Str::limit($record->excerpt, 100))
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Data')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Luogo')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('published_at')
                    ->dateTime('d/m/Y H:i')
                    ->description(function (Event $record) {
                        if (is_null($record->published_at)) {
                            return 'Bozza';
                        }

                        return $record->is_published ? null : 'In attesa di pubblicazione';
                    })
                    ->placeholder('Bozza')
                    ->color(fn (Event $record) => $record->is_published ? null : 'warning')
                    ->sortable()
                    ->icon('heroicon-o-clock')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->label('Pubblicazione'),
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
            ])
            ->defaultSort('published_at', 'desc');
    }
}
