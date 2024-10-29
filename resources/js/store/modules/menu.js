import { usePage } from '@inertiajs/vue3';
import * as helper from '../../utils/helpers.native';


const initialState = {
	default : [
		{
			name : 'home',
			name : 'home',
		}
	],
	dashboard : [
		{
			name : 'dashboard',
			title : 'Dashboard',
			icon : 'dashboard',
			// more : [
			// 	{title : 'Testons', name : 'testons'}
			// ],
			href : route('dashboard'),
		},
		{
			name : 'users',
			title : 'main.user.1',
			icon : cdn('/icon/svg/icons8_conference.svg'),
			// more : [
			// 	{title : 'Testons', name : 'testons'}
			// ],
			href : route('users'),
		},
		{
			name : 'products',
			title : 'main.product.1',
			icon : cdn('/icon/svg/icons8_product.svg'),
			// more : [
			// 	{title : 'Testons', name : 'testons'}
			// ],
			href : route('home'),
		},
		{
			name : 'commands',
			title : 'main.command.1',
			icon : cdn('/icon/svg/icons8_purchase_order.svg'),
			// more : [
			// 	{title : 'Testons', name : 'testons'}
			// ],
			href : route('home'),
		},
	],
	active : {
		menu : null,
		more : null,
	},
};

const menu = {
	
	namespaced: true,

	state: () => initialState,

	getters : {
		dashboardMenu(state, getters, rootState, rootGetters){
			// rootGetters['app/isAuth']
			return state.dashboard.map((menu) => {
				var more = null;
				if(menu.more){
					more = [...menu.more].map((more_menu) => {
						return {
							...more_menu,
							...(state.active.more == more_menu.name ? {active : true} : {active : false}),
						}
					});
				}
				return {
					...menu,
					...(state.active.menu == menu.name ? {active : true} : {active : false}),
					...(more ? {
						more : [...more],
					} : {})
				};
			});
		},
	},
	
	mutations : {
		baseActiveMenu(state, payload){
			if(helper.is_string(payload?.name)){
				state?.[payload.__type].forEach((menu, index) => {
					if(menu.name == payload.name){
						state.active.menu = menu.name;
						state[payload.__type][index].active = true;
					}
					else  state[payload.__type][index].active = false;
				});
			}
		},
		baseActiveMore(state, payload){
			if(helper.is_string(payload?.name)){
				state?.[payload.__type].forEach((menu, index) => {
					if(helper.is_array(menu?.more)){
						menu.more.forEach((menu_more, index_more) => {
							if(menu_more.name == payload.name){
								state.active.more = menu_more.name;
								state[payload.__type][index].more[index_more].active = true;
							}
							else
								state[payload.__type][index].more[index_more].active = false;
						});
					}
					// if(state?.[payload.__type][index].name == payload.name){
					// 	state?.[payload.__type][index].active = true;
					// }
					// else  state?.[payload.__type][index].active = false;
				});
			}
		},
		baseDisableActiveMenu(state, payload){
			state.active.menu = null;
			state.active.more = null;
			state?.[payload.__type].forEach((menu, index) => { state.dashboard[index].active = false; });
		},
	},

	actions : {
		dashboardActiveMenu({state, commit}, payload){commit('baseActiveMenu', {...payload, __type : 'dashboard'})},
		dashboardActiveMore({state, commit}, payload){commit('baseActiveMore', {...payload, __type : 'dashboard'})},
		dashboardDisableActiveMenu({state, commit}, payload){commit('baseDisableActiveMenu', {...payload, __type : 'dashboard'})},

		activeMenu({state, commit}, payload){commit('baseActiveMenu', {...payload, __type : 'default'})},
		activeMore({state, commit}, payload){commit('baseActiveMore', {...payload, __type : 'default'})},
		disableActiveMenu({state, commit}, payload){commit('baseDisableActiveMenu', {...payload, __type : 'default'})},
	},

}

export default menu;
