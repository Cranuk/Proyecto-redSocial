import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/avatar.css',
                'resources/css/posts.css',
                'resources/css/profile.css',
                'resources/css/global.css',
                'resources/js/app.js',
                'resources/js/main.js',
            ],
            refresh: true,
            publicDir: 'public',
        }),
    ],
    resolve: {
        alias: {
            '$': 'jquery'
        },
    },
});

