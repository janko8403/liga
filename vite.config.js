import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        frontend: {

        },
        backend: {

        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/backend_app.js','resources/css/frontend.css', 'resources/js/frontend_app.js'],
            refresh: true,
        }),
    ],
    server: {
        port: 8101
    }
});
