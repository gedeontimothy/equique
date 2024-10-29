import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import ElementPlus from 'unplugin-element-plus/vite';
import svgLoader from 'vite-svg-loader';

export default defineConfig({
	resolve : {
		alias : {
			'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
		}
	},
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        svgLoader(),
        ElementPlus(),
    ],
});
