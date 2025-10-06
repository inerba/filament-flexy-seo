<?php

namespace App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks;

use App\Filament\Forms\Components\RichEditor\Common\SectionWidth;
use Filament\Actions\Action;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\CodeEditor\Enums\Language;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;
use Filament\Forms\Components\Toggle;

class CodeBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'code';
    }

    public static function getLabel(): string
    {
        return 'Code';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the code block')
            ->closeModalByClickingAway(false)
            ->slideOver()
            ->modalWidth('5xl')
            ->fillForm(function (array $arguments = []): array {
                $config = $arguments['config'] ?? [];

                return [
                    'section_width' => $config['section_width'] ?? 'max-w-5xl',
                    'code' => $config['code'] ?? null,
                    'content_centered' => $config['content_centered'] ?? true,
                ];
            })
            ->schema([
                CodeEditor::make('code')
                    ->label('Code')
                    ->language(Language::Html)
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('content_centered')
                    ->label('Forza centratura del contenuto')
                    ->columnSpanFull(),
                ...SectionWidth::make(),
            ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.code.preview',
            compact('config'),
        )->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('filament.forms.components.rich-editor.rich-content-custom-blocks.code.index',
            compact('config'),
        )->render();
    }
}
