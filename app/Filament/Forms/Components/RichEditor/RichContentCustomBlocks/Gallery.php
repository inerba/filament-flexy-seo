<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use App\Filament\Forms\Components\RichEditor\Common;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'gallery';
    }

    public static function getLabel(): string
    {
        return 'Gallery';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the gallery')
            ->closeModalByClickingAway(false)
            ->slideOver()
            ->modalWidth('5xl')
            ->fillForm(function (Model $record, array $arguments = []): array {
                $config = $arguments['config'] ?? [];
                $rand = $config['rand'] ?? Str::random(10);

                return [
                    'rand' => $rand,
                    // @phpstan-ignore method.notFound
                    'images' => $record->getMedia('rich-content-gallery'.$rand) ?? [],
                    'layout' => $config['layout'] ?? 'grid',
                    'columns' => $config['columns'] ?? 3,
                    'section_width' => $config['section_width'] ?? 'max-w-5xl',
                ];
            })
            ->schema([
                Hidden::make('rand'),
                SpatieMediaLibraryFileUpload::make('images')
                    ->collection(function (callable $get) {
                        return 'rich-content-gallery'.($get('rand') ?? '');
                    })
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->multiple()
                    ->panelLayout('grid')
                    ->reorderable()
                    ->columnSpanFull()
                    ->required(),
                Section::make('Layout')
                    ->columns(2)
                    ->description('Choose how the gallery is displayed')
                    ->schema([
                        Select::make('layout')
                            ->live()
                            ->options([
                                'grid' => 'Grid',
                                'carousel' => 'Carousel',
                            ])
                            ->required(),
                        Select::make('columns')
                            ->label('Columns')
                            ->options([
                                1 => '1 Columns',
                                2 => '2 Columns',
                                3 => '3 Columns',
                                4 => '4 Columns',
                                5 => '5 Columns',
                                6 => '6 Columns',
                            ])
                            // ->visible(fn (callable $get): bool => $get('layout') == 'grid')
                            ->required(),

                        ...Common\SectionWidth::make(),
                    ]),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {

        $images = [];

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.gallery.preview', [
            'images' => $images,
            'layout' => $config['layout'] ?? 'grid',
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {

        $config['layout'] = $config['layout'] ?? 'grid';
        $config['columns'] = $config['columns'] ?? 3;
        $config['rand'] = $config['rand'] ?? null;

        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.gallery.index',
            [
                'config' => $config,
                'model' => $data['model'] ?? null,
            ]
        )->render();
    }
}
