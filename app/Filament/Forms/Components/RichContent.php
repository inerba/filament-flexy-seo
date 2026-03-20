<?php

namespace App\Filament\Forms\Components;

use App\Filament\Actions\CleanHtmlAction;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\Gallery;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;

class RichContent extends RichEditor
{
    public static function make(?string $name = null): static
    {
        $instance = parent::make($name);

        $instance->toolbarButtons([
            ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
            ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
            ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
            ['table', 'attachFiles'],
            ['undo', 'redo', 'clearFormatting'],
            ['grid', 'textColor', 'fullscreen'],
        ])
            ->live(true)
            ->fileAttachmentsDisk('public')
            ->fileAttachmentsDirectory('attachments')
            ->fileAttachmentsVisibility('public')
            // ->afterLabel([
            //     CleanHtmlAction::make(),
            // ])
            ->belowContent([
                Action::make('copy_content')
                    ->hidden(function ($component, callable $get) {
                        return get_component_locale($component) == config('app.locale') || is_rich_editor_empty($get('content.'.config('app.locale')));
                    })
                    ->label('Duplica contenuto dalla lingua principale')
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation(fn (callable $get, $component): bool => ! is_rich_editor_empty($get('content.'.get_component_locale($component))))
                    ->modalDescription(fn (callable $get, $component): string|false => ! is_rich_editor_empty($get('content.'.get_component_locale($component))) ? 'Questa operazione sovrascriverà il contenuto esistente.' : false)
                    ->action(function (callable $set, callable $get, $component) {
                        $component_locale = get_component_locale($component);
                        $set("content.$component_locale", $get('content.'.config('app.locale')));
                    }),
            ])
            // ->customBlocks([
            //     Gallery::class,
            // ])
            // ->mergeTags([
            //     'today' => now()->toFormattedDateString(),
            // ])
            // ->mergeTagLabels([
            //     'name' => 'Full name',
            //     'today' => 'Today\'s date',
            // ])
            // ->textColors([
            //     'brand' => TextColor::make('Brand', '#0ea5e9', darkColor: '#38bdf8'),
            // ])
            // ->customTextColors()
            ->json();

        return $instance;
    }
}
