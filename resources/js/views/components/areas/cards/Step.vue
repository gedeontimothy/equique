<script setup>
	import {ref, watch, computed} from 'vue'
	import { useStore } from 'vuex'
	
	import { FwbSpinner, FwbButton } from 'flowbite-vue'
	import AreaStep from '../../loaders/AreaStep.vue'

	const props = defineProps({
		title : {type : String, default : null},
		description : {type : String, default : null},
		steps : {type : Object, default : null},
		areaKey : {type : String, default : null},
		closeIcon : {type : Boolean, default : false},
	});

	// const close = props.areaKey && props.closeIcon;
	
	const store = useStore();
	
	const closeArea = () => {
		store.dispatch('area/removeArea', {key : props.areaKey});
	}

	const checkClose = (props) => {
		// if(props?.percent?.value && props.areaKey && props?.percent?.autoClose){
		// 	if(props.percent.value == 100) closeArea();
		// }
	}
	checkClose(props);
	watch(props, (new_val) => {
		checkClose(new_val);
	});
</script>
<template>
	<div class="Fade back-blur-329 bg-white bg-opacity-50 dark:bg-black dark:bg-opacity-60 rounded-3xl">
        <div class="flex justify-between items-center space-x-4     py-4 px-6 border-b-2 border-white border-opacity-40 dark:border-black dark:border-opacity-80">
            <h4 class="ff-jost-medium text-base">{{ title }}</h4>
            <template v-if="areaKey && closeIcon">
                <button @click="closeArea" class="flex justify-center items-center w-4 h-4">
                    <svg style="fill:currentColor;" class="svg-delete" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M39.486328 6.9785156 A 1.50015 1.50015 0 0 0 38.439453 7.4394531L24 21.878906L9.5605469 7.4394531 A 1.50015 1.50015 0 0 0 8.484375 6.984375 A 1.50015 1.50015 0 0 0 7.4394531 9.5605469L21.878906 24L7.4394531 38.439453 A 1.50015 1.50015 0 1 0 9.5605469 40.560547L24 26.121094L38.439453 40.560547 A 1.50015 1.50015 0 1 0 40.560547 38.439453L26.121094 24L40.560547 9.5605469 A 1.50015 1.50015 0 0 0 39.486328 6.9785156 z"/></svg>
                </button>
            </template>
        </div>
        <template v-if="description">
            <p class="ff-jost text-sm opacity-75 px-6 pt-6" v-html="description"></p>
        </template>
		<div class="flex flex-col space-y-4 p-6">
            <template v-for="(step, index) in steps" :key="index">
                <div class="container-e92">
                    <AreaStep :state="step.state" :label="step.label" :description="step.description" />
                </div>
            </template>
		</div>
	</div>
</template>
