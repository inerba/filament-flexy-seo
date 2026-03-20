<?php

namespace App\Providers\Filament;

use AchyutN\FilamentLogViewer\FilamentLogViewer;
use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\Cms\Categories\CategoryResource;
use App\Filament\Resources\Cms\Menus\MenuResource;
use App\Filament\Resources\Cms\Tags\TagResource;
use App\Filament\Widgets\Completissimo;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Awcodes\QuickCreate\QuickCreatePlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\FontProviders\BunnyFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Pboivin\FilamentPeek\FilamentPeekPlugin;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->profile()
            ->maxContentWidth(Width::ScreenTwoExtraLarge)
            ->brandLogo(fn () => view('filament.admin.logo'))
            // ->brandLogo(asset('images/logo.svg'));
            // ->sidebarFullyCollapsibleOnDesktop(true)
            // ->sidebarCollapsibleOnDesktop(true)
            ->sidebarWidth('280px')
            ->colors([
                'primary' => Color::all()[db_config('website.filament_colors.primary', 'amber')],
                'success' => Color::all()[db_config('website.filament_colors.success', 'green')],
                'warning' => Color::all()[db_config('website.filament_colors.warning', 'amber')],
                'danger' => Color::all()[db_config('website.filament_colors.danger', 'red')],
                'info' => Color::all()[db_config('website.filament_colors.info', 'blue')],
                'gray' => Color::all()[db_config('website.filament_colors.gray', 'zinc')],
            ])
            // ->font('IBM Plex Sans', provider: BunnyFontProvider::class)
            ->font('Inter', provider: BunnyFontProvider::class)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                // Completissimo::class,
                OverlookWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make(fn () => new HtmlString('Visita il sito'))
                    ->url('/', shouldOpenInNewTab: true)
                    ->icon(Phosphor::StorefrontDuotone)
                    ->sort(-1),
            ])->plugins([
                FilamentShieldPlugin::make()
                    ->globallySearchable(false)
                    ->navigationGroup('Impostazioni')
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                FilamentLogViewer::make()
                    ->navigationGroup('Impostazioni')
                    ->navigationIcon('heroicon-s-bug-ant')
                    ->authorize(fn () => auth()->user()->hasRole('super_admin')),
                FilamentPeekPlugin::make()->disablePluginStyles(),
                OverlookPlugin::make()
                    ->sort(2)
                    ->excludes([
                        TagResource::class,
                        CategoryResource::class,
                    ])
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                        'md' => 3,
                        'lg' => 4,
                        'xl' => 5,
                        '2xl' => null,
                    ]),
                QuickCreatePlugin::make()
                    ->excludes([
                        TagResource::class,
                        CategoryResource::class,
                        MenuResource::class,
                    ]),
            ]);
    }
}
