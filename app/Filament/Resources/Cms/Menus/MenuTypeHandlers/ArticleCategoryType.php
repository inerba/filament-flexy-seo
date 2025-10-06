<?php

namespace App\Filament\Resources\Cms\Menus\MenuTypeHandlers;

use App\Filament\Resources\Cms\Categories\CategoryResource;
use App\Filament\Resources\Cms\Menus\Traits\CommonFieldsTrait;
use App\Models\Cms\Category;
use Awcodes\Shout\Components\Shout;
use Filament\Actions\Action;
use Filament\Forms\Components;

class ArticleCategoryType implements MenuTypeInterface
{
    use CommonFieldsTrait;

    public function getName(): string
    {
        return 'Blog Categoria';
    }

    /**
     * @return array<int, mixed>
     */
    public static function getFields(): array
    {
        return [
            Components\Select::make('model_id')
                ->label('Categoria')
                ->options(fn () => Category::pluck('name', 'id')->toArray())
                ->required()
                ->dehydrated()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    if (! $state) {
                        return;
                    }

                    $category = Category::find($state);
                    if (! $category) {
                        return;
                    }

                    $set('url', $category->relativePermalink);

                    $titles = $category->getTranslations('name');

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

            Shout::make('so-important')
                ->color('info')
                ->content('Puoi gestire la configurazione della lista di articoli direttamente dalla pagina di modifica della categoria.')
                ->columnSpanFull()
                ->icon('heroicon-o-information-circle')->actions([
                    Action::make('modifica_categoria')
                        ->size('xs')
                        ->color('primary')
                        ->icon('heroicon-o-pencil')
                        ->iconPosition('after')
                        ->label('Modifica categoria')
                        ->url(fn (callable $get) => $get('model_id') ? CategoryResource::getUrl('edit', ['record' => $get('model_id')]) : null, true),
                ]),

            // Includi sempre i campi comuni per i link
            ...self::commonLinkFields(),
        ];
    }
}
