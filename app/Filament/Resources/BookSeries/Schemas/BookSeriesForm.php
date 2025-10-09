<?php

namespace App\Filament\Resources\BookSeries\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookSeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Collana')
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
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->disabled(fn (callable $get) => $get('lock_slug'))
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

                Textarea::make('description')
                    ->label('Descrizione')
                    ->translatableTabs()
                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                    ->columnSpanFull(),
            ]);
    }
}
