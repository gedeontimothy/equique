import { usePage } from '@inertiajs/vue3';
import * as helper from '../../utils/helpers.native';

const initialState = {
	
	area : {
		item_actived : 0,
		minimize : false,
		components : {

		},
	},

	user : null,

	page : {
		props : {}
	},

	lang : {},

	global_is_init : false,

	load : {
		type : null,
		active : 0,
	}

};

const app = {
	
	namespaced: true,

	state: () => initialState,

	getters : {
		getProps(state){
			return state.page.props;
		},
		getProp(state){
			return (key) => state.page.props?.[key];
		},

		isGuest(state){
			return state.page?.props?.auth?.user == null;
		},

		isAuth(state){
			return state.page?.props?.auth?.user != null;
		},

		lang(state){
			return state.page?.props?.lang;
		},

		propsPageExists : (state) => state.page?.props ? true : false,

		auth_person(state){
			return (key) => key ? state.page?.props?.auth?.user?.person?.[key] : state.page?.props?.auth?.user?.person
		},

		auth_user(state){
			return (key) => key ? state.page?.props?.auth?.user?.[key] : state.page?.props?.auth?.user
		},

		onLoading : (state) => state.load.active > 0,

		session(state){
			return state.page?.props?.session;
		},

		flash(state){
			return state.page?.props?.session?._flash;
		},

	},
	
	mutations : {
		setPageProps(state, payload){
			state.page.props = {...payload.value}
		},

		initGlobal(state){
			state.global_is_init = true;
		},
		
		enableLoad(state, payload){if(payload && state.load.type === null) state.load.type = payload; state.load.active++;},

		disableLoad(state){if(state.load.active === 1) state.load.type = null; state.load.active--;},

		destructLoad(state){state.load.type = null; state.load.active = 0;},

		
	},

	actions : {
		async bootstrap({commit, dispatch, getters}){
			commit('enableLoad');
			await dispatch('loadPage');
			await dispatch('lang/initLang', null, {root : true})
			commit('disableLoad');
		},

		loadPage({commit}){
			const page = usePage();
			commit('setPageProps', {value : page.props});
		},
	},

}

export default app;
