<script setup>
import { computed, ref, watch, onBeforeMount } from 'vue';
import { usePage, router, Head, Link } from '@inertiajs/vue3';
import { useStore } from 'vuex';
import { ElSegmented, ElPagination } from 'element-plus'

import Dashboard from '../../layouts/Dashboard.vue';
import WindmillPageTitle from "../../components/titles/WindmillPage.vue";
import CardProfileDetails from "../../components/cards/ProfileDetails.vue";

const props = defineProps({
    users : {type : Object, required : true},
	param_users_type : Number,
	segment : [Array, Object],
});

const store = useStore();
// const user = computed(() => store.getters['app/auth_user']);
// const person = computed(() => store.getters['app/auth_person']);
const segmentValue = ref(props.param_users_type)
const options = ref(props.segment ? Object.values(props.segment) : null);
const currentPage = ref(props.users.meta.current_page);
const statsFormat = (user) => {
	return [
		{
			title : __('manager.user.base.stats.placed-orders.title'),
			value : user.stats.total_orders,
			info : __('manager.user.base.stats.placed-orders.description', {name : user.person.name}),
		},
		{
			title : __('manager.user.base.stats.paided-orders.title'),
			value : user.stats.total_successful_orders,
			info : __('manager.user.base.stats.paided-orders.description'),
		},
		{
			title : __('manager.user.base.stats.in-refundabled-orders.title'),
			value : user.stats.total_refundable_orders,
			info : __('manager.user.base.stats.in-refundabled-orders.description'),
		},
		{
			title : __('manager.user.base.stats.money-spent.title'),
			value : (user.stats?.total_money_spent?.total_purchase_price ?? 0) + '$',
			info : __('manager.user.base.stats.money-spent.description', {name : user.person.name}),
		},
	];
}
const paginationChange = (page) => {
	const page_ = props.users?.meta?.links?.[page]
	if(page_) router.visit(page_.url, {})
}
const im = (url, q = 15) => url.replace(/^(http:\/\/cdn.net\/image)\/\d+(.*)/g, "$1/" + q + "$2&delay=10080");

watch(segmentValue, (new_value, old_value) => {
	router.visit('', {
		data: {...(new_value == 0 ? {'param_users_type' : null} : {'param_users_type' : new_value}), page: 1},
	});
});
onBeforeMount(() => {
	store.dispatch('menu/dashboardActiveMenu', {name : 'users'})
});
</script>
<template>
	<Head title="Dashoard"/>
	<Dashboard>
		<div class="container mx-auto grid">
			<section class="mb-4 px-6">
				<WindmillPageTitle :title="$__('manager.user.base.all-users')"/>
				<ElSegmented v-if="segment" class="
					![--el-segmented-item-selected-bg-color:hsl(26.9,100%,60.6%)]
					![--el-segmented-bg-color:hsla(26.9,100%,60.6%,.2)]
					![--el-segmented-item-hover-bg-color:hsla(0,100%,100%,.5)]
					![--el-segmented-item-active-bg-color:hsla(0,100%,100%,.7)]
					[--el-border-radius-base:30px] 
					ff-jost-medium
				" v-model="segmentValue" :options="options" />
			</section>
			<section>
				<div v-if="users.data && users.data.length > 0" class="flex flex-wrap items-strecth">
					<template v-for="(user, index) in users.data" :key="index">
						<Link :href="route('user.show', {id : user.id})" class="w-full xl:w-1/2 px-2 pb-4">
							<CardProfileDetails 
								class="h-full justify-between space-y-3"
								stat-class=""
								stat-item-class="w-full xs:w-1/2 lg:w-auto lg:flex-1"
								:tag="user.stats.total_refundable_orders > 0 ? $__('main.reimbursement.0') : undefined"
								:stats="statsFormat(user)"
								:statTitle="$__('main.command.1')"
								:image="im(user.person?.file?.url)"
								:name="user.person.name"
								:sub-text="user.username + (user.is == 'user' ? '' : ' (' + user.is + ')')"
							/>
						</Link>
					</template>
				</div>
				<h1 v-else class="ff-jost-medium text-xl md:text-2xl opacity-70 text-center my-10">
					{{ $__('Aucun utilisateur') }}
				</h1>
			</section>
			<section v-if="users.meta.last_page > 1" class="my-5 flex justify-center">
				<ElPagination  @change="paginationChange" :total="users.meta.total" v-model:current-page="currentPage" :page-size="users.meta.per_page" layout="prev, pager, next, jumper"></ElPagination>
			</section>
			<!-- <ElPagination :total="users.meta.total" layout="prev, pager, next" :current-page="users.meta.current_page"></ElPagination> -->
		</div>
	</Dashboard>
</template>
