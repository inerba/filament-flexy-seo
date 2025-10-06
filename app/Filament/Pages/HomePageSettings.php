<?php

namespace App\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;
use Inerba\Seo\SeoFields;
use Inerba\Seo\SocialFields;
use ToneGabes\Filament\Icons\Enums\Phosphor;

/**
 * Class HomePageSettings
 *
 * Represents the settings page for the home page.
 */
class HomePageSettings extends AbstractPageSettings
{
    use HasPageShield;

    /**
     * @var array<string, mixed>|null The data associated with the settings.
     */
    public ?array $data = [];

    /**
     * @var string|null The title of the settings page.
     */
    protected static ?string $title = 'Home Page';

    /**
     * @var string|BackedEnum|null The navigation icon for the settings page.
     */
    protected static string|BackedEnum|null $navigationIcon = Phosphor::HouseDuotone;

    public static function getNavigationGroup(): ?string
    {
        return 'Contenuti';
    }

    /**
     * @var string The view associated with the settings page.
     */
    protected string $view = 'filament.pages.home-page-settings';

    /**
     * Get the name of the setting.
     *
     * @return string The name of the setting.
     */
    protected function settingName(): string
    {
        return 'home-page';
    }

    /**
     * Provide default values for the settings.
     *
     * @return array<string, mixed> The default data for the settings.
     */
    public function getDefaultData(): array
    {
        return [];
    }

    /**
     * Define the form schema for the settings page.
     *
     * @param  Schema  $schema  The schema instance.
     * @return Schema The modified schema with components.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Testo')
                            ->schema([
                                RichEditor::make('content')
                                    ->label(null)
                                    ->placeholder('Trascina e rilascia i componenti per iniziare...')
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Slider')
                            ->schema([
                                Select::make('slider_settings.height')
                                    ->label('Altezza slider')
                                    ->options([
                                        'small' => 'Piccolo',
                                        'medium' => 'Medio',
                                        'large' => 'Grande',
                                        'full' => 'Intero schermo',
                                    ])
                                    ->default('medium')
                                    ->required(),
                                Repeater::make('slides')
                                    ->collapsible()
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->schema([
                                        Tabs::make('Tabs')
                                            ->contained(false)
                                            ->tabs([
                                                Tabs\Tab::make('Testo')
                                                    ->columns(2)
                                                    ->schema([
                                                        TextInput::make('title')
                                                            ->label('Titolo'),

                                                        TextInput::make('subtitle')
                                                            ->label('Sottotitolo'),

                                                        RichEditor::make('content')
                                                            ->label('Contenuto')
                                                            ->placeholder('Content')
                                                            ->columnSpanFull(),

                                                        TextInput::make('button_text')
                                                            ->label('Testo del bottone'),

                                                        TextInput::make('button_link')
                                                            ->label('Link'),

                                                        Select::make('width')
                                                            ->label('Larghezza del testo')
                                                            ->options([
                                                                'small' => 'Piccolo',
                                                                'medium' => 'Medio',
                                                                'large' => 'Grande',
                                                            ])
                                                            ->default('medium')
                                                            ->required(),
                                                    ]),
                                                Tabs\Tab::make('Elementi multimediali')
                                                    ->columns(2)
                                                    ->schema([
                                                        Toggle::make('is_video')
                                                            ->live()
                                                            ->label('Video')
                                                            ->columnSpanFull()
                                                            ->default(false),

                                                        TextInput::make('duration')
                                                            ->label('Durata (in secondi)')
                                                            ->numeric()
                                                            ->default(5)
                                                            ->required()
                                                            ->columnSpanFull(),

                                                        FileUpload::make('video_mp4')
                                                            ->hidden(fn (Get $get) => $get('is_video') === false)
                                                            ->label('Video in formato MP4')
                                                            ->directory('home-slider-videos')
                                                            ->required()
                                                            ->acceptedFileTypes(['video/mp4']),

                                                        FileUpload::make('video_webm')
                                                            ->hidden(fn (Get $get) => $get('is_video') === false)
                                                            ->label('Video in formato WEBM')
                                                            ->directory('home-slider-videos')
                                                            ->acceptedFileTypes(['video/webm']),

                                                        FileUpload::make('image')
                                                            ->label(fn (Get $get) => $get('is_video') === true ? 'Immagine di fallback' : 'Immagine di sfondo')
                                                            ->directory('home-slider-images')
                                                            ->image()
                                                            ->imageEditor()
                                                            ->columnSpanFull(),
                                                    ]),
                                            ]),
                                    ])
                                    ->addActionLabel('Nuova slide'),
                            ]),
                        Tabs\Tab::make('SEO')->schema([
                            ...SeoFields::make('seo'),
                        ]),
                        Tabs\Tab::make('Social')->schema([
                            ...SocialFields::make('social'),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }
}
