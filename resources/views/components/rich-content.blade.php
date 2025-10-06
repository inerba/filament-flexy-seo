{{-- @aware(['page', 'article']) --}}
@use('\Filament\Forms\Components\RichEditor\RichContentRenderer')
@use('\App\Filament\Forms\Components\RichEditor\Macro\PageBlocks')

@props([
    'model' => null,
    'content' => null,
])

@php
    $content = $content ?? ($model->content ?? null);
@endphp
@if ($content != null)
    <div {{ $attributes->merge(['class' => 'prose max-w-none']) }}>
        {!! RichContentRenderer::make($content)->customBlocks(PageBlocks::render(['model' => $model]))->toUnsafeHtml() !!}
    </div>
@else
    <div {{ $attributes->merge(['class' => 'italic text-gray-400']) }}>
        Nessun contenuto.
    </div>
@endif

