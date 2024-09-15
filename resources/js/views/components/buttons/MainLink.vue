<script setup>
import { computed } from "vue";
import { Link } from '@inertiajs/vue3'

const props = defineProps({
	title : {type : String, required : true},
	color : {type : String},
	borderColor : {type : String},
	disabled : {type : Boolean, default : false},
	mini : {type : Boolean, default : false},
	
	as : {type : String, default : 'button'},
	href : {type : String},
	method : {type : String},
	datas : {type : Object},
	headers : {type : Object},
	replace : {type : Boolean},
	preserveState : {type : Boolean},
	preserveScroll : {type : Boolean},
	only : {type : [Array, Object]},
});
const color_ = computed(() => ({
	base : props.color == 'danger'
		? 'bg-red-500 hover:bg-red-600 text-white'
		: 'first-bg-color-default first-bg-color-opacity-50 hover:first-bg-color-opacity-80 text-black'
	,
	border : props.borderColor == 'danger' || (!props.borderColor && props.color == 'danger')
		? 'border-red-600'
		: 'first-border-color-default'
	,
})
)
</script>
<template>
	<Link :only="only" :preserveState="preserveState" :preserveScroll="preserveScroll" :headers="headers" :replace="replace" :href="href" :datas="datas" :method="method" :class="'ff-jost rounded-2xl border-[3px] px-6 py-2 ' + (mini ? 'text-sm ' : '') + Object.values(color_).join(' ')" :as="as" :disabled="disabled">{{ title }}</Link>
</template>
