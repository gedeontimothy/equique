<script setup>
	const props = defineProps({
		state : {type : Number, default : 1},
		label : {type : String},
		description : {type : String, default : null},
	});
</script>
<template>
	<div class="flex items-center space-x-3">
		<span :data-state="state ?? ''" class="state-e9e2 w-4 h-4 overflow-hidden rounded-full relative z-[1]">
			<span class="error-sd2 bg-red-500 p-1 text-white">
				<svg style="fill:currentColor;" class="svg-delete" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M39.486328 6.9785156 A 1.50015 1.50015 0 0 0 38.439453 7.4394531L24 21.878906L9.5605469 7.4394531 A 1.50015 1.50015 0 0 0 8.484375 6.984375 A 1.50015 1.50015 0 0 0 7.4394531 9.5605469L21.878906 24L7.4394531 38.439453 A 1.50015 1.50015 0 1 0 9.5605469 40.560547L24 26.121094L38.439453 40.560547 A 1.50015 1.50015 0 1 0 40.560547 38.439453L26.121094 24L40.560547 9.5605469 A 1.50015 1.50015 0 0 0 39.486328 6.9785156 z"/></svg>
			</span>
			<span class="loading-e28 bg-black bg-opacity-5 dark:bg-white dark:bg-opacity-10 rounded-full border-l-2 border-t-2 border-black border-opacity-10 dark:border-white dark:border-opacity-20"></span>
			<span class="success-92d text-green-500">
				<svg style="fill:currentColor;" class="svg-checked-radio-button" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path d="M12 2C6.4889971 2 2 6.4889971 2 12C2 17.511003 6.4889971 22 12 22C17.511003 22 22 17.511003 22 12C22 6.4889971 17.511003 2 12 2 z M 12 4C16.430123 4 20 7.5698774 20 12C20 16.430123 16.430123 20 12 20C7.5698774 20 4 16.430123 4 12C4 7.5698774 7.5698774 4 12 4 z M 12 6C8.686 6 6 8.686 6 12C6 15.314 8.686 18 12 18C15.314 18 18 15.314 18 12C18 11.232 17.849891 10.501172 17.587891 9.8261719L12 15.414062L8.2929688 11.707031L9.7070312 10.292969L12 12.585938L16.521484 8.0644531C15.421484 6.8024531 13.806 6 12 6 z"/></svg>
			</span>
		</span>
		<div :class="'flex-1 flex flex-col space-y-1' + (state === 0 ? ' dark:text-red-300 text-red-700' : (state === 2 ? ' text-green-800 dark:text-green-300' : ''))">
			<h5 class="ff-jost text-sm">{{ label }}</h5>
			<template v-if="description">
				<p class="ff-jost opacity-75 text-xs">{{ description }}</p>
			</template>
		</div>
	</div>
</template>
<style scoped>
	.state-e9e2 > *{
		opacity: 0;
		position: absolute;
		left:0; right: 0; top: 0; bottom: 0;
		margin: auto;
		width: 100%; height: 100%;
		transition: all .7s;
	}
	.state-e9e2[data-state="0"] .error-sd2,
	.state-e9e2[data-state="1"] .loading-e28,
	.state-e9e2[data-state=""] .loading-e28,
	.state-e9e2[data-state="2"] .success-92d {
		opacity: 1;
	}
	.state-e9e2[data-state=""] .loading-e28 {border-color: transparent;}
	.state-e9e2[data-state="1"] .loading-e28{
		animation: rotate-inf 2s linear infinite;
	}
	@keyframes rotate-inf {
		0%{
			transform: rotate(0deg);
		}
		100%{
			transform: rotate(360deg);
		}
	}
</style>
