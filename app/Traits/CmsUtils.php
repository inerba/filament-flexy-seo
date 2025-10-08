<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CmsUtils
{
    protected static function getCustomFields($record): array
    {
        if (! $record) {
            return [];
        }

        $class = 'App\\Filament\\Resources\\Cms\\Pages\\CustomPages\\' . Str::studly(str_replace(['-', '_'], ' ', $record->slug));

        if (class_exists($class) && method_exists($class, 'fields')) {
            return $class::fields();
        }

        return [];
    }

    protected static function isMultilingual(): bool
    {
        return count(get_supported_locales()) > 1;
    }
}
