<script setup>
// import { usePage, router } from '@inertiajs/vue3';
import { useStore } from 'vuex';
import { computed, ref } from 'vue';

import Dashboard from '../../layouts/Dashboard.vue';

const store = useStore();

const user = computed(() => store.getters['app/auth_user']);
const person = computed(() => store.getters['app/auth_person']);

</script>
<template>
	<Dashboard>
		Dash Page {{ person('firstname') + ' ' + person('name') }}
	</Dashboard>
</template>