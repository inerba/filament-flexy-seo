#!/bin/sh
set -e

echo "🚀 Deploying application ..."

# 1. Dipendenze PHP
/usr/bin/php8.3 /usr/local/bin/composer install \
  --no-interaction \
  --prefer-dist \
  --optimize-autoloader
# se in produzione:
# /usr/bin/php8.3 /usr/local/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# 2. Migrazioni (solo se sicuro!)
# /usr/bin/php8.3 artisan migrate --force

# 3. Restart code queue, fa terminare i worker esistenti e Supervisor li rifa partire puliti
/usr/bin/php8.3 artisan queue:restart

# Se usi Shield, aggiorna permessi e ruoli
# php artisan db:seed --class=ShieldSeeder --force

# 4. Ottimizzazioni varie
/usr/bin/php8.3 artisan cache:clear
/usr/bin/php8.3 artisan optimize
# se usi traduzioni delle rotte:
# /usr/bin/php8.3 artisan route:trans:cache

# 5. Build frontend (se serve davvero per quel sito)
# npm install --no-audit --no-fund
npm run build

echo "✅ Application deployed!"

# 7. Firma ASCII ART
cat << "EOF"
                                                                                                      
                                                                bbbbbbbb                              
  iiii                                                          b::::::b                              
 i::::i                                                         b::::::b                              
  iiii                                                          b::::::b                              
                                                                 b:::::b                              
iiiiiiinnnn  nnnnnnnn        eeeeeeeeeeee    rrrrr   rrrrrrrrr   b:::::bbbbbbbbb      aaaaaaaaaaaaa   
i:::::in:::nn::::::::nn    ee::::::::::::ee  r::::rrr:::::::::r  b::::::::::::::bb    a::::::::::::a  
 i::::in::::::::::::::nn  e::::::eeeee:::::eer:::::::::::::::::r b::::::::::::::::b   aaaaaaaaa:::::a 
 i::::inn:::::::::::::::ne::::::e     e:::::err::::::rrrrr::::::rb:::::bbbbb:::::::b           a::::a 
 i::::i  n:::::nnnn:::::ne:::::::eeeee::::::e r:::::r     r:::::rb:::::b    b::::::b    aaaaaaa:::::a 
 i::::i  n::::n    n::::ne:::::::::::::::::e  r:::::r     rrrrrrrb:::::b     b:::::b  aa::::::::::::a 
 i::::i  n::::n    n::::ne::::::eeeeeeeeeee   r:::::r            b:::::b     b:::::b a::::aaaa::::::a 
 i::::i  n::::n    n::::ne:::::::e            r:::::r            b:::::b     b:::::ba::::a    a:::::a 
i::::::i n::::n    n::::ne::::::::e           r:::::r            b:::::bbbbbb::::::ba::::a    a:::::a 
i::::::i n::::n    n::::n e::::::::eeeeeeee   r:::::r            b::::::::::::::::b a:::::aaaa::::::a 
i::::::i n::::n    n::::n  ee:::::::::::::e   r:::::r            b:::::::::::::::b   a::::::::::aa:::a
iiiiiiii nnnnnn    nnnnnn    eeeeeeeeeeeeee   rrrrrrr            bbbbbbbbbbbbbbbb     aaaaaaaaaa  aaaa
                                                                                                      
EOF                                                               