<script setup>
	import {ref, watch, computed} from 'vue'
	import { useStore } from 'vuex'
	
	import { FwbSpinner, FwbButton } from 'flowbite-vue'

	const props = defineProps({
		title : {type : String, required : null},
		description : {type : String, default : null},
		percent : {type : Object, default : null},
		areaKey : {type : String, default : null},
		closeIcon : {type : Boolean, default : false},
		spinner : {type : Boolean, default : true},
		color : {type : String},
	});
	const close = props.areaKey && props.closeIcon;
	
	const store = useStore();
	
	const closeArea = () => {
		store.dispatch('area/removeArea', {key : props.areaKey});
	}

	const checkClose = (props) => {
		if(props?.percent?.value && props.areaKey && props?.percent?.autoClose){
			if(props.percent.value == 100) closeArea();
		}
	}
	checkClose(props);
	watch(props, (new_val) => {
		checkClose(new_val);
	});

	const color_ = computed(() => ({
		a : {
			base : props.color == 'danger'
				? 'bg-red-200 bg-opacity-50'
				: (props.color == 'success'
					? 'bg-green-200 bg-opacity-50'
					: 'bg-white bg-opacity-50 dark:bg-black dark:bg-opacity-60'
				)
			,
			border : props.borderColor
				? null
				: ''
			,
		},
		b : {
			base : props.color == 'danger'
				? 'text-red-700'
				: (props.color == 'success'
					? 'text-green-600'
					: null
				)
			,
		},
	}));

</script>
<template>
	<div :class="'component-card-area-message-alert-28d Fade back-blur-329 rounded-3xl ' + Object.values(color_.a).join(' ')">
		<template v-if="title">
			<div class="flex justify-between items-center space-x-4     py-4 px-6 border-b-2 border-white border-opacity-40 dark:border-black dark:border-opacity-80">
				<h4 :class="'ff-jost-medium text-base ' + Object.values(color_.b).join(' ')">{{ title }}</h4>
				<template v-if="!(areaKey && closeIcon)">
					<fwb-spinner v-if="spinner" size="8" color="yellow"/>
				</template>
				<template v-else>
					<button @click="closeArea" class="flex justify-center items-center w-4 h-4">
						<svg style="fill:currentColor;" class="svg-delete" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M39.486328 6.9785156 A 1.50015 1.50015 0 0 0 38.439453 7.4394531L24 21.878906L9.5605469 7.4394531 A 1.50015 1.50015 0 0 0 8.484375 6.984375 A 1.50015 1.50015 0 0 0 7.4394531 9.5605469L21.878906 24L7.4394531 38.439453 A 1.50015 1.50015 0 1 0 9.5605469 40.560547L24 26.121094L38.439453 40.560547 A 1.50015 1.50015 0 1 0 40.560547 38.439453L26.121094 24L40.560547 9.5605469 A 1.50015 1.50015 0 0 0 39.486328 6.9785156 z"/></svg>
					</button>
				</template>
			</div>
		</template>
		<div v-if="description || (spinner && ((areaKey && closeIcon) || title == null))" class="flex justify-between items-center space-x-4 p-6">
			<p class="ff-jost text-sm opacity-80" v-html="description"></p>
			<template v-if="spinner && ((areaKey && closeIcon) || title == null)">
				<fwb-spinner size="8" color="yellow"/>
			</template>
		</div>
		<template v-if="percent !== null">
			<div class="pb-6 px-6">
				<div class="progress-bar-e29 flex first-bg-color-default first-bg-color-opacity-20 h-2 hover:h-5 transition-all duration-200 rounded-full relative z-[1] overflow-hidden">
					<div class="first-bg-color-default h-full rounded-full transition-all duration-200" :style="'width : ' + percent.value + '%;'"></div>
					<span class="ff-jost-medium text-xs absolute inset-0 m-auto flex justify-center items-center opacity-0 hover:opacity-100 transition-all duration-500 transform translate-y-5">{{ percent.value }}%</span>
				</div>
			</div>
		</template>
	</div>
</template>
<style>
.component-card-area-message-alert-28d:hover .progress-bar-e29{
	height: 1.25rem; /* 20px */
}
.component-card-area-message-alert-28d:hover .progress-bar-e29 span {
	transform : translate(0);
	opacity: 1;
}
</style>
