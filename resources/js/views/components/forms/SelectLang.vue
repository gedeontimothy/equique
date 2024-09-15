<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import { is_boolean, is_object, is_string, preg_quote } from '../../../utils/helpers.native';
import { router } from '@inertiajs/vue3';

const props = defineProps({
	format : [String, Object], /*{option : ':name',label : ':name'}*/
	alsoTranslateCurrentLang : {type : Boolean, default : true},
	float : {type : [Boolean, Number]},
});

const store = useStore();

const lang_available = computed(() => store.getters['lang/availableSort']);
const is_init = computed(() => store.state.lang.is_init);
const current_lang = computed(() => store.getters['lang/currentLang']);
const current_language = computed(() => store.state.lang.current_language);
const check = computed(() => Object.keys(lang_available.value ?? {}).length > 1);

const select_value = ref(current_language.value);

const handleChange = (e) => {
	select_value.value = e.target.value;
	store.dispatch('lang/resetLocalLang');
	window.location.href = route('lang.store', {lang : e.target.value});
}

const displayResult = computed(() => {
	return (lang, type) => {
		let lang_data = lang_available.value[lang];
		let text = {
			name : lang_data.name,
			translation_name : lang != current_language.value ? (__('lang.translation.' + lang_data.iso + '.name', null, true) ?? __('lang.translation.' + lang + '.name')) : (props.alsoTranslateCurrentLang ? current_lang.value.name : null),
			translation_country : lang != current_language.value ? (__('lang.translation.' + lang_data.iso + '.country', null, true) ?? __('lang.translation.' + lang + '.country')) : (props.alsoTranslateCurrentLang ? current_lang.value.country : null)
		}

		let format = is_object(props.format) && is_string(props.format?.[type]) ? props.format[type] : (is_string(props.format) ? props.format : ':translation_name (:name - :translation_country)');

		for(var key of Object.keys(text)){
			format = format.replaceAll(new RegExp(preg_quote(':' + key), 'g'), text?.[key] ?? '')
		}
		return format.trim();
	}
})
</script>
<template>
	<template v-if="is_init">
		<div v-if="check" :class="'component-forms-select-lang-w29 group' + (float 
			? ' ' + (float === 1
				? 'absolute'
				: (float === 2
					? 'fixed'
					: 'relative'
				)
			) + ' ' +(is_boolean(float) ? '' : ' right-4 top-4')
			: ' relative'
		)">
			<select name="lang" class="peer absolute inset-0 m-auto w-full h-full z-[1] opacity-0 overflow-hidden" @change="handleChange">
				<template v-for="(item, index) in lang_available" :key="index">
					<option :value="index" :selected="index == current_language">
						{{ displayResult(index, 'option') }}
					</option>
				</template>
			</select>
			<div :class="'content-2eesd flex justify-between items-center py-2 rounded-3xl z-10' + (float
				? ' bg-white shadow transition-all duration-200 px-2.5 peer-hover:px-4 group-focus-within:px-4'
				: ' border border-neutral-300 peer-focus:border-neutral-400 space-x-2 px-4'
			)">
				<span class="w-4 h-4">
					<svg class="svg-globe" style="fill:currentColor;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M24 4C12.972066 4 4 12.972074 4 24C4 35.027926 12.972066 44 24 44C35.027934 44 44 35.027926 44 24C44 12.972074 35.027934 4 24 4 z M 24 7C24.732512 7 25.47638 7.3049138 26.292969 8.0566406C27.109557 8.8083674 27.937809 10.00251 28.646484 11.544922C29.21649 12.785523 29.636897 14.376262 30.021484 16L17.978516 16C18.363103 14.376262 18.78351 12.785523 19.353516 11.544922C20.062191 10.00251 20.890443 8.8083674 21.707031 8.0566406C22.52362 7.3049138 23.267488 7 24 7 z M 17.777344 8.1875C17.36377 8.8373605 16.976184 9.5328778 16.626953 10.292969C15.865942 11.949289 15.294931 13.909818 14.851562 16L8.9960938 16C10.887432 12.451925 14.000349 9.6704643 17.777344 8.1875 z M 30.222656 8.1875C33.999651 9.6704643 37.112568 12.451925 39.003906 16L33.148438 16C32.705069 13.909818 32.134058 11.949289 31.373047 10.292969C31.023816 9.5328778 30.63623 8.8373605 30.222656 8.1875 z M 7.7480469 19L14.460938 19C14.25543 20.632226 14 22.231849 14 24C14 25.768151 14.255429 27.367774 14.460938 29L7.7480469 29C7.2643289 27.419675 7 25.741249 7 24C7 22.258751 7.2643289 20.580325 7.7480469 19 z M 17.466797 19L30.533203 19C30.75622 20.613412 31 22.220624 31 24C31 25.779376 30.75622 27.386588 30.533203 29L17.466797 29C17.24378 27.386588 17 25.779376 17 24C17 22.220624 17.24378 20.613412 17.466797 19 z M 33.539062 19L40.251953 19C40.735671 20.580325 41 22.258751 41 24C41 25.741249 40.735671 27.419675 40.251953 29L33.539062 29C33.744571 27.367774 34 25.768151 34 24C34 22.231849 33.744571 20.632226 33.539062 19 z M 8.9960938 32L14.851562 32C15.294932 34.090182 15.865942 36.050711 16.626953 37.707031C16.976184 38.467122 17.36377 39.16264 17.777344 39.8125C14.000349 38.329536 10.887432 35.548075 8.9960938 32 z M 17.978516 32L30.021484 32C29.636897 33.623738 29.21649 35.214477 28.646484 36.455078C27.937809 37.99749 27.109557 39.191633 26.292969 39.943359C25.47638 40.695086 24.732512 41 24 41C23.267488 41 22.52362 40.695086 21.707031 39.943359C20.890443 39.191633 20.062191 37.99749 19.353516 36.455078C18.78351 35.214477 18.363103 33.623738 17.978516 32 z M 33.148438 32L39.003906 32C37.112568 35.548075 33.999651 38.329536 30.222656 39.8125C30.63623 39.16264 31.023816 38.467122 31.373047 37.707031C32.134058 36.050711 32.705069 34.090182 33.148438 32 z"/></svg>
				</span>
				<label for="lang" :class="'ff-jost text-sm' + (float 
					? ' transition-all duration-200 overflow-hidden text-nowrap whitespace-nowrap max-w-0 ml-0 group-hover:max-w-max group-focus-within:max-w-max group-hover:ml-2 group-focus-within:ml-2' 
					: ''
				)">{{ displayResult(select_value, 'label') }}</label>
				<span :class="'h-2.5 transform -rotate-90 group-focus-within:-rotate-180' + (float 
					? ' overflow-hidden transition-all duration-75 w-0 ml-0 group-hover:w-2.5 group-hover:ml-2 group-focus-within:w-2.5 group-focus-within:ml-2'
					: ' w-2.5 transition-transform duration-200'
				)">
					<svg class="svg-back" style="fill:currentColor;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"><path d="M34.960938 2.980469C34.441406 2.996094 33.949219 3.214844 33.585938 3.585938L13.585938 23.585938C12.804688 24.367188 12.804688 25.632813 13.585938 26.414063L33.585938 46.414063C34.085938 46.9375 34.832031 47.148438 35.535156 46.964844C36.234375 46.78125 36.78125 46.234375 36.964844 45.535156C37.148438 44.832031 36.9375 44.085938 36.414063 43.585938L17.828125 25L36.414063 6.414063C37.003906 5.839844 37.183594 4.960938 36.863281 4.199219C36.539063 3.441406 35.785156 2.957031 34.960938 2.980469Z"/></svg>
				</span>
			</div>
		</div>
	</template>
	<template v-else-if="is_init === null">Language Error</template>
	<template v-else>Langage Loading</template>
</template>
