<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use App\Filament\Forms\Components\RichEditor\Common;
use Awcodes\Matinee\Matinee;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Illuminate\Database\Eloquent\Model;

class Video extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'video';
    }

    public static function getLabel(): string
    {
        return 'Video';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the video')
            ->slideOver()
            ->closeModalByClickingAway(false)
            ->modalWidth('5xl')
            ->fillForm(function (Model $record, array $arguments = []): array {
                $config = $arguments['config'] ?? [];

                return [
                    'video' => $config['video'] ?? null,
                    'section_width' => $config['section_width'] ?? 'max-w-5xl',
                ];
            })
            ->schema([
                Matinee::make('video')
                    ->hiddenLabel()
                    ->showPreview()
                    ->required(),
                ...Common\SectionWidth::make(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.video.preview', [
            'video' => $config['video'] ?? null,
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.video.index', [
            'video' => $config['video'] ?? null,
            'config' => $config,
        ])->render();
    }
}
