<script setup>
import { ref } from 'vue';
import WindmillSliderMenu from '../lists/WindmillSliderMenu.vue';
const props = defineProps({
	appName : {type : String, default : 'Equique'},
	menu : {type : Array, required : true},
});

const isPagesMenuOpen = ref(false);

const togglePagesMenu = () => {
	isPagesMenuOpen.value = !isPagesMenuOpen.value;
};
</script>
<template>
	<aside class="z-20 hidden overflow-y-auto bg-white md:flex flex-col">
		<div class="py-4 text-gray-500">
			<a class="ml-6 text-lg ff-jost-semibold text-gray-800" href="#">
				{{ appName }}
			</a>
			<ul class="mt-6">
				<template v-for="(item, index) in menu" :key="index">
					<WindmillSliderMenu class="relative px-6 py-3" v-bind="item"/> 
				</template>
			</ul>
			<div class="px-6 my-6">
				<button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg first-bg-color-default hover:first-bg-color-dark-10 focus:outline-none focus:shadow-outline-purple">
					Create account
					<span class="ml-2" aria-hidden="true">+</span>
				</button>
			</div>
		</div>
		<slot/>
	</aside>
</template>