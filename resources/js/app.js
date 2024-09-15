import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js';
import './bootstrap';
import Bootstrap from './views/layouts/Bootstrap.vue';
import store from './store';
import {base, lang} from './plugins';

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob("./views/**/*.vue", { eager: true });
		let page = pages[`./views/${name}.vue`];
		page.default.layout = page?.default?.layout || Bootstrap
		return page;
	},
	setup({ el, App, props, plugin }) {
		createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue)
			.use(store)
			.use(base, store)
			.use(lang, store)
			.mount(el);
	},
});
