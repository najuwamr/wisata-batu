import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/customer/landing.js',
            ],
        },
    },
    base: '/public/build/', // ⚡ ini penting (karena path di hostingmu ada /public/)
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/customer/landing.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
