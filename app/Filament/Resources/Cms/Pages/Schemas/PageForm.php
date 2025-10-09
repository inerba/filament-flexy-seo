<?php

namespace App\Filament\Resources\Cms\Pages\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Forms\Components\RichContent;
use App\Filament\Forms\Components\RichEditor\Macro\PageBlocks;
use App\Models\Cms\Page;
use Filament\Actions\Action;
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
use Illuminate\Support\Str;
use Inerba\Seo\Facades\SocialFields;
use Inerba\Seo\SeoFields;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                Tabs::make()
                    ->tabs([
                        Tabs\Tab::make(__('pages.resources.page.form.tab_content'))
                            // ->columns(2)
                            ->schema([
                                RichContent::make('content')
                                    // ->label(__('pages.resources.page.form.content'))
                                    ->hiddenLabel()
                                    ->customBlocks(PageBlocks::blocks())
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->contained(false)
                                    ->columnSpan(2),
                            ]),
                        Tabs\Tab::make('Campi extra')
                            ->visible(fn ($record) => $record && ! empty(self::getCustomFields($record)))
                            ->schema(fn ($record) => self::getCustomFields($record)),

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
                        Tabs\Tab::make(__('pages.resources.page.form.advanced_settings'))->schema([
                            Select::make('parent_id')
                                ->label(__('pages.resources.menu_item.form.parent'))
                                ->live()
                                ->placeholder(__('pages.resources.menu_item.form.parent_placeholder'))
                                ->searchable()
                                ->preload()
                                ->options(fn ($record) => Page::query()
                                    ->whereNull('parent_id')
                                    ->when($record, function ($query, $record) {
                                        return $query->where('id', '!=', $record->id);
                                    })
                                    ->pluck('title', 'id'))
                                ->nullable(),
                            Toggle::make('extras.content_settings.dropcap')
                                ->label('Usa il capitello (drop cap) all\'inizio del contenuto')
                                ->onColor('success')
                                ->default(false),
                        ]),
                    ])->columnSpan(2),

                Group::make()
                    ->schema([

                        Section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->columnSpanFull()
                                    ->label(__('pages.resources.page.form.title'))
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (callable $set, callable $get, ?string $state, $component) {
                                        if ($get('lock_slug')) {
                                            return;
                                        }

                                        if (get_component_locale($component) == config('app.locale')) {
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
                                    ->prefix(fn ($record) => $record?->parent ? $record?->parent?->slug.'/' : null)
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

                                Textarea::make('lead')
                                    ->label(__('pages.resources.page.form.lead'))
                                    ->autosize()
                                    ->translatableTabs()
                                    ->extraAttributes(fn () => is_multilingual() ? [] : ['class' => 'hide-tabs'])
                                    ->columnSpanFull(),
                            ]),

                        Section::make(__('pages.resources.page.form.featured_images'))
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('featured_images')
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        null,
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->live()
                                    ->multiple()
                                    ->reorderable()
                                    ->appendFiles()
                                    ->openable()
                                    ->image()
                                    ->hiddenLabel()
                                    ->collection('featured_images')
                                    ->disk('public')
                                    ->visibility('public')
                                // ->rules(Rule::dimensions()->maxWidth(600)->maxHeight(800))
                                // ->afterStateUpdated(function (Forms\Contracts\HasForms $livewire, SpatieMediaLibraryFileUpload $component) {
                                //     $livewire->validateOnly($component->getStatePath());
                                // })
                                ,
                                Toggle::make('extras.show_featured_image')
                                    ->label('Mostra immagine nella testata')
                                    ->default(true),
                            ]),
                    ])->columnSpan(1),
            ]);
    }

    protected static function getCustomFields($record): array
    {
        if (! $record) {
            return [];
        }

        $class = 'App\\Filament\\Resources\\Cms\\Pages\\CustomPages\\'.Str::studly(str_replace(['-', '_'], ' ', $record->slug));

        if (class_exists($class) && method_exists($class, 'fields')) {
            return $class::fields();
        }

        return [];
    }
}
