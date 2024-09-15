import { watch, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

export default {
	install(app, store){
		
		globalThis.isGuest = app.config.globalProperties.$isGuest = computed(() => store?.getters?.['app/isGuest']);
		globalThis.isAuth = app.config.globalProperties.$isAuth = computed(() => store?.getters?.['app/isAuth']);

		globalThis.session = app.config.globalProperties.$session = (key) => computed(() => {
			var val =  store.getters['app/session'];
			return key ? val?.[key] : val;
		});
		globalThis.flash = app.config.globalProperties.$flash = (key) => computed(() => {
			var val =  store.getters['app/flash'];
			return key ? val?.[key] : val;
		});

		const page = usePage();

		watch(() => page.props, (n, o) => {
			store.dispatch('app/loadPage');
		})

		app.component('Guest', {
			name: 'Guest',
			setup() {
				const is_guest = isGuest;
				return {is_guest};
			},
			render() {
				return this.is_guest ? this.$slots.default() : null;
			},
		});
		app.component('Auth', {
			name: 'Auth',
			setup() {
				const is_auth = isAuth;
				return {is_auth};
			},
			render() {
				return this.is_auth ? this.$slots.default() : null;
			},
		});
	},
}
