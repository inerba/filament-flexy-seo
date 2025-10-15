<?php

namespace App\Providers;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Customer;
use Filament\Support\Facades\FilamentIcon;
use Filament\View\PanelsIconAlias;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class AppServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Imposto il modello Customer per Cashier
        Cashier::useCustomerModel(Customer::class);
        // Cashier::calculateTaxes();

        $this->configureFilamentFormComponents();
        $this->configureFilamentTableComponents();

        FilamentIcon::register([
            PanelsIconAlias::PAGES_DASHBOARD_NAVIGATION_ITEM => Phosphor::GaugeDuotone,
        ]);

        // Carico le rotte tradotte, utilizzando la cache
        RouteServiceProvider::loadCachedRoutesUsing(fn () => $this->loadCachedRoutes());
    }

    private function configureFilamentFormComponents(): void
    {
        // Imposto la timezone di default
        \Filament\Forms\Components\DatePicker::configureUsing(fn (\Filament\Forms\Components\DatePicker $component) => $component->timezone(config('cms.timezone')));
        \Filament\Forms\Components\DateTimePicker::configureUsing(fn (\Filament\Forms\Components\DateTimePicker $component) => $component->timezone(config('cms.timezone')));

        TranslatableTabs::configureUsing(function (TranslatableTabs $component) {
            $component
                ->addDirectionByLocale()
                ->addEmptyBadgeWhenAllFieldsAreEmpty(emptyLabel: __('locales.empty'))
                // locales labels
                ->localesLabels($this->getLocaleLabels())
                // default locales
                ->locales($this->orderedSupportedLocales());
        });
    }

    private function configureFilamentTableComponents(): void
    {
        // Imposto la timezone di default
        \Filament\Tables\Columns\TextColumn::configureUsing(fn (\Filament\Tables\Columns\TextColumn $column) => $column->timezone(config('cms.timezone')));
    }

    /**
     * Helper methods
     * */

    /**
     * Return an array of supported locales with their translated names.
     *
     * @return array<string, string> Associative array of locale codes and their translated names.
     */
    private function getLocaleLabels(): array
    {
        $locales = get_supported_locales();
        $localeLabels = [];
        if (! empty($locales)) {
            // Get name from config if exists, otherwise use translation
            $translations = array_map(function (string $code) {
                $configName = config("laravellocalization.supportedLocales.$code.name");
                if ($configName) {
                    return __($configName);
                } else {
                    return __('locales.'.$code);
                }
            }, $locales);

            $localeLabels = array_combine($locales, $translations) ?: [];
        }

        return $localeLabels;
    }

    /**
     * Return supported locales ensuring the app default locale is first in the array.
     */
    private function orderedSupportedLocales(): array
    {
        $supported = get_supported_locales();

        if (empty($supported)) {
            return [];
        }

        // If supported is an associative array (codes as keys), use keys.
        $locales = (array_values($supported) === $supported) ? array_values($supported) : array_keys($supported);

        $default = config('app.locale');

        if ($default && in_array($default, $locales, true)) {
            $locales = array_values(array_unique($locales));
            $locales = array_merge([$default], array_values(array_filter($locales, fn ($l) => $l !== $default)));
        }

        return $locales;
    }
}
