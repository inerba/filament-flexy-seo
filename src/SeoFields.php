<?php

namespace Inerba\Seo;

use Filament\Forms;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Illuminate\Support\HtmlString;

/**
 * Factory for Filament schema components used for SEO fields.
 *
 * Builds and returns an array of Filament form components used to edit
 * SEO metadata such as tag title, meta description and robots selection.
 * Can optionally include a configurable suggestions section.
 */
class SeoFields
{
    /**
     * Build the schema components array for general SEO fields.
     *
     * Returns an indexed array containing TextInput and Select components for
     * editing SEO-related metadata. When enabled via configuration, an extra
     * Section with guidance content is appended.
     *
     * @return array<int, \Filament\Forms\Components\TextInput|\Filament\Forms\Components\Select|\Filament\Schemas\Components\Section> Indexed array of Filament form and schema components.
     */
    public static function make($prefix): array
    {
        $fields = [
            Forms\Components\TextInput::make($prefix . '.tag_title')
                ->hint(fn ($state): HtmlString => FieldsHelper::remainingText($state, config('flexy-seo.tag-title-max-length', 60)))
                ->live(false, 500)
                ->label(__('flexy-seo::flexy-seo.seo.tag-title'))
                ->helperText(__('flexy-seo::flexy-seo.seo.tag-title-helper'))
                ->columnSpanFull(),
            Forms\Components\TextInput::make($prefix . '.meta_description')
                ->hint(fn ($state): HtmlString => FieldsHelper::remainingText($state, config('flexy-seo.meta-description-max-length', 160)))
                ->live(false, 500)
                ->label(__('flexy-seo::flexy-seo.seo.meta-description'))
                ->helperText(__('flexy-seo::flexy-seo.seo.meta-description-helper'))
                ->columnSpanFull(),
            Forms\Components\Select::make($prefix . '.robots')
                ->label(__('flexy-seo::flexy-seo.seo.robots'))
                ->options([
                    'index, follow' => __('flexy-seo::flexy-seo.seo.robots_option_index_follow'),
                    'no index, follow' => __('flexy-seo::flexy-seo.seo.robots_option_noindex_follow'),
                    'index, no follow' => __('flexy-seo::flexy-seo.seo.robots_option_index_nofollow'),
                    'no index, no follow' => __('flexy-seo::flexy-seo.seo.robots_option_noindex_nofollow'),
                ])
                ->selectablePlaceholder(false)
                ->helperText(__('flexy-seo::flexy-seo.seo.robots_helper')),
        ];

        // Add suggestions section if enabled in config
        if ((bool) config('flexy-seo.show-suggestions')) {
            $fields[] = Section::make(__('flexy-seo::flexy-seo.seo.section_title'))
                ->icon('heroicon-o-information-circle')
                ->iconColor('info')
                ->description(__('flexy-seo::flexy-seo.seo.section_description'))
                ->schema([
                    Flex::make([
                        Text::make(new HtmlString(trans('flexy-seo::flexy-seo.seo.how_to_title_html'))),
                        Text::make(new HtmlString(trans('flexy-seo::flexy-seo.seo.how_to_meta_description_html'))),
                    ])->from('md'),
                ])
                ->collapsible()
                ->collapsed();
        }

        return $fields;
    }
}
