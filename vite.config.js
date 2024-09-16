import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/front.scss',
                'resources/css/auth.scss',
                'resources/css/app.scss',
                'resources/css/panel.scss',
                'resources/js/front.js',
                'resources/js/auth.js',
                'resources/js/app.js',
                'resources/js/panel.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});
