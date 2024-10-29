<script setup>
import { usePage, router, Head } from '@inertiajs/vue3';
import { useStore } from 'vuex';
import { computed, ref } from 'vue';

import Dashboard from '../../layouts/Dashboard.vue';
import StatePartial from '../../partials/State.vue';
import WindmillPageTitle from "../../components/titles/WindmillPage.vue";

const props = defineProps({
	stats : {type : Object},
});

const store = useStore();

const user = computed(() => store.getters['app/auth_user']);
const person = computed(() => store.getters['app/auth_person']);

store.dispatch('menu/dashboardActiveMenu', {name : 'dashboard'})

</script>
<template>
	<Head title="Dashoard"/>
	<Dashboard>
		<div class="container px-6 mx-auto grid">
			<section>
				<WindmillPageTitle title="Dashoard"/>
			</section>
			<section>
				<StatePartial :datas="[
					{value : stats.total_users, title : $__('Total d\'utilisateur'), icon : 'users', color : 'red'},
					{value : stats.total_sum_payment + ' $', title : $__('Revenu total'), icon : 'money', color : 'green'},
					{value : stats.total_product_sold, title : $__('Total des produits vendu'), icon : 'product'},
					{value : stats.total_order, title : $__('Total des commandes'), icon : 'deviation', color : 'blue'},
				]"/>
			</section>
		</div>
	</Dashboard>
</template>