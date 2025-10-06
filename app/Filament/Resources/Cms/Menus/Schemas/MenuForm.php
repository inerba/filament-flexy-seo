<?php

namespace App\Filament\Resources\Cms\Menus\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(debounce: 500)
                    ->afterStateUpdated(function ($state, callable $set, $component) {
                        if ($component === 'edit') {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    })
                    ->required(),

                Hidden::make('lock_slug')
                    ->live(false, 500)
                    ->afterStateHydrated(fn (callable $set, $context) => $set('lock_slug', $context === 'edit'))
                    ->dehydrated(false),

                TextInput::make('slug')
                    ->label(__('pages.resources.page.form.slug'))
                    ->live(false, debounce: 500)
                    ->helperText('Questo sarà l\'identificativo univoco del menu.')
                    ->disabled(fn (callable $get) => $get('lock_slug'))
                    ->hintAction(
                        fn ($context) => $context == 'edit' ?
                            Action::make('toggle_lock_slug')
                                ->hiddenLabel()
                                ->icon(fn (callable $get) => $get('lock_slug') ? 'heroicon-s-lock-closed' : 'heroicon-s-lock-open')
                                ->action(fn (callable $set, callable $get) => $set('lock_slug', ! $get('lock_slug')))
                            : null
                    )
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->rules(['alpha_dash'])
                    ->unique(ignoreRecord: true)
                    ->required(),
            ]);
    }
}
