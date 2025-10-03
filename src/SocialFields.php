<?php

namespace Inerba\Seo;

use Filament\Forms;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Illuminate\Support\HtmlString;

/**
 * Factory for Filament schema components related to social/Open Graph fields.
 *
 * Builds and returns an array of Filament schema components used to edit
 * social metadata (title, description, and image). Supports Spatie Media
 * Library or native file upload and can optionally include a configurable
 * suggestions section.
 */
class SocialFields
{
    /**
     * Build the schema components array for Open Graph fields.
     *
     * Returns an indexed array of Filament schema components including the main
     * Flex block with title, description and image upload fields. If enabled via
     * configuration, includes an additional Section with suggestions.
     *
     * @return array<int, \Filament\Schemas\Components\Flex|\Filament\Schemas\Components\Section> Indexed array of Filament schema components.
     */
    public static function make($prefix, $directory = 'og-images', bool $useMediaLibrary = false): array
    {
        $fields = [
            Flex::make([
                Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make($prefix . '.og_title')
                            ->hint(fn ($state): HtmlString => FieldsHelper::remainingText($state, config('flexy-seo.og-title-max-length', 60)))
                            ->live()
                            ->label(__('flexy-seo::flexy-seo.social.title'))
                            ->helperText(__('flexy-seo::flexy-seo.social.title_helper'))
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make($prefix . '.og_description')
                            ->hint(fn ($state): HtmlString => FieldsHelper::remainingText($state, config('flexy-seo.og-description-max-length', 200)))
                            ->live()
                            ->label(__('flexy-seo::flexy-seo.social.description'))
                            ->helperText(__('flexy-seo::flexy-seo.social.description_helper'))
                            ->columnSpanFull(),

                    ]),
                ...(
                    $useMediaLibrary ? [
                        // usa upload normale se true, altrimenti usa il file upload di Spatie
                        Forms\Components\SpatieMediaLibraryFileUpload::make('og_image')
                            ->label(__('flexy-seo::flexy-seo.social.image'))
                            ->helperText(__('flexy-seo::flexy-seo.social.image_helper'))
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->openable()
                            ->image()
                            ->collection('og_image'),
                    ] : [
                        Forms\Components\FileUpload::make($prefix . '.og_image')
                            ->label(__('flexy-seo::flexy-seo.social.image'))
                            ->helperText(__('flexy-seo::flexy-seo.social.image_helper'))
                            ->directory($directory)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->openable()
                            ->image()
                            ->columnSpanFull(),
                    ]
                ),
            ])->from('md'),
            Forms\Components\TextInput::make($prefix . '.og_title')
                ->hint(fn ($state): HtmlString => FieldsHelper::remainingText($state, config('flexy-seo.og-title-max-length', 60)))
                ->live()
                ->label(__('flexy-seo::flexy-seo.social.title'))
                ->helperText(__('flexy-seo::flexy-seo.social.title_helper'))
                ->columnSpanFull(),
            Forms\Components\Textarea::make($prefix . '.og_description')
                ->hint(fn ($state): HtmlString => FieldsHelper::remainingText($state, config('flexy-seo.og-description-max-length', 200)))
                ->live()
                ->label(__('flexy-seo::flexy-seo.social.description'))
                ->helperText(__('flexy-seo::flexy-seo.social.description_helper'))
                ->columnSpanFull(),
            ...(
                $useMediaLibrary ? [
                    // usa upload normale se true, altrimenti usa il file upload di Spatie
                    Forms\Components\SpatieMediaLibraryFileUpload::make('og_image')
                        ->label(__('flexy-seo::flexy-seo.social.image'))
                        ->helperText(__('flexy-seo::flexy-seo.social.image_helper'))
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            null,
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->openable()
                        ->image()
                        ->collection('og_image'),
                ] : [
                    Forms\Components\FileUpload::make($prefix . '.og_image')
                        ->label(__('flexy-seo::flexy-seo.social.image'))
                        ->helperText(__('flexy-seo::flexy-seo.social.image_helper'))
                        ->directory($directory)
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            null,
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->openable()
                        ->image()
                        ->columnSpanFull(),
                ]
            ),
        ];

        // Add suggestions section if enabled in config, not compatible with some translation packages
        if ((bool) config('flexy-seo.show-suggestions')) {
            $fields[] = Section::make(__('flexy-seo::flexy-seo.social.section_title'))
                ->icon('heroicon-o-information-circle')
                ->iconColor('info')
                ->description(__('flexy-seo::flexy-seo.social.section_description'))
                ->schema([
                    Flex::make([
                        Text::make(new HtmlString(trans('flexy-seo::flexy-seo.social.how_to_title_html'))),
                        Text::make(new HtmlString(trans('flexy-seo::flexy-seo.social.how_to_description_html'))),
                    ])->from('md'),
                ])
                ->collapsible()
                ->collapsed();
        }

        return $fields;
    }
}
