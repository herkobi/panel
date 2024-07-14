import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/scss/front.scss', 'resources/js/app.js', 'resources/js/front.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~tabler': path.resolve(__dirname, 'node_modules/@tabler/core'),
        }
    },
});
