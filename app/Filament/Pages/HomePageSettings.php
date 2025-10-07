<?php

namespace App\Filament\Pages;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Forms\Components\RichContent;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
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
                                TranslatableTabs::make('section')->schema([
                                    TextInput::make('section_1.title')
                                        ->label('Titolo sezione')
                                        ->columnSpanFull(),
                                    RichContent::make('section_1.content')
                                        ->label(null)
                                        ->columnSpanFull(),
                                ]),
                            ]),
                        Tabs\Tab::make('Slider')
                            ->schema([
                                Repeater::make('slides')
                                    ->schema([
                                        FileUpload::make('image_desktop')
                                            ->imageEditor()
                                            ->image()
                                            ->hint('Dimensioni consigliate: 2144x860')
                                            ->label('Immagine desktop')
                                            ->visibility('public')
                                            ->disk('public')
                                            ->directory('home-slider'),
                                        FileUpload::make('image_mobile')
                                            ->imageEditor()
                                            ->image()
                                            ->hint('Dimensioni consigliate: 600x600')
                                            ->label('Immagine mobile')
                                            ->visibility('public')
                                            ->disk('public')
                                            ->directory('home-slider'),
                                        TextInput::make('url')
                                            ->helperText('Inserisci l\'indirizzo URL della pagina a cui si deve collegare lo slide, lascia vuoto per non collegare')
                                            ->label('Indirizzo URL')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),
                        Tabs\Tab::make('SEO')->schema([
                            TranslatableTabs::make('seo_fields')->schema(SeoFields::make('meta')),
                        ]),
                        Tabs\Tab::make('Social')->schema([
                            TranslatableTabs::make('social_fields')->schema(SocialFields::make('meta')),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }
}
