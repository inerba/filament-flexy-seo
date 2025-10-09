<?php

namespace App\Filament\Resources\Books\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Resources\BookAuthors\Schemas\BookAuthorForm;
use App\Filament\Resources\BookSeries\Schemas\BookSeriesForm;
use App\Filament\Resources\Genres\Schemas\GenreForm;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
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
                                    ->afterStateUpdated(function (callable $set, callable $get, ?string $state) {
                                        if ($get('lock_slug')) {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('meta.subtitle')
                                    ->label('Sottotitolo')
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->columnSpanFull(),

                                Forms\Components\Hidden::make('lock_slug')
                                    ->live(false, 500)
                                    ->dehydrated(false)
                                    ->afterStateHydrated(fn (callable $set, $context) => $set('lock_slug', $context === 'edit')),

                                Forms\Components\Select::make('authors')
                                    ->label('Autore')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->multiple()
                                    ->relationship(name: 'authors', titleAttribute: 'name')
                                    ->createOptionForm(BookAuthorForm::configure(Schema::make())->getComponents()),

                                Forms\Components\Select::make('genres')
                                    ->label('Generi')
                                    ->multiple()
                                    ->preload()
                                    ->relationship(name: 'genres', titleAttribute: 'name')
                                    ->createOptionForm(GenreForm::configure(Schema::make())->getComponents()),

                                Forms\Components\Select::make('book_series')
                                    ->label('Collana')
                                    ->preload()
                                    ->relationship(name: 'book_series', titleAttribute: 'name')
                                    ->createOptionForm(BookSeriesForm::configure(Schema::make())->getComponents()),
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

                            ->hintActions(
                                [
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
                                ]
                            )
                            ->rules(['alpha_dash'])
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull()
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('covers')
                            ->label('Copertina')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('books/covers')
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('mockup')
                            ->collection('mockups')
                            ->label('Mockup')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('books/covers')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('year')
                            ->label('Anno')
                            ->numeric(),
                        Forms\Components\TextInput::make('pages')
                            ->label('Pagine')
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
