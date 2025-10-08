<?php

namespace App\Filament\Resources\Cms\Categories\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome della categoria')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get, $component) {
                        // fallo solo per la lingua di default
                        if (get_component_locale($component) == config('app.locale') && ! $get('lock_slug')) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->translatableTabs()
                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs']),

                Hidden::make('lock_slug')
                    ->live(false, 500)
                    ->afterStateHydrated(fn (callable $set, $context) => $set('lock_slug', $context === 'edit'))
                    ->dehydrated(false),

                TextInput::make('slug')
                    ->label('Slug')
                    ->live(false, debounce: 500)
                    // ->hintAction(
                    //     Action::make('permalink')
                    //         ->icon('heroicon-o-arrow-top-right-on-square')
                    //         ->color('primary')
                    //         ->tooltip('Apri la categoria in una nuova scheda')
                    //         ->url(fn ($record) => $record->permalink, true)
                    //         ->label(fn ($record) => $record->permalink)
                    //         ->hidden(fn ($context) => $context === 'create'),
                    // )
                    // ->helperText(new \Illuminate\Support\HtmlString(
                    //     '<strong>Lo slug è un identificativo unico che appare nell\'URL del post.</strong>
                    //                     <ul class="list-disc pl-4">
                    //                         <li>È importante per la SEO: scegli parole chiave rilevanti per il contenuto.</li>
                    //                         <li>Usa solo lettere minuscole, numeri e trattini (-), evita termini troppo generici.</li>
                    //                         <li>Meglio se breve e descrittivo.</li>
                    //                     </ul>'
                    // ))
                    ->afterStateUpdated(function ($state, callable $set, $component) {
                        $set('slug', Str::slug($state));
                    })
                    ->disabled(fn (callable $get) => $get('lock_slug'))
                    // ->hintAction(
                    //     fn ($context) => $context == 'edit' ?
                    //         Action::make('toggle_lock_slug')
                    //             ->label(fn (callable $get) => $get('lock_slug') ? 'Sblocca' : 'Blocca')
                    //             ->icon(fn (callable $get) => $get('lock_slug') ? 'heroicon-s-lock-closed' : 'heroicon-s-lock-open')
                    //             ->action(fn (callable $set, callable $get) => $set('lock_slug', ! $get('lock_slug')))
                    //         : null
                    // )
                    ->hintActions([
                        Action::make('toggle_lock_slug')
                            ->tooltip(fn (callable $get) => $get('lock_slug') ? 'Sblocca' : 'Blocca')
                            ->icon(fn (callable $get) => $get('lock_slug') ? 'heroicon-s-lock-closed' : 'heroicon-s-lock-open')
                            ->iconButton()
                            ->action(fn (callable $set, callable $get) => $set('lock_slug', ! $get('lock_slug'))),
                        Action::make('permalink')
                            ->hidden(fn ($context) => $context === 'create')
                            ->link()
                            ->icon('heroicon-m-link')
                            ->iconButton()
                            ->color('gray')
                            ->url(fn ($record) => $record?->permalink, true)
                            ->tooltip('Vai alla pagina'),
                    ])
                    ->rules(['alpha_dash'])
                    ->unique(ignoreRecord: true),

                Textarea::make('extras.description')
                    ->label('Descrizione')
                    ->translatableTabs()
                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                    ->columnSpanFull(),

                TextInput::make('extras.post_per_page')
                    ->label('Post per pagina')
                    ->numeric()
                    ->minValue(6)
                    ->default(12)
                    ->maxValue(48)
                    ->rule('multiple_of:6'),

            ]);
    }
}
