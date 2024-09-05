import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js';
import './bootstrap';

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob("./views/**/*.vue", { eager: true });
		return pages[`./views/${name}.vue`];
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue)
			.mount(el);
	},
});
