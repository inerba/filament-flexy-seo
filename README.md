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