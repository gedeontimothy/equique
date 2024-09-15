import { h } from 'vue';
import { browse_array_keys, is_array, is_function, is_number, is_object, is_string, preg_quote } from '../utils/helpers.native';

const lang = {};

/**
 * 
 * @param {*} value 
 * @returns 
 */
const format = (value) => {
	return {
		value : is_string(value)
			? value
			: (is_array(value)
				? value.join('.')
				: (is_object(value) && (is_array(value?.value) || is_string(value?.value))
					? (is_array(value.value)
						? value.value.join('.')
						: value.value
					)
					: undefined
				)
			)
		,
		key : is_object(value) && is_object(value.key)
			? value.key
			: (is_string(value.key)
				? {'attribute' : value.key}
				: undefined
			)
		,
		null_on_not_found : value?.null_on_not_found,
	}
}

/**
 * 
 * 
 * @param {*} arg 
 * @param {*} lang 
 * @returns 
 */
const getLang = (arg, lang) => {
	const {value, key, null_on_not_found} = format(arg);
	if(!lang) console.error('Lang Datas is not INITIALIZED')
	else if(is_string(value)){
		let lang_value = browse_array_keys(value, lang);
		if(is_string(lang_value)){
			if(is_object(key)){
				for(var k in key){
					var val = key[k];
					if(is_string(val) || is_number(val) || val === null){
						lang_value = lang_value.replaceAll(new RegExp(preg_quote(':' + k), 'g'), val);
					}
				}
			}
			return lang_value;
		}
		else if(null_on_not_found) return null;
	}
	return value;
}

/**
 * Usage :
 * 
 *    ex :  'validation.accepted' = 'The :attribute field must be accepted.'
 *        [1] - __(['validation', 'accepted'], {attribute : '--attr-value--'}) -> The --attr-value-- field must be accepted.
 *        [2] - __('validation.accepted', {attribute : '--new-attr-value--'})  -> The --new-attr-value-- field must be accepted.
 *        [3] - __('validation.accepted', '--other-attr-value--')                -> The --other-attr-value-- field must be accepted.
 *        [4] - __('validation.accepted')                                        -> The :attribute field must be accepted.
 *        [5] - __('validation.accepted.not.found')                              -> validation.accepted.not.found
 * 
 *    ex :  'validation.accepted' = 'The :my_attribute field must be accepted.'
 *        [1] - __('validation.accepted', {my_attribute : '--attr-value--'}) -> The --attr-value-- field must be accepted.
 * 
 * @param {*} keys 
 * @param {*} key_attrs 
 * 
 * @returns string|undefined
 */
const globaleLang = (set_lang_datas) => {
	return (keys, key_attrs, null_on_not_found) => {
		if(is_function(set_lang_datas)) set_lang_datas(setLang);
		return getLang({value : keys, key : key_attrs, null_on_not_found}, lang.value);
	};
}

export const setLang = (lang_datas) => {
	lang.value = lang_datas ?? undefined;
}

export default {
	install(app, store) {
		globalThis.__ = app.config.globalProperties.$__ = globaleLang(() => {
			if(!lang?.value)
				setLang(store.getters['lang/datas']);
		});

		// Usage : 
		//     Ex :  'validation.accepted' = 'The :attribute field must be accepted.'
		//         [1] - <htmlTag class="my-class" v-lang="{value : ['validation', 'accepted'], key : {attribute : '--attr-value--'}}">
		//                 <i>Something</i>
		//               </htmlTag>
		//                   -----> <htmlTag class="my-class">The --attr-value-- field must be accepted.</htmlTag>
		//
		//         [2] - <htmlTag v-lang="{value : 'validation.accepted', key : {attribute : '--new-attr-value--'}}">...</htmlTag>
		//                   -----> <htmlTag>The --new-attr-value-- field must be accepted.</htmlTag>
		//
		//         [3] - <htmlTag v-lang="{value : 'validation.accepted', key : '--other-attr-value--'}">...</htmlTag>
		//                   -----> <htmlTag>The --other-attr-value-- field must be accepted.</htmlTag>
		//
		//         [4] - <htmlTag v-lang="'validation.accepted'">...</htmlTag>
		//                   -----> <htmlTag>The :attribute field must be accepted.</htmlTag>
		//
		//         [5] - <htmlTag v-lang="'validation.accepted.not.found'">...</htmlTag>
		//                   -----> <htmlTag>validation.accepted.not.found</htmlTag>
		//
		//
		//     Ex :  'validation.accepted' = 'The :my_attribute field must be accepted.'
		//         [1] - <htmlTag attribute="content..." v-lang="{value : 'validation.accepted', key : {my_attribute : '--attr-value--'}}">
		//               ...</htmlTag>
		//                   -----> <htmlTag attribute="content...">The --attr-value-- field must be accepted.</htmlTag>
		app.directive('lang', {
			mounted(el, binding, vnode) {
				if(!lang?.value) setLang(store.getters['lang/datas']);
				el.textContent = getLang(binding.value, lang.value);
			},
			updated(el, binding, vnode) {
				if(!lang?.value) setLang(store.getters['lang/datas']);
				el.textContent = getLang(binding.value, lang.value);
			},
		})

		// Usage : 
		//     Ex :  'validation.accepted' = 'The :attribute field must be accepted.'
		//         [1] - <Lang class="text-red-400" :value="['validation', 'accepted']" :attribute="{attribute : '--attr-value--'}"/>
		//                   -----> <span class="text-red-400">The --attr-value-- field must be accepted.</span>
		//
		//         [2] - <Lang tag="b" value="validation.accepted" :attribute="{attribute : '--new-attr-value--'}"/>
		//                   -----> <b>The --new-attr-value-- field must be accepted.</b>
		//
		//         [3] - <Lang tag="i" value="validation.accepted" attribute="--other-attr-value--"/>
		//                   -----> <i>The --other-attr-value-- field must be accepted.</i>
		//
		//         [4] - <Lang tag="b" value="validation.accepted"/>
		//                   -----> <b>The :attribute field must be accepted.</b>
		//
		//         [5] - <Lang value="validation.accepted.not.found"/>
		//                   -----> <span>validation.accepted.not.found</span>
		//
		//
		//     Ex :  'validation.accepted' = 'The :my_attribute field must be accepted.'
		//         [1] - <Lang value="validation.accepted" :attribute="{my_attribute : '--attr-value--'}"/>
		//                   -----> <span>The --attr-value-- field must be accepted.</span>
		app.component('Lang', {
			name: 'Lang',
			render() {
				return h(
					this.tag,
					{},
					__(this.value, this.attribute, this.returnNull)
				);
			},
			props: {
				value : {type : [String, Array], required : true},
				attribute : [String, Object],
				returnNull : Boolean,
				tag : {type : String, default : 'string'},
			},
		});
	},
}
