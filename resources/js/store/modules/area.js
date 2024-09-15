import * as helper from '../../utils/helpers.native';

const initialState = {
	item_actived : 0,
	minimize : false,
	components : {

	},
};

const area = {
	
	namespaced: true,

	state: () => initialState,

	getters : {
		areaKeyExists(state){
			return (key) => state.components?.[key] ? true : false;
		},
	},

	mutations : {
		minimizeArea(state){
			state.minimize = true;
		},
		unminimizeArea(state){
			state.minimize = false;
		},
		addArea(state, payload){
			const {name, key, type, datas, options} = helper.is_object(payload) ? payload : {};
			if(type && datas){
				let key_ = helper.is_string(key) ? key : Object.keys(state.components).length;
				if(payload.active) {
					if(!state.components?.[key_])
						state.item_actived++;
					state.minimize = false;
				}
				state.components[key_] = {key : key_, name, type, datas, options};
				return key;
				// console.log(state.components)
				// console.log(payload);
			}
			return null;
		},
		removeAreaComponentByKey(state, payload){
			const {key} = helper.is_object(payload) ? payload : {};
			if(key && state.components?.[key]){
				delete state.components[key];
				state.item_actived--;
			}
		},
		updateAreaComponentDatasByKey(state, payload){
			const {key, datas, merge} = helper.is_object(payload) ? payload : {};
			// console.log(state.components?.[key])
			if(key && datas && state.components?.[key]){
				let defaultUpdate = () => {
					state.components[key] = {
						...state.components[key],
						datas : merge 
						// ? ({...state.components[key].datas, ...(datas ?? {})})
							? helper.object_merge_recursive(state.components[key].datas, datas ?? {})
							: (datas ?? state.components[key].datas),
					};
				}
				if(helper.is_function(state.components[key]?.options?.updateEvent)){
					state.components[key]?.options?.updateEvent({state, key, defaultUpdate, currentDatas : state.components[key], updateDatas : datas, merge});
				}
				else defaultUpdate();
				if(helper.is_array(state.components[key]?.options?.afterUpdate)){
					for(var eventIndex in state.components[key].options.afterUpdate){
						var event_ = state.components[key].options.afterUpdate[eventIndex];
						if(helper.is_function(event_)){
							event_({state, key, eventIndex, component : state.components[key], datas : state.components[key].datas, merge});
						}
					}
				}
			}
		},
	},

	actions : {
		
		minimizeArea({dispatch, commit, state}, payload){
			commit('minimizeArea');
		},
		unminimizeArea({dispatch, commit, state}, payload){
			commit('unminimizeArea');
		},
		addArea({dispatch, commit, state}, payload){
			if(payload.type == 'message-loader' && payload.datas?.percent?.autoClose){
				payload.options = helper.is_object(payload.options) ? payload.options : {};
				
				payload.options.afterUpdate = [...(helper.is_array(payload.options.afterUpdate) ? payload.options.afterUpdate : (helper.is_function(payload.options.afterUpdate) ? [payload.options.afterUpdate] : [])), ({datas, key}) => {
					if(datas.percent.value >= 100){
						dispatch('removeArea', {key})
					}
				}]
			}
			else if(payload.type == 'step' && payload.datas?.autoClose){
				payload.options = helper.is_object(payload.options) ? payload.options : {};
				payload.options.afterUpdate = [...(helper.is_array(payload.options.afterUpdate) ? payload.options.afterUpdate : (helper.is_function(payload.options.afterUpdate) ? [payload.options.afterUpdate] : [])), ({datas, key}) => {
					let verif = true;
					Object.values(datas.steps).map((element, key) => {
						if(![0,2].includes(element.state)) verif = false;
					})
					if(verif){
						setTimeout(() => {
							dispatch('removeArea', {key})
						}, 500);
					}
				}]
				// 	payload.options.updateEvent = ({state, key, merge, defaultUpdate, updateDatas, currentDatas}) => {
				// 	}
			}
			commit('addArea', payload);
		},
		updateArea({dispatch, commit, state}, payload){
			const {key, datas, merge} = helper.is_object(payload) ? payload : {};
			if(key && datas){
				commit('updateAreaComponentDatasByKey', {key, datas, merge});
			}
		},
		removeArea({dispatch, commit, state}, payload){
			const {key} = helper.is_object(payload) ? payload : {};
			if(key) commit('removeAreaComponentByKey', {key});
		},
	},

}

export default area;
