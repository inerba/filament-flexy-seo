<?php

namespace App\Filament\Resources\Cms\Articles\Tables;

use App\Filament\Resources\Cms\Articles\ArticleResource;
use App\Models\Cms\Article;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('featured_image')
                    ->collection('featured_image')
                    ->conversion('icon')
                    ->label('Copertina')
                    ->imageSize(90)
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->description(fn (Article $record) => Str::limit($record->excerpt, 100))
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Autore')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('d/m/Y H:i')
                    ->description(function (Article $record) {
                        if (is_null($record->published_at)) {
                            return 'Bozza';
                        }

                        return $record->is_published ? null : 'In attesa di pubblicazione';
                    })
                    ->placeholder('Bozza')
                    ->color(fn (Article $record) => $record->is_published ? null : 'warning')
                    ->sortable()
                    ->icon('heroicon-o-clock')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->label('Pubblicazione'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Aggiornamento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Stato di pubblicazione')
                    ->placeholder('Tutti i post')
                    ->trueLabel('Pubblicati')
                    ->falseLabel('Programmati')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('published_at')->where('published_at', '<=', now()),
                        false: fn (Builder $query) => $query->whereNull('published_at')->orWhere('published_at', '>', now()),
                        blank: fn (Builder $query) => $query, // No filter applied
                    ),

                SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('user_id')
                    ->label('Autore')
                    ->relationship('user', 'name', fn ($query) => $query->has('articles'))
                    ->multiple()
                    ->preload(),

            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    ReplicateAction::make()
                        ->fillForm(function ($record) {
                            $title = [];
                            // foreach language, set title and slug
                            foreach (get_supported_locales() as $locale) {
                                $title[$locale] = $record->getTranslation('title', $locale).' (Copia)';
                            }

                            return [
                                'title' => $title,
                                'slug' => Str::slug($record['title'].' (Copia)'),
                                'user_id' => Auth::user()->id,
                                'published_at' => null,
                            ];
                        })
                        ->schema([
                            TextInput::make('title')
                                ->label('Titolo')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set, $component) {
                                    // fallo solo per la lingua di default
                                    if (get_component_locale($component) == config('app.locale')) {
                                        $set('slug', Str::slug($state));
                                    }
                                })
                                ->translatableTabs(),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->live(false, debounce: 500)
                                ->helperText(new \Illuminate\Support\HtmlString(
                                    '<strong>Lo slug è un identificativo unico che appare nell\'URL del post.</strong>
                                        <ul class="list-disc pl-4">
                                            <li>È importante per la SEO: scegli parole chiave rilevanti per il contenuto.</li>
                                            <li>Usa solo lettere minuscole, numeri e trattini (-), evita termini troppo generici.</li>
                                            <li>Meglio se breve e descrittivo.</li>
                                        </ul>'
                                ))
                                ->afterStateUpdated(function ($state, callable $set, $component) {
                                    $set('slug', Str::slug($state));
                                })
                                ->rules(['alpha_dash'])
                                ->unique(ignoreRecord: true),
                            Hidden::make('user_id'),
                            Hidden::make('published_at'),
                        ])
                        ->successRedirectUrl(fn (Article $replica) => ArticleResource::getUrl('edit', ['record' => $replica])),
                    Action::make('view_permalink')
                        ->label('Visualizza pagina')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->color('info')
                        ->url(fn (Article $record) => $record->permalink, true),
                    // Azione per pubblicare un articolo non ancora pubblicato
                    Action::make('publish')
                        ->label(fn (Article $record) => $record->is_published ? 'Ripubblica' : 'Pubblica ora')
                        ->icon('heroicon-o-rocket-launch')
                        ->color('success')
                        ->action(function (Article $record) {
                            $record->published_at = now();
                            $record->save();
                        })
                        ->requiresConfirmation()
                        ->visible(fn (Article $record) => ! $record->is_published),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');

    }
}
