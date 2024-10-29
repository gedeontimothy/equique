<script setup>
import { ElDropdown, ElDropdownItem, ElDropdownMenu } from 'element-plus';
import { is_object, is_string } from '../../../utils/helpers.native';

const props = defineProps({
	image : {type : String},
	coverImage : {type : String},
	name : {type : String, required : true},
	username : {type : String, required : true},
	menu : {type : Array},
	createdAt : String,
});
</script>
<template>
	<div class="component-cards-user-profile-we92">
		<div class="overflow-hidden rounded-2xl bg-white shadow-2xl shadow-neutral-200">
			<div class="pt-16 pl-8 relative z-[1]">
				<div class="absolute top-0 left-0 w-full h-full flex z-[-1] overflow-hidden">
					<img class="w-full h-full first-bg-color-default object-cover blur-3xl overflow-hidden" :src="coverImage ?? image" alt="">
				</div>
				<!-- <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tl from-[hsla(26.9,100%,50.6%,1)] to-[hsla(26.9,100%,60.6%,1)] z-[-1]"></div> -->
				<img class="w-44 h-44 rounded-full border-8 bg-gray-50 border-white object-cover transform translate-y-1/2" :src="image" alt="">
			</div>
			<div class="p-8">
				<div class="flex justify-end">
					<ElDropdown trigger="click">
						<button class="flex flex-col text-neutral-400 active:text-black focus:text-black space-y-0.5 outline-none p-1">
							<template v-for="x in 3" :key="x">
								<span class="bg-current transition-colors duration-200 rounded-full p-0.5"></span>
							</template>
						</button>
						<template #dropdown>
							<ElDropdownMenu>
								<template v-for="(item, index) in menu" :key="index">
									<ElDropdownItem :class="item?.class" :style="item?.style">
										<div class="flex items-center space-x-2">
											<span class="w-3 h-3" v-if="is_object(item?.icon) || is_string(item?.icon)" v-svg="item?.icon">ss</span>
											<span>{{ item.label }}</span>
										</div>
									</ElDropdownItem>
								</template>
							</ElDropdownMenu>
						</template>
					</ElDropdown>
				</div>
				<div class="mt-16 space-y-2">
					<h3 class="ff-jost-bold text-xl">{{ name }}</h3>
					<div class="flex flex-wrap items-center">
						<h5 class="opacity-70">@{{ username }}</h5>
						<template v-if="createdAt">
							<span class="separate"></span>
							<h5 class="opacity-70">{{ createdAt }}</h5>
						</template>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<style scoped>
.separate{
	margin-left: 8px;
	background-color: gray;
	opacity:.6;
	border-radius: 40px;
	width: 6px;height: 6px;
	margin-right: 8px;
}
</style>