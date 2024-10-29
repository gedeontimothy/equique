<script setup>
import { computed, onMounted, ref, toRef, watch } from 'vue';
import { usePage, router, Head, Link } from '@inertiajs/vue3';
import { useStore } from 'vuex';
import moment from 'moment';
import { ElPagination, ElTable, ElTableColumn, ElTag, ElTooltip, ElButton, ElPopover, ElCheckbox } from 'element-plus';
import ProgressSpinner from 'primevue/progressspinner';

import { getOrderProductsByOrderId, getOrdersByUserIdWithOptions } from '../../../services/order';
import { get_tag_type, get_tag_name, get_formatted_date, get_service } from '../../../utils/helpers';

import Dashboard from '../../layouts/Dashboard.vue';
import UserState from '../../partials/UserState.vue';
import TableChildOrderProducts from '../../partials/TableChildOrderProducts.vue';
import WindmillPageTitle from "../../components/titles/WindmillPage.vue";
import UserProfile from '../../components/cards/UserProfile.vue';
import { array_key_exists } from '../../../utils/helpers.native';

const props = defineProps({
    user : {type : Object, required : true},
});

const store = useStore();

const 
	user_ = computed(() => store.getters['app/auth_user']),
	person = computed(() => store.getters['app/auth_person'])
	// orderDefSort = computed(() => {
	// 	let sort = orderOptions.value?.sort;
	// 	if(sort){
	// 		// const sort_by = orderOptions.value?.sort;
	// 		const direction = /^\-.*/gi.test(sort) ? 'desc' : 'asc';
	// 		sort = sort.replaceAll(/^\-(.*)/gi, '$1');
	// 		return {prop: sort, order: direction == 'desc' ? 'descending' : 'ascending'}
	// 	}
	// 	return {};
	// }),
;

const 
	init = ref(true),
	order_datas_on_load = ref(0),
	order_datas_is_init = ref(false),
	orders = ref({data : []}),
	orderOptions = ref({sort : '-bought_at'}),
	menu = ref([
		{
			label: __('manager.user.show.remove-user'),
			class : 'text-red-300',
			style : '--el-text-color-regular:red;--el-dropdown-menuItem-hover-color:red;--el-dropdown-menuItem-hover-fill:rgba(255,0,0,.1);',
			// style : '--el-dropdown-menuItem-hover-color:red;',
			icon: cdn('/icon/svg/icons8_trash_can.svg'),
		},
	]),
	orderLink = ref(null),
	orderCurrentPage = ref(orders.value?.meta?.current_page),
	expandedOrder = ref({}),

	filter = toRef({
		order_status : {
			value : [],
			call(value){
				const v = value.join(',');
				if(v != '' && (!orderOptions.value?.['status'] || orderOptions.value['status'] != v))
					orderOptions.value['status'] = v;
				else if(v == '' && array_key_exists('status', orderOptions.value))
					delete orderOptions.value['status'];
			}
		},
	})
;


const
	im = (url, q = 15) => url.replace(/^(http:\/\/cdn.net\/image)\/\d+(.*)/g, "$1/" + q + "$2&delay=10080"),
	createdAt = () => {
		return __('manager.user.base.account-created', {date : moment(new Date(props.user?.data?.created_at)).format('LLLL')});
	},
	LoadOrdersDatas = () => {
		// order_datas_on_load.value = true;
		// let data = await getByUserIdWithOptions(props.user.data.id, orderOptions.value, link);
		orderOptions.value['user_id'] = props.user.data.id;
		// let data = await get_service(orderLink.value);
		// orders.value = data;
		// order_datas_on_load.value = false;
	},
	handleT = (...e) => {
		console.log(e)
	},
	loadOrder = async () => {
		order_datas_on_load.value += 1;
		let data = await get_service(orderLink.value);
		orders.value = data;
		expandedOrder.value = {};
		order_datas_on_load.value -= 1;
	},
	handleOrderExpandChange = async (row) => {
		if((row?.id !== null || row?.id !== undefined) && !expandedOrder.value?.['_' + row?.id]){
			order_datas_on_load.value += 1;
			let datas = await getOrderProductsByOrderId(row.id, {without_order : 1, 'file-product-aa' : ''});
			// console.log(datas);
			expandedOrder.value['_' + row.id] = datas;
			// expandedOrder.value.push(row.id);
			// console.log(expandedOrder.value);
			order_datas_on_load.value -= 1;
		}
	},
	handleOrderAction = (props_) => {
		let status = props_.row?.status;
		switch (status) {
			case 0:
				
				break;
			default:
				alert('Error')
				break;
		}
	},
	handleOrderStatusFilter = (index, is_ch) => {
		const is_active = filter.value.order_status.value.includes(index);
		if(is_active && !is_ch){
			filter.value.order_status.value = filter.value.order_status.value.filter((i) => index != i);
		}
		else if(is_ch && !is_active)
			filter.value.order_status.value.push(index);
			// if(is_ch && is_active)
		// else
		// console.log(filter.value.order_status.value);
	},
	paginationChange = async (page) => {
		const page_ = orders.value?.meta?.links?.[page]
		if(page_?.url)
			orderLink.value = page_?.url;
	},
	dd = (datas) => {
		return datas?.meta?.total > datas?.meta?.per_page
			? __('Voir la commande et tous les :count produits restants', {count : datas?.meta?.total - datas?.meta?.per_page})
			: __('Voir les détails de la commande');
	},
	cdn_ = cdn
