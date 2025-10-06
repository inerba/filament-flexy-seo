@props([
    'image_url' => false,
    'alt' => 'Featured Image',
])

<div class="container mx-auto vertical-margin">
    <img class="object-cover w-auto h-auto mx-auto" src="{{ $image_url }}" alt="{{ $alt }}">
</div>
