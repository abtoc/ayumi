import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                    'resources/scss/app_c.scss', 'resources/js/app_c.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                globals: {
                    jquery: 'window.jquery'
                }
            }
        }
    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~viewerjs' : path.resolve(__dirname, 'node_modules/viewerjs')
        }
    },
});
