<?php

namespace App\Filament\Resources\Cms\Pages\Tables;

use App\Models\Cms\Page;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('pages.resources.page.table.title'))
                    ->size('xl')
                    // ->description(fn (Page $record): mixed => $record->hasCustomView() ? __('pages.resources.page.table.has_custom_view') : false)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('permalink')
                    ->label(__('pages.resources.page.table.permalink'))
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->icon('heroicon-o-link')
                    ->url(fn ($state) => $state, true)
                    ->formatStateUsing(fn ($state) => str()->of($state)->replace(url('/'), '')),

                SpatieMediaLibraryImageColumn::make('featured_images')
                    ->label(__('pages.resources.page.table.featured_images'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->conversion('icon')
                    ->height(60)
                    ->circular()
                    ->stacked()
                    ->overlap(8)
                    ->limit(2)
                    ->limitedRemainingText()
                    ->collection('featured_images'),

                IconColumn::make('has_custom_view')
                    ->label(__('pages.resources.page.table.has_custom_view'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->state(fn (Page $record): bool => $record->hasCustomView())
                    ->trueIcon('heroicon-s-bolt')
                    ->falseIcon('heroicon-s-bolt-slash')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    ReplicateAction::make()
                        ->mutateRecordDataUsing(function (array $data): array {
                            $data['user_id'] = auth()->id();
                            $data['title'][config('app.locale')] = $data['title'][config('app.locale')].' (Copia)';
                            $data['slug'] = Str::slug($data['title'][config('app.locale')].'-'.Str::random(5));

                            return $data;
                        }),
                    Action::make('view_permalink')
                        ->label('Visualizza pagina')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->color('success')
                        ->url(fn (Page $record) => $record->permalink, true),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }
}