;


onMounted(async () => {
	store.dispatch('menu/dashboardDisableActiveMenu');
	await LoadOrdersDatas();
	order_datas_is_init.value = true;
});

watch(orderOptions.value, (new_value, old_value) => {
	orderLink.value = route('find.orders.by.user.id.with.options', new_value);
})
watch(filter.value, (new_value, old_value) => {
	for(var type in new_value){
		new_value[type].call(new_value[type].value)
	}
})

watch(orderLink, async () => {
	await loadOrder();
})



// (() => {
// 	console.log(route('find.orders.by.user.id.with.options', {user_id : 4, ...orderOptions.value}));
// })()
</script>
<template>
	<Head title="Dashoard"/>
	<Dashboard>
		<div class="container p-4 lg:p-8 xl:p-12 mx-auto grid space-y-4">
			<section v-if="true" class="">
				<UserProfile :created-at="createdAt()" :username="user?.data?.username" :name="user?.data?.person?.name" :image="im(user?.data?.person?.file?.url, 30)" :menu="menu"/>
			</section>
			<section v-if="true" class="">
				<UserState :user="user?.data"/>
			</section>
			<template v-if="!order_datas_on_load || order_datas_is_init">
				<section class="w-full">
					<div class="group bg-white shadow-lg rounded-3xl py-10 px-4 w-full">
						<div class="flex items-center justify-between px-4 space-x-4 relative z-10">
							<h2 class="text-neutral-600 group-hover:text-black duration-300 text-lg sm:text-xl lg:text-2xl">{{ $__('Commandes') }}</h2>
							<div class="flex flex-wrap space-x-3">
								
								<ElPopover width="320" trigger="click" placement="auto">
									<template #reference>
										<button class="w-8 h-8 p-2 rounded-full bg-neutral-100 flex items-center justify-center text-black">
											<x-svg class="w-full h-full" :xref="cdn_('/icon/svg/icons8_filter.svg')"/>
										</button>
									</template>
									<div>
										<div class="flex justify-between">
											<h3 class="ff-jost-medium text-base">{{ $__('Filtre') }}</h3>
										</div>
										<div class="mt-2 flex flex-col divide-y divide-black divide-opacity-10">
											<div class="py-2">
												<h4 class="mb-1">{{ $__('Status') }}</h4>
												<div class="flex flex-wrap">
													<template v-for="x in 5" :key="x">
														<div class="p-1">
															<ElCheckbox @change="(...e) => handleOrderStatusFilter(x-1, ...e)" :checked="filter.order_status.value.includes(x-1)" border :label="get_tag_name(x-1)"/>
														</div>
													</template>
												</div>
											</div>
											<!-- <div class="py-2">
												<h4>{{ $__('Lorem') }}</h4>
												<div class="content">ll</div>
											</div> -->
										</div>
									</div>
								</ElPopover>
								<button class="w-8 h-8 p-2 rounded-full bg-neutral-100 flex items-center justify-center text-black" :class="{'bg-neutral-700 text-white' : order_datas_on_load}" @click="loadOrder()">
									<x-svg :class="{'rotate-inf' : order_datas_on_load}" class="w-full h-full" :xref="cdn_('/icon/svg/icons8_available_updates.svg')"/>
								</button>
							</div>
						</div>
						<!-- :default-sort="orderDefSort" -->
						<el-table size="large" @expand-change="handleOrderExpandChange" :data="orders.data" style="width : 100%;" :empty-text="$__('Aucune donnée')">
							<el-table-column type="expand">
								<template #default="props">
									<!-- props?.row?.id -->
									<template v-if="expandedOrder?.['_' + props?.row?.id]">
										<div class="px-6">
											<div class="overflow-hidden overflow-y-auto max-h-[80vh]">
												<TableChildOrderProducts v-bind="{order : props.row, ...expandedOrder['_' + props.row.id]}"/>
											</div>
											<div class="text-center underline first-color-dark-10 py-3">
												<Link :href="route('order.show', {id : props.row.id})">{{ dd(expandedOrder['_' + props.row.id]) }}</Link>
											</div>
										</div>
									</template>
									<template v-else>
										<div class="flex justify-center">
											<ProgressSpinner/>
										</div>
									</template>
								</template>
							</el-table-column>
							<el-table-column prop="status" :label="$__('Status')">
								<template #default="props">
									<el-tag :type="get_tag_type(props.row.status)" :effect="props.row.status == '0' ? 'dark' : null">
										{{ get_tag_name(props.row.status) }}
									</el-tag>
								</template>
							</el-table-column>
							<el-table-column prop="bought_at" :label="$__('Date d\'achat')">
								<template #default="props">
									{{ get_formatted_date(props.row.bought_at) }}
								</template>
							</el-table-column>
							<el-table-column :label="$__('Prix acheter')">
								<template #default="props">
									{{ props.row.purchase_price ? (props.row.purchase_price + '$') : '...' }}
								</template>
							</el-table-column>
							<el-table-column :label="$__('Actions')">
								<template #default="props">
									<div class="flex space-x-3">
										<template v-if="props.row.status == 1">
											<el-button plain type="primary" @click="(...e) => handleOrderAction(props, ...e)">
												<div class="flex items-center justify-between space-x-2">
													<span>{{ $__('Vérifier la validité de la commande') }}</span>
													<el-tooltip
														class="box-item"
														placement="auto"
														effect="light"
													>
														<template #content>
															<div class="max-w-72 text-center" style="word-break: normal;" v-html="$__('Vérifier si l\'utilisateur est toujours sur le point d\'acheter sa commande, si ce n\'est pas le cas alors cette commande sera automatiquement annulé', {name : props.row.user.person.name})"></div>
														</template>
														<button class="w-4 h-4">
															<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896m0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768m48-176a48 48 0 1 1-96 0 48 48 0 0 1 96 0m-48-464a32 32 0 0 1 32 32v288a32 32 0 0 1-64 0V288a32 32 0 0 1 32-32"></path></svg>
														</button>
													</el-tooltip>
												</div>
											</el-button>
										</template>
										<template v-if="props.row.status == 3">
											<el-button plain type="success" @click="(...e) => handleOrderAction(props, ...e)">
												<div class="flex items-center justify-between space-x-2">
													<span>{{ $__('Marqué comme livré') }}</span>
													<el-tooltip
														class="box-item"
														placement="auto"
														effect="light"
													>
														<template #content>
															<div class="max-w-56 text-center" style="word-break: normal;" v-html="$__('Si vous le <span class=\'ff-jost-medium text-green-600\'>marquez comme livré</span>, vous confirmez que tous les produits de cette commandes ont été livré ou remise à :name', {name : props.row.user.person.name})"></div>
														</template>
														<button class="w-4 h-4">
															<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896m0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768m48-176a48 48 0 1 1-96 0 48 48 0 0 1 96 0m-48-464a32 32 0 0 1 32 32v288a32 32 0 0 1-64 0V288a32 32 0 0 1 32-32"></path></svg>
														</button>
													</el-tooltip>
												</div>
											</el-button>
										</template>
										<template v-if="props.row.status == 4">
											<el-button plain type="warning" @click="(...e) => handleOrderAction(props, ...e)">
												<div class="flex items-center justify-between space-x-2">
													<span>{{ $__('Marqué comme remboursé') }}</span>
													<el-tooltip
														class="box-item"
														placement="auto"
														effect="light"
													>
														<template #content>
															<div class="max-w-56 text-center" style="word-break: normal;" v-html="$__('Si vous le <span class=\'ff-jost-medium text-green-600\'>marquez comme remboursé</span>, vous confirmez que tous les produits de cette commandes ont été remboursé à :name', {name : props.row.user.person.name})"></div>
														</template>
														<button class="w-4 h-4">
															<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896m0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768m48-176a48 48 0 1 1-96 0 48 48 0 0 1 96 0m-48-464a32 32 0 0 1 32 32v288a32 32 0 0 1-64 0V288a32 32 0 0 1 32-32"></path></svg>
														</button>
													</el-tooltip>
												</div>
											</el-button>
										</template>
									</div>
								</template>
							</el-table-column>
						</el-table>
						<div class="flex justify-center mt-5" v-if="orders?.meta?.last_page && orders?.meta?.last_page > 1">
							<ElPagination @change="paginationChange" :total="orders?.meta?.total" v-model:current-page="orderCurrentPage" :page-size="orders?.meta?.per_page" layout="prev, pager, next, jumper"></ElPagination>
						</div>
					</div>
				</section>
			</template>
			<template v-else>
				<section class="">
					on loading table data
				</section>
			</template>
		</div>
	</Dashboard>
</template>
<style>
.el-table thead th{
	font-family: 'Jost Medium';
	font-weight: normal;
}
.rotate-inf{
	animation : rot-inf 1s linear infinite;
}
@keyframes rot-inf{
	0%{transform: rotate(0deg);}
	100%{transform: rotate(360deg);}
}
</style>