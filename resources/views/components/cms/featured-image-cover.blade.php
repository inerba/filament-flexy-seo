@props([
    'image_url' => false,
    'alt' => 'Featured Image',
    'fit' => true, // Adatta l'immagine alla larghezza del contenitore
])

<div class="container mx-auto vertical-margin">
    <img @class(['object-cover h-auto mx-auto', $fit ? 'w-full' : 'w-auto ']) src="{{ $image_url }}" alt="{{ $alt }}">
</div>

