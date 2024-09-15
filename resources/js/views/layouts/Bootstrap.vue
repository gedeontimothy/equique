<script setup>
import { ref, watch, onBeforeMount, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { usePage } from '@inertiajs/vue3';

import Bootstrap from './Bootstrap.vue';
import AreaMain from '../components/areas/Main.vue';
import LoaderSimple from '../components/loaders/Simple.vue';

const store = useStore();
const lang_is_init = computed(() => store.state.lang.is_init);

const page = usePage();

onBeforeMount(() => {
	store.dispatch('app/bootstrap');
})

watch(() => page.props, (n, o) => {
	// console.log(n, store.state.app.page.props)
})

</script>
<template>
	<template v-if="lang_is_init">
		<slot/>
	</template>
	<AreaMain/>
	<LoaderSimple/>
</template>
