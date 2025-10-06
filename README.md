# Completissimo

Uno starter kit cms multilingua basato su Laravel 12 e Filament 4

## internazionalizzazione
Il kit usa [Laravel Localization](https://github.com/mcamara/laravel-localization) per gestire le traduzioni e le lingue.
abilita le lingue che vuoi usare in `config/laravellocalization.php` nella sezione `supportedLocales`.

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