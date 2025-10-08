# Completissimo

Uno starter kit cms multilingua basato su Laravel 12 e Filament 4

## internazionalizzazione
Il kit usa [Laravel Localization](https://github.com/mcamara/laravel-localization) per gestire le traduzioni e le lingue.
abilita le lingue che vuoi usare in `config/laravellocalization.php` nella sezione `supportedLocales`.

## Viste personalizzate per le pagine (custom views)

Il CMS supporta viste Blade personalizzate per singole pagine. La logica è la seguente:

- Il modello `App\Models\Cms\Page` espone il metodo `getViewName()` che restituisce il nome della vista da renderizzare per quella pagina.
- Se esiste una vista con nome `pages.{slug}` (es. `resources/views/pages/about.blade.php`), questa verrà usata.
- Altrimenti viene usata la vista di default `cms.pages.page`.

Dettagli pratici:

- Posiziona la vista personalizzata in `resources/views/pages/{slug}.blade.php`.
- Per pagine annidate (es. percorso `azienda/team`) la vista personalizzata controlla solo lo slug della pagina corrente: se lo slug della pagina figlia è `team`, crea `resources/views/pages/team.blade.php`.
- Il controller `App\Http\Controllers\Cms\PageController` passa sempre la variabile `$page` alla vista, quindi all'interno del template puoi usare `$page->title`, `$page->content`, `$page->meta`, ecc.

Esempio minimo di template Blade:

```blade
@extends('layouts.app')

@section('content')
    <h1>{{ $page->title }}</h1>
    {{-- Se il contenuto è un array tradotto con chiave 'body' --}}
    {!! $page->content['body'] ?? '' !!}
@endsection
```

Note:

- La generazione dei permalink usa la route nominata `cms.page` con lo slug completo (ad esempio `parent/child`) generata dal modello (`$page->permalink` / `$page->relativePermalink`). Assicurati che la route esista nelle tue `routes/web.php`.
- Se non vedi cambiamenti nella UI dopo aver aggiunto una view, potrebbe essere necessario ricostruire gli assets (`npm run dev` / `npm run build`) o svuotare eventuali cache delle view (`php artisan view:clear`).

## Campi extra (Custom fields)

Il CMS supporta campi extra specifici per singole pagine tramite una convenzione a livello di classe Filament. Questo sistema permette di estendere il form della pagina (nella tab "Campi extra") senza toccare il form generale.

Come funziona

- Per creare campi extra per una pagina con slug ad esempio "chi-siamo", crea la classe:

  `App\Filament\Resources\Cms\Pages\CustomPages\ChiSiamo`

  con un metodo statico `fields()` che ritorna un array di componenti Filament (es. `TextInput`, `Select`, ecc).

- Il trait `App\Traits\CmsUtils` cerca automaticamente la classe corretta usando lo slug della pagina (trasformato in StudlyCase) e, se esiste e define `fields()`, la tab "Campi extra" mostrerà quei campi nel form di Filament.

Esempio minimo (già presente nel progetto)

```php
// App\Filament\Resources\Cms\Pages\CustomPages\ChiSiamo.php
class ChiSiamo
{
    public static function fields(): array
    {
        return [
            TextInput::make('extras.test')->label('Testo extra')->required(),
        ];
    }
}
```

Come vengono salvati i valori

- I campi dovrebbero usare come nome il prefisso `extras.` (es. `extras.test`) in modo che i valori vengano salvati dentro la colonna JSON `extras` del modello Page.
- Alcuni valori predefiniti usati dal form:
  - `featured_images` (Spatie Media collection) => collezione media 'featured_images'
  - `extras.show_featured_image` (bool) => mostra l'immagine nella testata
  - `extras.content_settings.dropcap` (bool) => impostazione del drop cap per il contenuto

Accesso ai valori in Blade

- Per leggere un valore semplice dagli extras:

  ```blade
  {{ $page->extras['test'] ?? null }}
  ```

- Per controllare il dropcap:

  ```blade
  @if(data_get($page->extras, 'content_settings.dropcap'))
      {{-- applica stile per drop cap --}}
  @endif
  ```

- Per la media:

  ```blade
  @if($page->hasFeaturedImages())
      <img src="{{ $page->getFirstMediaUrl('featured_images') }}" alt="{{ $page->title }}">
  @endif
  ```

Comportamento della tab "Campi extra" nel form di Filament

- La tab è visibile solo quando esiste un record (edit) e quando `CmsUtils::getCustomFields($record)` ritorna un array non vuoto.
- Le classi custom devono restituire componenti Filament validi; i nomi degli input determinano dove vengono salvati i dati (usare `extras.` per il JSON extras).

Multilingua

- Se la pagina è multilingua, i campi translatabili (es. label o campi che usano `translatableTabs` nel form) devono essere dichiarati coerentemente. Il form usa una utilità `isMultilingual()` per mostrare o nascondere le tab di traduzione.
- Se tecnicamente i tuoi campi devono essere tradotti, salva struttura e valore in modo coerente (ad es. array per lingua dentro extras o utilizzare campi translatable separati).

Note operative

- Se non vedi i campi nel pannello di amministrazione:
  - Verifica slug e nome della classe (StudlyCase).
  - Svuota cache config/view se necessario (`php artisan view:clear`).
- Se aggiungi nuove view o assets, potresti dover ricostruire gli asset (`npm run dev` / `npm run build`) come indicato altrove nel README.

# installazione

Clona il repository (con depth=1 per velocizzare).
Rimuove la cartella .git ed inizializza un nuovo repository locale (per adattare il progetto al nuovo sito).

```bash
git clone --depth=1 git@github.com:inerba/tailorcms.git nuovosito
cd nuovosito
rm -rf .git

git init
```

`composer setup`

poi

`php artisan shield:super`


# supervisor

Esempio di configurazione di Supervisor per gestire i worker delle code di Laravel.

```conf
[program:nomesito]
process_name=%(program_name)s_%(process_num)02d

; Comando worker Laravel
command=/usr/bin/php8.3 /home/utente/web/nomesito.it/public_html/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --memory=256

; Directory di lavoro
directory=/home/utente/web/nomesito.it/public_html

; Utente di sistema con cui girerà
user=utente

; Numero di worker (aumenta se ti serve più parallelismo)
numprocs=1

; Avvio automatico e restart se crasha
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true

; Log (stdout + stderr)
redirect_stderr=true
stdout_logfile=/home/detective/web/detectivebellezza.it/public_html/storage/logs/worker.log
stdout_logfile_maxbytes=20MB
stdout_logfile_backups=3
```