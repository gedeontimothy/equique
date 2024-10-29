<script setup>
import { usePage, router, Head } from '@inertiajs/vue3';
import { useStore } from 'vuex';
import { computed, ref } from 'vue';

import Dashboard from '../../../layouts/Dashboard.vue';
import WindmillPageTitle from "../../../components/titles/WindmillPage.vue";

const props = defineProps({
});

const store = useStore();

const user = computed(() => store.getters['app/auth_user']);
const person = computed(() => store.getters['app/auth_person']);

</script>
<template>
	<Head title="Dashoard"/>
	<Dashboard>
		<div class="container px-6 mx-auto grid">
			<section>
				<WindmillPageTitle title="Create User"/>
			</section>
			<section>
				...
			</section>
		</div>
	</Dashboard>
</template>