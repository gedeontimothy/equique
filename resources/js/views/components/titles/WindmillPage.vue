<script setup>
const props = defineProps({
	title : {type : String, required : true},
});
</script>
<template>
	<h2 class="my-6 text-2xl ff-jost-medium text-gray-700">
		{{ title }}
	</h2>
</template>