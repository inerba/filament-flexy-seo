<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Copertina')
                    ->collection('covers')
                    ->imageHeight(90)
                    ->width('auto')
                    ->conversion('icon'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->description(fn ($record) => Str::limit($record->short_description, 150))
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('genres.name')
                    ->label('Generi')
                    ->badge()
                    ->searchable(),
                // Stack::make([
                Tables\Columns\TextColumn::make('author.name')
                    // ->description(function ($record) {
                    //     $avatar = $record->author->getFirstMediaUrl('avatars', 'icon');
                    //     return new HtmlString("<img src='{$avatar}' alt='{$record->author->name}' class='mx-auto rounded-full size-12'>");
                    // }, 'above')
                    ->searchable()
                    ->sortable(),
                //     SpatieMediaLibraryImageColumn::make('author.avatar')
                //         ->label('Avatar')
                //         ->collection('avatars')
                //         ->height(90)
                //         ->width('auto')
                //         ->circular()
                //         ->conversion('icon'),
                // ]),
                Tables\Columns\TextColumn::make('year')
                    ->label('Anno')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pages')
                    ->label('Pagine')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('publisher')
                    ->label('Editore')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.price')
                    ->label('Prezzo')
                    ->money('EUR')
                    ->sortable(),
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
