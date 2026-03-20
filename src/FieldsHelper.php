<?php

namespace Inerba\Seo;

use Illuminate\Support\HtmlString;

/**
 * Utility methods used by form fields.
 */
class FieldsHelper
{
    /**
     * Compute remaining characters for a text state and return a styled HtmlString.
     *
     * Counts characters using mb_strlen when available, computes how many
     * characters are left relative to the provided maximum, chooses a color
     * based on the remaining amount, and returns an HtmlString containing
     * the counter text styled with that color.
     */
    public static function remainingText(?string $state, int $maxCharacters = 60): HtmlString
    {
        $state = $state ?? '';
        $charactersCount = function_exists('mb_strlen') ? mb_strlen($state) : strlen($state);
        $leftCharacters = $maxCharacters - $charactersCount;
        $color = $leftCharacters < 0 ? 'red' : ($leftCharacters <= 10 ? 'green' : 'gray');

        return new HtmlString("<div style=\"color: {$color};\">$charactersCount / $maxCharacters ($leftCharacters)</div>");
    }
}
