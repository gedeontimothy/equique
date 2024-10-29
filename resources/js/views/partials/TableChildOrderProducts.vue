<script setup>
import { computed, onBeforeMount, onMounted, ref, toRef } from 'vue';
import { ElTable, ElTableColumn, ElTag, ElTooltip, ElButton, ElInputNumber, ElMessage, ElPopover, ElImage } from 'element-plus';

// import { get_tag_type, get_tag_name, get_formatted_date, get_service } from '../../utils/helpers';
import { ucfirst } from '../../utils/helpers.native';

import MinProduct from '../components/cards/MinProduct.vue';
import { Link } from '@inertiajs/vue3';
import { orderProductUpdate } from '../../services/order_product';

const props = defineProps({
	title : {type : String, default : 'Les produits de la commande'},
	description : {type : String, default : 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dicta quas sint consectetur.'},
	data : {type : Object},
	meta : {type : Object},
	links : {type : Object},
	errors : {type : Object},
	order : {type : Object}
});

const 
	updated_datas = toRef({}),
	on_action = ref(0),
	datas = ref([])
;
const is_modified = computed(() => {
	return (data) => {
		const k = '_' + data.id;
		for(var type in updated_datas.value[k]){
			const el = updated_datas.value[k][type];
			if(el.old_value != el.new_value)
				return true;
		}
		return false;
	}
});

onBeforeMount(() => {
	datas.value = [...props.data];
	datas.value.forEach(element => {
		const k = '_' + element.id;
		updated_datas.value[k] = {}
		initQuantityDistibuted(element);
	});
	// console.log(props.order);
});

// ---- Methods
const
	get_max = (row) => {
		return props.order.status == 4 ? row.quantity_distributed : row.product.stock < (row.quantity - row.quantity_distributed) ? row.product.stock : row.quantity;
	},
	get_min = (row) => {
		return props.order.status == 4 ? 0 : row.quantity_distributed;
	},
	handleQuantityChange = (data, props, new_val, old_val) => {
		const k = '_' + data.id;
		const up_data = updated_datas.value[k]['quantity_distributed'];
		const diff = up_data.new_value - up_data.old_value;
		if(data.product.stock > 0 && (data.product.stock - diff) >= 0){
			// console.log('ok')
		}
		else {
			up_data.new_value = up_data.old_value;
		}
		// console.log(updated_datas.value[k], data)
		// console.log(new_val, old_val)
	},
	initBase = (type, data, options = {}) => {
		const k = '_' + data.id;
		// console.log(data)
		if(!updated_datas.value[k]?.[type]) updated_datas.value[k] = {[type] : {}};
		
		updated_datas.value[k][type] = options;
		
		return updated_datas.value[k][type].new_value;
	},
	initQuantityDistibuted = (data) => {
		if(props.order.status != 1)
			initBase('quantity_distributed', data, {
				old_value : data['quantity_distributed'],
				new_value : data['quantity_distributed'],
				async updateCall(data, updated_datas){
					const response = await orderProductUpdate({quantity_distributed : updated_datas.new_value}, {order_product : data.id});
					if(response?.errors){
						ElMessage({message : response?.message ? response?.message : __('Echec de la mise à jour de la quantité distribuer'), type : 'error'})
						return Promise.resolve({data : response, error_state : true});
					}
					else{
						ElMessage({message : __('Mise à jour de la quantité distribuer effectué'), type : 'success'});
					}
					return Promise.resolve({data : response, error_state : false});
					// console.log(JSON.stringify(data), JSON.stringify(updated_datas))
				},
			});
	},
	cdn_ = (e) => cdn(e),
	// updateOrderProduct = async (key) => {
	// 	console.log(updated_datas.value[key])
	// },
	isInsufficientStock = (row) => {
		return props.order.status == 4 || props.order.status == 0 ? false : (row.quantity - row.quantity_distributed) > row.product.stock;
	}
;

// ---- Emits
const
	handleUpdateOrderProduct = async (props, ...e) => {
		const k = '_' + props.row.id,
		up_d = updated_datas.value[k];
		if(up_d?.__load == false || up_d?.__load == undefined){
			updated_datas.value[k].__load = true;
			for(var type in up_d){
				if(up_d[type]?.updateCall){
					const response = await up_d[type].updateCall(props.row, up_d[type]);
					if(!response.error_state){
						updated_datas.value[k][type].old_value = updated_datas.value[k][type].new_value;
					}
				}
			}
			updated_datas.value[k].__load = false;
		}
		else{ElMessage({message : __('Mise à jour déjà en cours...'), type : 'warning'})}
		// await updateOrderProduct(k)
	}
;

const prevList = (product_files) => {
	return product_files.map((e) => e.file.url);
}

/* 
<template v-for="(item, index) in data" :key="index">
	<div class="p-2 md:1/3 lg:w-1/2">
		<MinProduct :title="item.product.name"/>
	</div>
</template>
 */
</script>

<template>
	<div>
		<h2 class="text-xl md:text-2xl mb-1">{{ title }}</h2>
		<p class="opacity-70 mb-4">{{ description }}</p>
		<div class="w-full">
			<ElTable :data="datas" style="width : 100%;" :empty-text="$__('Aucune donnée')">
				<ElTableColumn :label="$__('Nom du produit')">
					<template #default="props">
						<Link :href="route('product.show', {id : props.row.product.id})">{{ ucfirst(props.row.product.name) }}</Link>
						<ElPopover v-if="props.row?.product?.product_files?.length > 0" trigger="click" placement="right">
							<template #reference>
								<ElButton class="!w-6 !h-6 ml-2" plain circle>
									<template #icon>
										<x-svg class="!w-3 !h-3" :xref="cdn_('/icon/svg/icons8_image.svg')" />
									</template>
								</ElButton>
							</template>
							<div class="flex space-x-2">
								<template v-for="(item, index) in props.row.product.product_files" :key="index">
									<ElImage
										class="w-[60px] h-[60px] rounded-xl"
										:src="item.file.url"
										:initial-index="index"
										:preview-src-list="prevList(props.row.product.product_files)"
										fit="cover"
									/>
								</template>
							</div>
						</ElPopover>
					</template>
				</ElTableColumn>
				<ElTableColumn prop="quantity" :label="$__('Quantité demander')"/>
				<ElTableColumn v-if="order.status != 1 && order.status != 0" :label="$__('Quantité distribuer')">
					<template #default="props">
						<span v-if="props.row.quantity_distributed == props.row.quantity || (order.status == 4 && props.row.quantity_distributed == 0)" class="">{{ props.row.quantity_distributed }}</span>
						<el-input-number v-else v-model="updated_datas['_' + props.row.id]['quantity_distributed'].new_value" :min="get_min(props.row)" :max="get_max(props.row)" @change="(...e) => handleQuantityChange(props.row, props, ...e)" />
					</template>
				</ElTableColumn>
				<ElTableColumn :label="$__('Stock du produit')">
					<template #default="props">
						<span :class="{'text-red-500 ff-jost-medium' : isInsufficientStock(props.row)}">{{ props.row.product.stock }}</span>
					</template>
				</ElTableColumn>
				<ElTableColumn :label="$__('Prix')">
					<template #default="props">
						{{ props.row.price }}$
					</template>
				</ElTableColumn>
				<ElTableColumn :label="$__('Prix unitaire')">
					<template #default="props">
						{{ props.row.product.price }}$
					</template>
				</ElTableColumn>
				<ElTableColumn :label="$__('Actions')">
					<template #default="props">
						<div class="flex">
							<div :class="{'hidden' : !is_modified(props.row)}">
								<ElTooltip
									class="box-item"
									placement="left"
									effect="light"
								>
									<template #content>
										<div class="max-w-72 text-center" style="word-break: normal;" v-html="$__('Mettre à jour')"></div>
									</template>
									<ElButton @click="(...e) => handleUpdateOrderProduct(props, ...e)" type="success" plain circle>
										<template #icon>
											<x-svg class="h-4 w-4" :xref="cdn_('/icon/svg/icons8_available_updates.svg')" />
										</template>
									</ElButton>
								</ElTooltip>
							</div>
						</div>
					</template>
				</ElTableColumn>
			</ElTable>
		</div>
	</div>
</template>