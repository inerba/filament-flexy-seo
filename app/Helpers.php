<?php

use Filament\Forms\Components\Field;
use Filament\Support\Components\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Helpers per il menù
 */
if (! function_exists('active_route')) {

    /**
     * Controlla se la rotta corrente corrisponde a quella specificata.
     *
     * @param  string  $route  La rotta da verificare.
     * @param  bool  $active  Valore da restituire se la rotta è attiva.
     * @param  bool  $default  Valore da restituire se la rotta non è attiva.
     * @return bool Il valore attivo o predefinito in base alla corrispondenza della rotta.
     */
    function active_route(string $route, $active = true, $default = false)
    {
        $current = (string) str(url()->current())->remove(config('app.url'))->trim('/');
        $route = (string) str($route)->trim('/');

        if ($current === $route) {
            return $active;
        }

        return $default;
    }
}

if (! function_exists('is_panel_auth_route')) {
    function is_panel_auth_route(): bool
    {
        $authRoutes = [
            '/login',
            '/password-reset',
            '/register',
            '/email-verification',
        ];

        return Str::of(Request::path())->contains($authRoutes);
    }
}

if (! function_exists('removeEmptyValues')) {
    /**
     * Rimuove i valori vuoti da un array, mantenendo 0 e '0' come validi.
     *
     * @param  array<mixed>  $array  L'array da filtrare.
     * @return array<mixed> L'array filtrato senza valori vuoti.
     */
    function removeEmptyValues(array $array): array
    {
        // Applica array_map per garantire la ricorsività su tutti gli elementi
        return array_filter(array_map(function ($value) {
            return is_array($value) ? removeEmptyValues($value) : $value;
        }, $array), function ($value) {
            // Filtra valori vuoti mantenendo 0 e '0' come validi
            return ! empty($value) || $value === 0 || $value === '0';
        });
    }
}

/**
 * Helper per la pagina
 */
if (! function_exists('page_url')) {
    /**
     * Get the permalink of a page by its ID or slug.
     * Defaults to relative url.
     *
     * @param  int|string  $identifier  The post ID or slug
     * @param  bool  $absolute  Whether to return the absolute url
     */
    function page_url(int|string $identifier, bool $absolute = false): string
    {
        if ($absolute) {
            $key = "page_url.$identifier.absolute";
        } else {
            $key = "page_url.$identifier";
        }

        return Cache::remember(
            $key,
            config('cms.cache.default_duration'),
            function () use ($identifier, $absolute) {
                if (is_int($identifier)) {
                    $page = App\Models\Cms\Page::find($identifier);
                } else {
                    $page = App\Models\Cms\Page::where('slug', $identifier)->first();
                }

                if ($absolute) {
                    return $page?->permalink;
                } else {
                    return $page?->relative_permalink;
                }
            }
        ) ?? '';
    }
}

if (! function_exists('get_supported_locales')) {
    /**
     * Recupera l'elenco delle lingue supportate dall'applicazione.
     *
     * @return array<string> L'elenco delle lingue supportate
     */
    function get_supported_locales(): array
    {
        return array_keys(config('laravellocalization.supportedLocales', [config('app.locale')]));
    }
}

if (! function_exists('locale')) {
    /**
     * Recupera la lingua corrente dell'applicazione.
     */
    function locale(): string
    {
        return LaravelLocalization::getCurrentLocale();
    }
}

if (! function_exists('get_component_locale')) {
    /**
     * Recupera la lingua corrente del Form Component filament.
     *
     * @return string La lingua del componente es. 'it', 'en', etc.
     *
     * @throws InvalidArgumentException Se la lingua non è supportata.
     */
    function get_component_locale(Field|Component $component): string
    {
        // Ottieni l'ID del componente
        $id = $component->getId();

        // Dividi l'ID in parti usando il punto come separatore
        $parts = explode('.', $id);

        // Prendi l'ultima parte dell'ID, che dovrebbe essere la lingua
        $lang = end($parts);

        // Se la lingua non è valida, restituisci un errore
        if (! in_array($lang, get_supported_locales())) {
            throw new InvalidArgumentException("Lingua non supportata: $lang");
        }

        // Restituisci la lingua
        return $lang;
    }
}

