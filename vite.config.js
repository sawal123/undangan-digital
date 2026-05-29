import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        watch: {
            ignored: [
                '**/storage/framework/views/**',
                '**/storage/framework/sessions/**',
                '**/storage/logs/**',
            ],
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            detectTls: 'undangan-digital.test',
            refresh: [
                {
                    paths: [
                        'resources/views/**',
                        'app/Livewire/**',
                        'routes/web.php',
                    ],
                    config: {
                        delay: 250,
                    },
                },
            ],
        }),
    ],
});
