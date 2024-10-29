<script setup>
import WindmillState from '../components/cards/WindmillState.vue';
const props = defineProps({
	datas : {type : [Array, Object], required : true},
});
</script>
<template>
	<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
		<template v-for="(item, index) in datas" :key="index">
			<WindmillState v-bind="item"/>
		</template>
	</div>
</template>