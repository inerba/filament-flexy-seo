<?php

if (! function_exists('rich_content_excerpt')) {
    /**
     * Extracts a plain text excerpt from rich content.
     *
     * @param  string|array<mixed, mixed>  $content  The rich content array.
     * @param  int  $limit  The maximum length of the excerpt.
     * @param  string|null  $end  The string to append if the content is truncated.
     * @param  bool  $preserveWords  Whether to preserve whole words when truncating.
     * @return string The generated excerpt.
     */
    function rich_content_excerpt(array | string $content, $limit = 300, ?string $end = '...', bool $preserveWords = false): string
    {
        $contentText = \Filament\Forms\Components\RichEditor\RichContentRenderer::make($content)->toText();

        return \Illuminate\Support\Str::of($contentText)
            ->squish()
            ->limit(
                limit: $limit,
                end: $end,
                preserveWords: $preserveWords
            )
            ->toString();
    }
}

if (! function_exists('fs_tag')) {
    /**
     * Retrieves the tag from the meta array.
     *
     * @param  array<string, mixed>  $meta  The meta array.
     * @param  string  $default  The default value to return if not set.
     * @return string The tag or the default value if not set.
     */
    function fs_tag(array $meta, string $tag, string $default = '', ?string $locale = null): string
    {
        // If the tag key doesn't exist return default early
        if (! array_key_exists($tag, $meta)) {
            return $default;
        }

        $value = $meta[$tag];

        // If value is an array we may have localized values
        if (is_array($value)) {
            if ($locale !== null && array_key_exists($locale, $value)) {
                return (string) ($value[$locale] ?? $default);
            }

            // No locale given or locale not present: try to return the first non-empty string
            foreach ($value as $maybe) {
                if ($maybe !== null && $maybe !== '') {
                    return (string) $maybe;
                }
            }

            return $default;
        }

        // Otherwise cast scalar values to string and return
        if (is_scalar($value) || $value instanceof \Stringable) {
            return (string) $value;
        }

        return $default;
    }
}

if (! function_exists('fs_tag_title')) {
    /**
     * Retrieves the tag title from the meta array.
     *
     * @param  array<string, mixed>  $meta  The meta array.
     * @param  string  $default  The default value to return if not set.
     * @return string The tag title or the default value if not set.
     */
    function fs_tag_title(array $meta, string $default = '', ?string $locale = null): string
    {
        return fs_tag($meta, 'tag_title', $default, $locale);
    }
}

if (! function_exists('fs_meta_description')) {
    /**
     * Retrieves the meta description from the meta array.
     *
     * @param  array<string, mixed>  $meta  The meta array.
     * @param  string  $default  The default value to return if not set.
     * @return string The meta description or the default value if not set.
     */
    function fs_meta_description(array $meta, string $default = '', ?string $locale = null): string
    {
        return fs_tag($meta, 'meta_description', $default, $locale);
    }
}

if (! function_exists('fs_og_title')) {
    /**
     * Retrieves the Open Graph title from the meta array.
     *
     * @param  array<string, mixed>  $meta  The meta array.
     * @param  string  $default  The default value to return if not set.
     * @return string The meta description or the default value if not set.
     */
    function fs_og_title(array $meta, string $default = '', ?string $locale = null): string
    {
        return fs_tag($meta, 'og_title', $default, $locale);
    }
}

if (! function_exists('fs_og_description')) {
    /**
     * Retrieves the Open Graph description from the meta array.
     *
     * @param  array<string, mixed>  $meta  The meta array.
     * @param  string  $default  The default value to return if not set.
     * @return string The Open Graph description or the default value if not set.
     */
    function fs_og_description(array $meta, string $default = '', ?string $locale = null): string
    {
        return fs_tag($meta, 'og_description', $default, $locale);
    }
}
