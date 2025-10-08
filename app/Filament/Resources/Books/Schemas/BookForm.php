<?php

namespace App\Filament\Resources\Books\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Inerba\Seo\SeoFields;
use Inerba\Seo\SocialFields;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Tabs::make()
                    ->columnSpan(2)
                    ->tabs([
                        Tabs\Tab::make('Scheda')
                            ->columns(2)
                            ->schema([

                                Forms\Components\TextInput::make('title')
                                    ->label('Titolo')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state, $context) {
                                        if ($context === 'edit') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->columnSpanFull(),

                                Forms\Components\Hidden::make('lock_slug')
                                    ->live(false, 500)
                                    ->dehydrated(false)
                                    ->afterStateHydrated(fn (Set $set, $context) => $set('lock_slug', $context === 'edit')),

                                Forms\Components\Select::make('author_id')
                                    ->label('Autore')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->relationship(name: 'author', titleAttribute: 'name')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nome')
                                            ->required(),
                                    ]),

                                Forms\Components\Select::make('genres')
                                    ->label('Generi')
                                    ->multiple()
                                    ->preload()
                                    ->relationship(name: 'genres', titleAttribute: 'name')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nome')
                                            ->required(),
                                    ]),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Descrizione')
                                    ->required()
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('short_description')
                                    ->label('Descrizione breve')
                                    ->required()
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make(__('pages.resources.page.form.tab_seo'))->schema([
                            TranslatableTabs::make('seo_fields')
                                ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                ->schema(SeoFields::make('meta')),
                        ]),
                        Tabs\Tab::make(__('pages.resources.page.form.tab_social'))->schema([
                            TranslatableTabs::make('social_fields')
                                ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                ->schema(SocialFields::make('meta')),
                        ]),
                    ])->columnSpan(2),
                Section::make()
                    ->columnSpan(1)
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled(fn (Get $get) => $get('lock_slug'))
                            ->hintAction(
                                fn ($context) => $context == 'edit' ?
                                    Action::make('toggle_lock_slug')
                                        ->icon(fn (Get $get) => $get('lock_slug') ? 'heroicon-s-lock-closed' : 'heroicon-s-lock-open')
                                        ->hiddenLabel()
                                        ->action(fn (Set $set, Get $get) => $set('lock_slug', ! $get('lock_slug')))
                                    : null
                            )
                            ->rules(['alpha_dash'])
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull()
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('covers')
                            ->label('Copertina')
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('mockup')
                            ->collection('mockups')
                            ->label('Mockup')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('year')
                            ->label('Anno')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('pages')
                            ->label('Pagine')
                            ->required()
                            ->numeric(),
                        // Forms\Components\TextInput::make('price')
                        //     ->label('Prezzo')
                        //     ->required()
                        //     ->numeric()
                        //     ->prefix('€'),
                        Forms\Components\TextInput::make('publisher')
                            ->label('Editore')
                            ->required()
                            ->columnSpanFull()
                            ->default('CLUSTER-A'),
                        Forms\Components\Select::make('product_id')
                            ->label('Prodotto')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->relationship(name: 'product', titleAttribute: 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record?->name.' - '.format_money($record?->price))
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Descrizione'),
                                Forms\Components\TextInput::make('price')
                                    ->label('Prezzo')
                                    ->required()
                                    ->numeric()
                                    ->prefix('€'),

                            ])->columnSpanFull(),
                    ]),

            ]);
    }
}
