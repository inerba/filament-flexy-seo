<?php

declare(strict_types=1);

return [

    'timezone' => 'Europe/Rome', // Default timezone for date and datetime pickers

    // Cache
    'cache' => [
        // Default cache duration in minutes
        'default_duration' => 60 * 24 * 7, // 7 days
    ],

    'middleware' => [
        'web',
    ],

    // Prefix for articles index
    'articles_route_prefix' => 'news',

    // Blog settings
    'articles_blog_settings' => [
        'articles_per_page' => 6,
    ],

    'media' => [
        'disk' => 'public',
        'format' => 'jpg', // jpg, png, webp
        'quality' => 80, // 0-100

        // Usa Spatie Laravel-medialibrary per le conversioni delle immagini,
        // per rigenerarle in massa usa il comando php artisan media-library:regenerate
        // commenta le conversioni che non ti servono
        'conversions' => [ // max width in pixels
            //  'xl' => 1920,
            'lg' => 1280,
            'md' => 400,
            'sm' => 200,
            //  'xs' => 100,
        ],
    ],

    // Defaults for Seo and Social
    'seo' => [
        'author' => null,
    ],

    'og' => [
        'type' => 'article',
        'locale' => 'it_IT',
        'site_name' => null,
        'twitter_username' => null, // @username
        'fb_app_id' => 169565392540441, // Facebook App ID
    ],

    // if not set, AI will be disabled
    'openai_api_key' => env('OPENAI_API_KEY'),

    // Default OpenAI Model (refer to https://platform.openai.com/docs/models)
    'default_openai_model' => 'gpt-4o-mini',

    // SEO Prompt
    'seo_prompt' => 'Dato il seguente post del blog in formato JSON, genera un title e una meta description ottimizzati per SEO. Il title non deve superare i 60 caratteri. La meta description deve essere compatta e persuasiva, con una lunghezza compresa tra 150 e 160 caratteri.',
    'seo_tag_title' => 'Genera un title ottimizzato per SEO, non superiore a 60 caratteri.',
    'seo_meta_description' => 'Genera una meta description ottimizzata per SEO, compatta e persuasiva, con una lunghezza compresa tra 150 e 160 caratteri.',

    'default_user' => [
        'name' => env('DEFAULT_USER_NAME', 'John Doe'),
        'email' => env('DEFAULT_USER_EMAIL', 'admin@example.com'),
        'password' => env('DEFAULT_USER_PASSWORD', 'password'),
    ],

    'menu_manager' => [
        // Resource configuration
        'navigation_group' => 'Impostazioni',
        'navigation_sort' => 1,
        'model_label' => 'Menu',
        'plural_model_label' => 'Menu',

        // Menu Model
        'model' => App\Models\Cms\Menu::class,

        /**
         * Mappa dei tipi di menu verso le classi handler corrispondenti.
         * Le chiavi rappresentano l'identificatore del tipo e i valori
         * sono le classi che implementano MenuTypeInterface.
         */
        'handlers' => [
            'link' => App\Filament\Resources\Cms\Menus\MenuTypeHandlers\LinkType::class,
            'page' => App\Filament\Resources\Cms\Menus\MenuTypeHandlers\PageType::class,
            'article_category' => App\Filament\Resources\Cms\Menus\MenuTypeHandlers\ArticleCategoryType::class,
            'placeholder' => App\Filament\Resources\Cms\Menus\MenuTypeHandlers\PlaceholderType::class,
        ],

        // Livewire component
        'menu_cache' => 1, // Cache time in seconds, each menu has its own cache
    ],
];
