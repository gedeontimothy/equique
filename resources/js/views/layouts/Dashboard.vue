<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const user = computed(() => store.getters['app/auth_user']);

// const props = defineProps({});

</script>
<template>
	<div>
		<div>Dashboard Layout</div>
		<slot></slot>
	</div>
</template>
