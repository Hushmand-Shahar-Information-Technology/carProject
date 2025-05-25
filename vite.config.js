import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';


export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [
                // {
                // src: 'node_modules/owl.carousel/dist/assets/*.woff2',
                // dest: 'assets/fonts'
                // }
            ]
        }),
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                // {
                //     src: 'node_modules/@fortawesome/fontawesome-free/webfonts',
                //     dest: 'fonts'
                // },
                // {
                //     src: 'node_modules/owl.carousel/dist/assets/*.woff2',
                //     dest: 'fonts'
                // }
            ]
        })
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
        },
    },
});
