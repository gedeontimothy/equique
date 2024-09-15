import { usePage, router } from '@inertiajs/vue3';
import * as helper from '../../utils/helpers.native';
import { getLangAvailable, getCurrentLangDatas, getLangDatas } from '../../services/lang';

const getLocalLang = () => {
	return {
		available : JSON.parse(localStorage.getItem('available')),
		datas : JSON.parse(localStorage.getItem('datas')),
	};
}

const setLocalLangDatas = (datas, lang) => {
	localStorage.setItem('datas', JSON.stringify({datas, lang}));
}

const setLocalLangAvailable = (datas) => {
	localStorage.setItem('available', JSON.stringify({datas}));
}

const resetLocalLang = () => {
	localStorage.removeItem('available');
	localStorage.removeItem('datas');
}

const initLocalLang = async (reset) => {

	if(reset) resetLocalLang();

	const response = getLocalLang();

	if(response.datas === null){
		response.datas = await getCurrentLangDatas();
		if(response.datas.errors?.length == 0)
			setLocalLangDatas(response.datas.datas, response.datas.lang);
	}

	if(response.available === null){
		response.available = await getLangAvailable();
		if(response.available.errors?.length == 0)
			setLocalLangAvailable(response.available.datas);
	}

} 

const initialState = {
	available_language : null/* {
		en : {
			iso : 'en_US',
			name : 'English',
			country : 'USA',
			rtl : false,
		},
	} */,
	current_language : null,
	datas : null,
	is_init : false,
};

const app = {
	
	namespaced: true,

	state: () => initialState,

	getters : {

		datas(state){
			return state.datas;
		},

		currentLang(state){
			return state.available_language && state.current_language 
				? (state.available_language?.[state.current_language] ?? null) 
				: null
			;
		},

		availableSort : (state) => state?.current_language && state?.available_language?.[state.current_language] 
			? {[state.current_language] : state.available_language[state.current_language], ...state.available_language}
			: state.available_language
		,
		// isAvailable(state, payload){

		// },
	},
	
	mutations : {
		setAvailableLanguage(state, payload){
			state.available_language = payload;
		},

		setCurrentLanguage(state, payload){state.current_language = payload;},

		setLanguageDatas(state, payload){state.datas = payload;},

		setIsInit(state, payload){state.is_init = payload;},

	},

	actions : {
		async initLang({state, commit, dispatch, getters}){
			await initLocalLang(true);
			const lang = getLocalLang();
			if(lang.available && lang.datas){
				commit('setAvailableLanguage', lang.available.datas);
				commit('setLanguageDatas', lang.datas.datas);
				commit('setCurrentLanguage', lang.datas.lang);
				commit('setIsInit', true);

				// console.log(state.current_language);
				// console.log(state.available_language);
				// console.log(state.datas);
			}
			else commit('setIsInit', null);
			// console.log(getters['currentLang'])
		},

		resetLocalLang({commit}, payload){
			resetLocalLang();
			// commit('setAvailableLanguage', null);
			// commit('setLanguageDatas', null);
			// commit('setCurrentLanguage', null);
		}
	},

}

export default app;
