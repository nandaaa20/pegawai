import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Track built assets for the local/offline portfolio: Laravel loads these
// directly, without depending on a running Vite HMR development server.
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            buildDirectory: 'ui',
            hotFile: 'public/ui-hot',
            refresh: true,
        }),
    ],
});
