<?php

namespace App\Filament\Resources\Cms\Menus\MenuTypeHandlers;

use App\Filament\Resources\Cms\Menus\Traits\CommonFieldsTrait;
use App\Models\Cms\Page;
use Filament\Forms\Components;

// use Z3d0X\FilamentFabricator\Facades\FilamentFabricator;

class PageType implements MenuTypeInterface
{
    use CommonFieldsTrait;

    public function getName(): string
    {
        return __('menu-manager.handlers.page.name');
    }

    /**
     * @return array<int, mixed>
     */
    public static function getFields(): array
    {
        return [
            Components\Select::make('model_id')
                ->label('Pagina')
                ->options(fn () => Page::pluck('title', 'id')->toArray())
                ->required()
                ->dehydrated()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    if (! $state) {
                        return;
                    }

                    $page = Page::find($state);
                    if (! $page) {
                        return;
                    }

                    $set('url', $page->relativePermalink);

                    $titles = Page::find($state)->getTranslations('title');

                    foreach ($titles as $locale => $title) {
                        $set("title.{$locale}", $title);
                    }
                })
                ->columnSpanFull(),
            Components\TextInput::make('url')
                ->readOnly()
                ->label('URL')
                ->hidden(fn (callable $get) => $get('model_id') == null)
                ->required()
                ->columnSpanFull(),
            // Includi sempre i campi comuni per i link
            ...self::commonLinkFields(),
        ];
    }
}
