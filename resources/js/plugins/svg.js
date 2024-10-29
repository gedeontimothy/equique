import { watch, computed, createApp, defineComponent, h, ref, onMounted, onBeforeMount } from "vue";
import Eth from '../assets/icons/eth.svg';
import { array_key_exists, is_object, is_string, is_url } from "../utils/helpers.native";

export default {
	install(app, store){
		const datas = {
			with_url : {
				type : 'url',
				value : 'http://cdn.net/icon/svg/default.svg'
			},
			with_tag : {
				type : 'tag',
				value : '<svg class="svg-minus" style="fill:currentColor;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M3,12L3,12c0-0.552,0.448-1,1-1h16c0.552,0,1,0.448,1,1v0c0,0.552-0.448,1-1,1H4C3.448,13,3,12.552,3,12z"/></svg>'
			},
			with_object : {
				type : 'object',
				value : Eth
			},
			dashboard : {
				type : 'tag',
				value : '<svg class="w-5 h-5 mr-4" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>'
			}
		}

		const renderX = (svg, type, call, props = {}) => {
			switch (type) {
				case 'url':
					try {
						fetch(svg)
							.then((response) => {
								if(response.ok) return response.text();
								throw new Error(`Erreur HTTP ! statut : ${response.status}`);
							})
							.then((data, ...a) => {
								call(data, {error : false, svg, type, props});
							})
							.catch(error => {
								console.warn(error);
								call(null, {error : true, svg, type, props, error_message : error.message});
							})
						;
					} catch (error) {
						console.warn(error);
						call(null, {error : true, svg, type, props, error_message : error.message});
					}
					break;
				case 'tag':
					call(svg, {error : false, svg, type, props});
					break;
				case 'object':
					call(svg, {error : false, svg, type, props});
					break;
				default:
					call(null, {error : true, svg, type, props, error_message : "Svg render type not found"});
				break;
			}
		};

		const renderOnDatas = (svg, call, props = {}) => {
			if(datas?.[svg]){
				const svg_data = datas?.[svg];
				const type = is_string(svg_data?.type) ? svg_data.type : (is_object(svg_data.value) ? 'object' : (is_url(svg_data.value) ? 'url' : 'tag'));
				renderX(svg_data.value, type, call);
			}
			else call(null, {error : true, svg, type : null, props, error_message : "Svg render not found"});
		};

		const createElementFromHTML = (html) => {
			const template = document.createElement('div');
			template.innerHTML = html;
			return template.firstChild;
		};

		const renderDirectiveCall = (el, vnode, response, {error, type, props}) => {
			if(!error){
				if(is_string(response)){
					const element = createElementFromHTML(response);

					let attrs = {};

					[element.attributes, el.attributes].forEach((attr) => {
						Object.values(attr).forEach((val) => {
							if(array_key_exists(val.name, attrs)) attrs[val.name].push(val.value);
							else attrs[val.name] = [val.value];
						})
					})

					attrs = {...attrs, ...props}
					// console.log(attrs)
					const DynamicComponent = defineComponent({
						render() {
							return h(element.tagName.toLowerCase(), { 
								...attrs,
								innerHTML: element.innerHTML
							});
						}
					});

					const componentApp = createApp(DynamicComponent);

					const instance = componentApp.mount(document.createElement('div'));

					el.replaceWith(instance.$el);
				}
				else if(is_object(response)){
					// createApp(response).mount(el);
					const componentApp = createApp(defineComponent({
						render() {
							return h(response, vnode.props);
						}
					}));
			
					// Monter l'application sur un élément temporaire
					const instance = componentApp.mount(document.createElement('div'));
			
					el.parentNode.replaceChild(instance.$el, el);
				}
			}
			else el.textContent = 'svg-error-' + type;
			// console.log(response, error);
		}
		const renderDirective = (value, el, vnode, call_type) => {
			if(is_string(value) || (is_object(value) && is_string(value?.svg))){
				const svg = (is_string(value) ? value : value.svg).trim();
				const type = is_url(svg) ? 'url' : (is_object(value) && is_string(value?.type) ? value.type : null);
				var content = type 
					? renderX(svg, type, (...args) => renderDirectiveCall(el, vnode, ...args)) 
					: renderOnDatas(svg, (...args) => renderDirectiveCall(el, vnode, ...args))
				;
				// el.textContent
			}
		};
		app.component('XSvg', {
			name: 'XSvg',
			setup(props) {

				const svg = computed(() => props.xref.trim());

				const type_ = computed(() => is_url(svg.value) ? 'url' : (is_url(props.type) ? props.type : null));

				const is_init = ref(false);

				const element = ref(null);

				const error_m = ref('svg error');

				const renderComponentCall = (response, {error, svg, type, props, error_message}) => {
					is_init.value = true;
					if(!error){
						if(is_object(response)){
							element.value = h(response);
						}
						else if(is_string(response)){
							const element_ = createElementFromHTML(response);
							let attrs = {};

							Object.values(element_.attributes).forEach((val) => {
								if(array_key_exists(val.name, attrs)) attrs[val.name].push(val.value);
								else attrs[val.name] = [val.value];
							})
							element.value = h(element_.tagName.toLowerCase(), { 
								...attrs,
								innerHTML: element_.innerHTML
							});
						}
					}
					else if(error_message) error_m.value = error_message;
				}
				const xx = () => {
					if(type_.value)
						renderX(svg.value, type_.value, (...args) => {
							renderComponentCall(...args)
						})
					else
						renderOnDatas(svg.value, (...args) => {
							renderComponentCall(...args)
						})
				}

				// computed(xx)
				onBeforeMount(xx)


				return {is_init, element, error_m};
			},
			render() {
				return this.element ? this.element : h('div', null, this.is_init ? this.error_m : 'onload svg');
			},
			props : {
				type : {type : String, default : null},
				xref : {type : String, required : true},
			},
		});
		app.directive('svg', {
			mounted(el, binding, vnode) {
				renderDirective(binding.value, el, vnode, 'mounted');
			},
			updated(el, binding, vnode) {
				renderDirective(binding.value, el, vnode, 'updated');
			},
		})
	},
}
/*
Examples
	<x-svg class="w-6 h-6" style="fill:red;" xref="with_object"/>
	<x-svg class="w-6 h-6" xref="with_tag"/>
	<x-svg class="w-6 h-6" xref="with_url"/>
	<h3 class="w-6 h-6" style="fill:red;" v-svg="'with_object'"></h3>
	<h3 class="w-6 h-6" style="color:red;" v-svg="'with_tag'"></h3>
	<h3 class="w-6 h-6" style="color:red;" v-svg="'with_url'"></h3>
	<h3 class="w-3 h-3" style="fill:red;" v-svg="'eth'"></h3>
	<template class="inline-block w-8 h-8" v-svg="{svg : '<b>ss</b>', type : 'url'}"></template> // not work with <template></template>
	<span class="inline-block w-8 h-8" v-svg="'http://cdn.net/icon/svg/icons8_menu.svg'"></span>
*/
