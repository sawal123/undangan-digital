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
            refresh: true,
        }),
    ],
});
