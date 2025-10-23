@props([
    'title' => '',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- SEO --}}
    {{ $seo ?? '' }}

    {{-- canonical --}}
    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="apple-touch-icon" sizes="57x57" href="/images/appicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/appicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/appicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/appicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/appicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/appicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/appicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/appicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/appicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/appicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/appicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/appicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/appicons/favicon-16x16.png">
    <link rel="manifest" href="/images/appicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/appicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    {{-- Open Graph --}}
    @yield('og')

    @livewireStyles

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')
    @stack('header_scripts')
</head>

<body class="relative flex min-h-screen flex-col font-sans antialiased">
    <x-partials.header />
    <main class="flex-1">
        {!! $slot !!}
    </main>
    <x-partials.footer />
    @livewireScripts
    @stack('scripts')
</body>

</html>

