<?php

namespace App\Filament\Resources\Cms\Articles\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Forms\Components\RichContent;
use App\Filament\Forms\Components\RichEditor\Macro\PageBlocks;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Components\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inerba\Seo\SeoFields;
use Inerba\Seo\SocialFields;

class ArticleForm
{
    use \App\Filament\Resources\Cms\HasTemplateTrait;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Tabs::make('Tabs')
                    ->columnSpan(2)
                    ->tabs([
                        Tabs\Tab::make('Principale')
                            ->columns(2)
                            ->schema([
                                TranslatableTabs::make('seo_fields')
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->contained(false)
                                    ->columnSpanFull()
                                    ->schema([
                                        RichContent::make('content')
                                            ->label(__('pages.resources.page.form.content'))
                                            ->customBlocks(PageBlocks::blocks()),
                                        Textarea::make('excerpt')
                                            ->label('Riassunto')
                                            ->autosize()
                                            ->columnSpanFull()
                                            ->hintAction(
                                                Action::make('generate_excerpt')
                                                    ->label('Genera riassunto')
                                                    ->icon('heroicon-m-document-text')
                                                    ->action(function (callable $get, callable $set, Component $component) {
                                                        $locale = get_component_locale($component);
                                                        $content = $get("content.$locale");

                                                        if (blank($content)) {
                                                            return;
                                                        }

                                                        $excerpt = rich_editor_excerpt($content, 300);
                                                        $set("excerpt.$locale", $excerpt);
                                                    })
                                            )
                                            ->required(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Campi del tema')
                            ->visible(fn (callable $get) => ! empty(self::getCustomTemplateFields($get('extras.template'), 'articles')))
                            ->schema(fn (callable $get) => self::getCustomTemplateFields($get('extras.template'), 'articles')),

                        Tabs\Tab::make(__('pages.resources.page.form.tab_seo'))->schema([
                            TranslatableTabs::make('seo_fields')
                                ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                ->schema([...SeoFields::make('meta')]),
                        ]),
                        Tabs\Tab::make(__('pages.resources.page.form.tab_social'))->schema([
                            TranslatableTabs::make('social_fields')
                                ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                ->schema([...SocialFields::make('meta')]),
                        ]),
                        Tabs\Tab::make(__('pages.resources.page.form.advanced_settings'))->schema([

                            Toggle::make('extras.content_settings.dropcap')
                                ->label('Usa il capitello (drop cap) all\'inizio del contenuto')
                                ->onColor('success')
                                ->default(true),
                        ]),
                    ]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titolo')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (callable $set, callable $get, ?string $state, $component, $context) {
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
                                    ->label(__('pages.resources.page.form.slug'))
                                    ->live(false, debounce: 500)
                                    // ->helperText(new \Illuminate\Support\HtmlString(
                                    //     '<strong>Lo slug è un identificativo unico che appare nell\'URL del post.</strong>
                                    // <ul class="list-disc pl-4">
                                    //     <li>È importante per la SEO: scegli parole chiave rilevanti per il contenuto.</li>
                                    //     <li>Usa solo lettere minuscole, numeri e trattini (-), evita termini troppo generici.</li>
                                    //     <li>Meglio se breve e descrittivo.</li>
                                    // </ul>'
                                    // ))
                                    ->disabled(fn (callable $get) => $get('lock_slug'))
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
                                    ->afterStateUpdated(function (callable $set, ?string $state) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->rules(['alpha_dash'])
                                    ->unique(ignoreRecord: true)
                                    ->required(),

                                Select::make('tags')
                                    ->multiple()
                                    ->preload()
                                    ->relationship('tags', 'name')
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nome del tag')
                                            ->required()
                                            ->translatableTabs(),
                                    ]),

                                Select::make('category_id')
                                    ->label('Categoria')
                                    ->preload()
                                    ->relationship('category', 'name')
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nome della categoria')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (callable $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->required()
                                            ->translatableTabs(),
                                        TextInput::make('slug')
                                            ->required(),
                                    ])
                                    ->required(),

                                Select::make('user_id')
                                    ->label('Utente')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->default(fn () => Auth::user()?->id)
                                    ->hidden(function (string $context) {
                                        return ! auth()->user()->isAdmin();
                                    })
                                // ->visible(fn() => $user !== null)
                                ,
                                DateTimePicker::make('published_at')
                                    ->label('Data di pubblicazione')
                                    ->afterLabel([
                                        Action::make('clear')
                                            ->label('Rimuovi')
                                            ->icon('heroicon-s-x-circle')
                                            ->action(fn (callable $set) => $set('published_at', null))
                                            ->visible(fn (callable $get) => $get('published_at') !== null)
                                            ->size('sm'),
                                        Action::make('set_now')
                                            ->label('Adesso')
                                            ->icon('heroicon-s-clock')
                                            ->action(fn (callable $set) => $set('published_at', now()))
                                            ->requiresConfirmation(fn (callable $get) => $get('published_at') !== null)
                                            ->size('sm'),
                                    ])
                                    ->default(now()),
                                // ->visible($user->can('publish_post')),

                                Select::make('extras.template')
                                    ->hidden(fn () => count(self::getTemplateFields('articles')) <= 1)
                                    ->live()
                                    ->label('Tema dell\'articolo')
                                    ->options(self::getTemplateFields('articles'))
                                    ->default('default')
                                    ->required(),

                            ]),

                        Section::make('Immagine in evidenza')
                            ->schema([

                                SpatieMediaLibraryFileUpload::make('featured_image')
                                    ->live()
                                    ->image()
                                    ->hiddenLabel()
                                    ->collection('featured_image')
                                    ->directory('posts')
                                    ->disk('public')
                                    ->visibility('public')
                                    // ->rules(Rule::dimensions()->maxWidth(600)->maxHeight(800))
                                    ->afterStateUpdated(function ($livewire, SpatieMediaLibraryFileUpload $component) {
                                        $livewire->validateOnly($component->getStatePath());
                                    }),
                                // ->collection(fn (Component $component) => 'featured_image.'.get_component_locale($component))
                                // ->translatableTabs()->contained(false),

                                Toggle::make('extras.show_featured_image')
                                    ->label('Mostra nella testata')
                                    ->default(true),
                            ]),

                    ])->columnSpan(1),
            ]);
    }
}
