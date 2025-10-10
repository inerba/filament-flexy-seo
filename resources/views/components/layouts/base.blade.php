@props([
    'title' => null,
    'dir' => 'ltr',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}" class="">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{ $seo ?? '' }}

    <!-- Aggiungi i link per le Google Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet"> --}}

    <style>
        [x-cloak=""],
        [x-cloak="x-cloak"],
        [x-cloak="1"] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('style')

    @livewireStyles

</head>

<body class="overflow-x-hidden dark:bg-slate-900">

    <x-partials.header />

    @stack('header')

    @stack('mainTop')

    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

    @stack('mainBottom')

    <x-partials.footer />

    @livewireScripts

    @stack('scripts')

</body>

</html>

