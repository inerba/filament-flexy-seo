<?php

namespace Inerba\Seo;

use Filament\Schemas\Components\Tabs;
use Filament\Support\Icons\Heroicon;

/**
 * Provides a meta helper for Filament forms that groups SEO and Social fields.
 *
 * This class exposes a static make() method which configures and returns a Filament
 * Tabs component containing two tabs: "SEO" and "Social". Presentation options such
 * as contained layout, vertical orientation, and icon visibility can be controlled
 * via the method parameters.
 */
class Meta
{
    /**
     * Create and return an array containing a configured Tabs instance for SEO and Social fields.
     *
     * The returned array contains a single Tabs object configured with two tabs:
     * - "SEO": uses the SeoFields schema
     * - "Social": uses the SocialFields schema
     *
     * @param  string  $prefix  The prefix to use for field names within the SEO and Social schemas.
     * @param  bool  $contained  Whether the tabs should be contained within a box. Default is false.
     * @param  bool  $vertical  Whether the tabs should be displayed vertically. Default is false.
     * @param  bool  $show_icons  Whether to show icons on the tabs. Default is true.
     * @return array<int, \Filament\Schemas\Components\Tabs> Array containing the configured Tabs instance.
     */
    public static function make($prefix = 'meta', $contained = false, $vertical = false, $show_icons = true): array
    {
        return [
            Tabs::make()
                ->contained($contained)
                ->vertical($vertical)
                ->tabs([
                    Tabs\Tab::make('SEO')
                        ->icon($show_icons ? Heroicon::MagnifyingGlass : null)
                        ->schema(SeoFields::make($prefix)),
                    Tabs\Tab::make('Social')
                        ->icon($show_icons ? Heroicon::Share : null)
                        ->schema(SocialFields::make($prefix)),
                ]),
        ];
    }
}
