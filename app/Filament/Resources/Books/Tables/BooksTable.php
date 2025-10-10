<?php

namespace App\Filament\Resources\Books\Tables;

use App\Filament\Resources\BookAuthors\BookAuthorResource;
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
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->wrap()
                    ->badge()
                    ->searchable(),
                // Stack::make([
                Tables\Columns\TextColumn::make('authors.name')
                    ->label('Autori')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->getStateUsing(function ($record) {
                        return $record->authors->map(function ($author) {
                            $link = BookAuthorResource::getUrl('edit', ['record' => $author->slug]);

                            return "<a href='".$link."'>".$author->name.'</a>';
                        })->implode(', ');
                    })
                    ->html()
                    ->wrap(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Anno')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('pages')
                    ->label('Pagine')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
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
