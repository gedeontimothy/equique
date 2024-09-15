<script setup>
	import { computed, onBeforeMount, watch, ref } from 'vue'
	import { useStore } from 'vuex'

	import MainCards from './cards/Main.vue'
	import StepCards from './cards/Step.vue'

	const store = useStore();
	const area = computed(() => store.state.area);
	const items_actived = computed(() => store.state.area.item_actived);
	const minimize = computed(() => store.state.area.minimize);
	const components = computed(() => store.state.area.components);

	const reduce = ref(null);
	const reduce2 = ref(null);
	// console.log(items_actived.value, components.value)
	watch(components.value, () => {
		// console.log(items_actived.value, components.value)
		if(items_actived.value >= 5){
			setTimeout(() =>{
				if(reduce?.value?.scrollIntoView) reduce.value.scrollIntoView();
			}, 2);
		}
	})

	const areaEvent = {
		unminimize : () => {
			store.dispatch('area/unminimizeArea');
			setTimeout(() => reduce.value.scrollIntoView(), 2);
		},
		minimize : () => store.dispatch('area/minimizeArea'),
	}
</script>
<template>
	<div v-if="items_actived > 0" class="component-loaders-area z-50 fixed bottom-0 right-0 overflow-hidden overflow-y-auto rounded-3xl max-h-full" ref="reduce2">
		<button @click="areaEvent.unminimize" v-if="minimize" class="minimize-w128 fixed bottom-24 second-color-default hover:second-color-dark-20 dark:second-color-light-5 hover:second-color-dark-20- -translate-x-1/2 flex h-6 w-6 hover:scale-[1.4] transition-all duration-150">
			<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-current opacity-75"></span>
			<span class="relative inline-flex rounded-full h-full w-full bg-current"></span>
		</button>
		<div v-else class="main-s92s p-6 space-y-3">
			<div class="flex flex-col space-y-4 w-[24rem]">
				<template v-for="(item, index) in components" :key="index">
					<template v-if="item.type == 'main'">
						<MainCards v-bind="{...item.datas, areaKey : item.key}"/>
					</template>
					<template v-if="item.type == 'step'">
						<StepCards v-bind="{...item.datas, areaKey : item.key}"/>
					</template>
				</template>
			</div>
			<div class="Fade flex justify-end" ref="reduce">
				<button @click="areaEvent.minimize" class="back-blur-329 px-8 py-2.5 first-bg-color-default first-bg-color-opacity-50 hover:first-bg-color-opacity-80 dark:first-bg-color-opacity-90 dark:hover:first-bg-color-opacity-100 rounded-xl transition duration-100 flex items-center space-x-2 text-white">
					<span class="ff-jost-medium text-sm">Reduire</span>
					<span class="w-3 h-3">
						<svg style="fill:currentColor;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"><path d="M14.980469 2.980469C14.164063 2.980469 13.433594 3.476563 13.128906 4.230469C12.820313 4.984375 13.003906 5.847656 13.585938 6.414063L32.171875 25L13.585938 43.585938C13.0625 44.085938 12.851563 44.832031 13.035156 45.535156C13.21875 46.234375 13.765625 46.78125 14.464844 46.964844C15.167969 47.148438 15.914063 46.9375 16.414063 46.414063L36.414063 26.414063C37.195313 25.632813 37.195313 24.367188 36.414063 23.585938L16.414063 3.585938C16.035156 3.199219 15.519531 2.980469 14.980469 2.980469Z"/></svg>
					</span>
				</button>
			</div>
			<span ref="reduce"></span>
		</div>
	</div>
</template>
<style>
	.component-loaders-area::-webkit-scrollbar,
	.component-loaders-area *::-webkit-scrollbar{
		width: 0px;
	}
	.minimize-w128{
		animation : displayed .2s ease-in-out;
	}
	.back-blur-329{
		backdrop-filter: blur(10px);-webkit-backdrop-filter: blur(10px);
	}
	@keyframes displayed{
		0%{
			opacity: 0;
			transform: translateX(-200%) scale(.2);
		}
		100%{
			opacity: 1;
			transform: translateX(-50%) scale(1.2);
		}
	}
</style>
