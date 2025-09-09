@props([
    'title' => '',
    'description' => '',
    'robots' => 'index, follow',
    'og_title' => '',
    'og_description' => '',
    'image' => '',
    'url' => '',
    'type' => 'article',
    'published_time' => null,
    'modified_time' => null,
    'twitter_username' => config('flexy-seo.twitter_username', null),
    'fb_app_id' => config('flexy-seo.fb_app_id', null),
])

@php
    $og_title = $og_title ?: $title;
    $og_description = $og_description ?: $description;
    $url = $url ?: url()->current();
    $robots = $robots ?: 'index, follow';
    $twitter_username = $twitter_username ? (str_starts_with($twitter_username, '@') ? $twitter_username : '@' . $twitter_username) : null;
    $fb_app_id = $fb_app_id ?: null;
@endphp

{{-- Meta --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}" />
<link rel="canonical" href="{{ $url }}" />

@if ($image)
    <meta name="robots" content="{{ $robots }}, max-image-preview:large" />
@else
    <meta name="robots" content="{{ $robots }}" />
@endif

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:locale" content="{{ app()->getLocale() }}" />
<meta property="og:title" content="{{ $og_title }}" />
<meta property="og:description" content="{{ $og_description }}" />

@if ($image)
    <meta property="og:image" content="{{ $image }}" />
    <meta property="og:image:secure_url" content="{{ $image }}" />
@endif

<meta property="og:url" content="{{ $url }}" />
<meta property="og:type" content="{{ $type }}" />

@if ($published_time && $modified_time)
    <meta property="article:published_time" content="{{ $published_time instanceof \Carbon\Carbon ? $published_time->toIso8601String() : \Carbon\Carbon::parse($published_time)->toIso8601String() }}" />
    <meta property="article:modified_time" content="{{ $modified_time instanceof \Carbon\Carbon ? $modified_time->toIso8601String() : \Carbon\Carbon::parse($modified_time)->toIso8601String() }}" />
@endif

@if ($fb_app_id)
    <meta property="fb:app_id" content="{{ $fb_app_id }}" />
@endif

{{-- Twitter --}}
@if ($twitter_username)
    <meta name="twitter:site" content="{{ $twitter_username }}" />
    <meta name="twitter:creator" content="{{ $twitter_username }}" />
@endif

<meta name="twitter:title" content="{{ $og_title }}" />
<meta name="twitter:description" content="{{ $og_description }}" />

@if ($image)
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image" content="{{ $image }}" />
@endif
