import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Backend (Filament)
                'resources/css/filament/admin/theme.css',

                // Frontend
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/glightbox.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
