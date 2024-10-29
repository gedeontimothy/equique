<script setup>
import { ElAvatar } from 'element-plus'
const props = defineProps({
	name : {type : String, required : true},
	subText : String,
	image : String,
	vertical : {type : Boolean, default : false},
});
const format_image_name = (name) => {
	name = name.toUpperCase().split(' '); 
	return name.length == 1 ? name[0][0] + name[0][1] : name[0][0] + name[1][0];
}
</script>
<template>
	<div class="component-cards-profile-29n">
		<div class="flex gap-4" :class="{'flex flex-col items-center' : vertical}">
			<!-- <ElAvatar v-if="image" :alt="$__('Profile Image')" :src="image"/> -->
			<img v-if="image" :alt="$__('Profile Image')" class="rounded-full object-cover" :class="{'w-[56px] h-[56px]' : vertical, 'w-10 h-10' : !vertical}" :src="image" loading="lazy"/>
			<ElAvatar v-else :size="vertical ? 'large' : 'default'" :alt="$__('Profile Image')">{{ format_image_name(name) }}</ElAvatar>
			<div class="font-medium dark:text-white" :class="{'text-center' : vertical}">
				<h3 class="ff-jost-medium" :class="{'text-lg' : vertical}">{{ name }}</h3>
				<div v-if="subText" :class="{'text-sm' : !vertical}" class="text-gray-500 dark:text-gray-400">ss{{ subText }}</div>
			</div>
		</div>
	</div>
</template>