if (! function_exists('localized')) {
    /**
     * Restituisce il valore localizzato di una chiave.
     *
     * @param  array<string, string>  $key  Un array associativo con le chiavi localizzate.
     * @return array<string, string>|string
     *
     * @phpstan-ignore return.unusedType
     */
    function localized(array $key): array|string|null
    {
        return $key[locale()] ?? null;
    }
}

if (! function_exists('is_rich_editor_empty')) {
    /**
     * Controlla se il contenuto di un RichEditor è vuoto.
     *
     * @param  array<string, mixed>  $content  Il contenuto del RichEditor in formato array.
     * @return bool True se il contenuto è vuoto, false altrimenti.
     */
    function is_rich_editor_empty(?array $content): bool
    {
        if (blank($content)) {
            return true;
        }

        // Ottieni il contenuto da analizzare
        $items = data_get($content, 'content', $content);

        return collect($items)
            ->pipe(fn ($collection) => flatten_rich_editor_content($collection))
            ->filter(fn ($item) => filled(trim(data_get($item, 'text', ''))))
            ->isEmpty();
    }
}

if (! function_exists('flatten_rich_editor_content')) {
    /**
     * Appiattisce ricorsivamente il contenuto di un RichEditor.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @return \Illuminate\Support\Collection
     */
    function flatten_rich_editor_content($items)
    {
        return collect($items)->flatMap(function ($item) {
            $flattened = collect([$item]);

            if (filled(data_get($item, 'content'))) {
                $flattened = $flattened->merge(
                    flatten_rich_editor_content(data_get($item, 'content'))
                );
            }

            return $flattened;
        });
    }
}

if (! function_exists('rich_editor_excerpt')) {
    /**
     * Genera un estratto da un campo "RichEditor" (array di blocchi), limitando solo i caratteri.
     * Questo metodo estrae il testo da tutti i nodi di tipo "paragraph", concatena i testi e li limita alla dimensione desiderata.
     *
     * @param  array<string, mixed>  $content
     * @param  int  $maxChars  numero massimo di caratteri da includere nell'estratto
     * @return string Il riassunto del testo generato dai blocchi, limitato a $maxChars caratteri.
     */
    function rich_editor_excerpt(array $content, int $maxChars = 300): string
    {
        /** @var array<int, array<string, mixed>> $blocks */
        $blocks = Arr::get($content, 'content', []);

        if (empty($blocks)) {
            return '';
        }

        $text = collect($blocks)
            ->filter(fn ($block) => Arr::get($block, 'type') === 'paragraph')
            ->flatMap(function ($paragraph) {
                $paragraphContent = Arr::get($paragraph, 'content', []);

                return collect($paragraphContent)
                    ->filter(fn ($item) => Arr::get($item, 'type') === 'text')
                    ->pluck('text');
            })
            ->implode(' ');

        $cleanText = trim(preg_replace('/\s+/', ' ', $text));

        return Str::limit($cleanText, $maxChars, '');
    }
}

if (! function_exists('format_money')) {
    function format_money($value, $currency = 'EUR', $locale = 'it_IT'): string
    {
        return \Illuminate\Support\Number::currency($value, $currency, $locale);
    }
}

if (! function_exists('localize_url')) {

    function localize_url(string $url): string
    {
        if (count(get_supported_locales()) == 1) {
            return $url[app()->getLocale()] ?? $url;
        }

        return LaravelLocalization::localizeURL($url);
    }
}

if (! function_exists('is_multilingual')) {

    function is_multilingual(): bool
    {
        return count(get_supported_locales()) > 1;
    }
}
