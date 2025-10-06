<div @class([
    'vertical-margin mx-auto',
    $config['section_width'] ?? 'max-w-full',
    'flex flex-col items-center' => $config['content_centered'] ?? false,
])>
    {{ $slot }}
</div>
