<?php

namespace App\Filament\Resources\Cms;

use Illuminate\Support\Str;

trait HasTemplateTrait
{
    /**
     * Recupera i campi personalizzati per un template specifico
     *
     * Cerca una classe corrispondente al template nella directory
     * App\Filament\Resources\Cms\Pages\Templates o
     * App\Filament\Resources\Cms\Articles\Templates in base alla risorsa.
     * Se la classe esiste e ha un metodo 'fields', lo invoca per ottenere i campi.
     *
     * @param  string  $template  Nome del template
     * @param  string  $resource  Tipo di risorsa ('pages' o 'articles')
     * @return array Campi del modulo per il template specifico
     */
    protected static function getCustomTemplateFields($template, $resource = 'pages'): array
    {

        $resource = match ($resource) {
            'pages' => 'App\\Filament\\Resources\\Cms\\Pages\\Templates\\',
            'articles' => 'App\\Filament\\Resources\\Cms\\Articles\\Templates\\',
            default => null,
        };

        $class = $resource.Str::studly(str_replace(['-', '_'], ' ', $template));

        if (class_exists($class) && method_exists($class, 'fields')) {
            return $class::fields();
        }

        return [];
    }

    /**
     * Recupera i template disponibili dalla directory resources/views/cms/templates/pages
     *
     * Scansiona la cartella, filtra i file Blade (*.blade.php), costruisce una mappa
     * [templateName => Label leggibile] e la ordina alfabeticamente.
     *
     * @return array<string,string> Mappa nome_template => etichetta
     */
    protected static function getTemplateFields($resource = 'pages'): array
    {
        $templatePath = match ($resource) {
            'pages' => resource_path('views/cms/templates/pages'),
            'articles' => resource_path('views/cms/templates/articles'),
            default => null,
        };

        if (! is_dir($templatePath)) {
            return [];
        }

        $files = scandir($templatePath) ?: [];

        $fields = collect($files)
            ->filter(fn (string $file): bool => Str::endsWith($file, '.blade.php') && ! Str::endsWith($file, '_preview.blade.php'))
            ->mapWithKeys(function (string $file): array {
                $templateName = Str::before($file, '.blade.php');
                $label = Str::title(Str::replace(['-', '_'], ' ', $templateName));

                return [$templateName => $label];
            })
            ->sort()
            ->toArray();

        return $fields;
    }
}
