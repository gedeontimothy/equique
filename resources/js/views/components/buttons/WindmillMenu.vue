<script setup>
import { ref } from 'vue';

const props = defineProps({
	active : {type : Boolean, default : false},
});

const emits = defineEmits(['toggleSideMenu']);

const menuActive = ref(props.active);

const toggleSideMenu = (el) => {
	
	if(menuActive.value) menuActive.value = false;
	else menuActive.value = true;

	emits('toggleSideMenu', {el : el, active : menuActive.value});

}
</script>
<template>
	<button class="p-1 rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleSideMenu" aria-label="Menu">
		<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
			<path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
		</svg>
	</button>
</template>