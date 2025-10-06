<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components\RichEditor\Macro;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\CodeBlock;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\Gallery;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\Video;
use Illuminate\Support\Facades\Auth;

class PageBlocks
{
    /**
     * Blocks configuration for RichContentRenderer.
     *
     * @param  array<string, mixed>  $data
     */
    public static function render(array $data): array
    {
        return [
            Gallery::class => [
                'model' => $data['model'] ?? null,
            ],
            CodeBlock::class,
            Video::class,
        ];
    }

    /**
     * List of available blocks for RichEditor.
     */
    public static function blocks(): array
    {

        // Uncomment to show/hide blocks based on user role
        // $isAdmin = ! Auth::user()->isAdmin();

        // return array_filter([
        //     Gallery::class,
        //     $isAdmin ? CodeBlock::class : null,
        //     Video::class,
        // ]);

        return [
            Gallery::class,
            CodeBlock::class,
            Video::class,
        ];
    }
}
