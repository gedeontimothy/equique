<script setup>
import {computed, ref, watch} from 'vue';
import {useStore} from 'vuex';
import LoaderMain from './Main.vue';

const store = useStore();
const loading = computed(() => store.getters['app/onLoading'])

</script>
<template>
	<template v-if="loading">
		<div class="flex items-center justify-center w-screen h-screen bg-white bg-opacity-100 fixed top-0 left-0 z-50">
			<LoaderMain/>
		</div>
	</template>
</template>
