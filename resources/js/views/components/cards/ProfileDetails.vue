<script setup>
import { ElTooltip, ElTag } from 'element-plus'
import CardProfile from "./Profile.vue";
const props = defineProps({
	name : {type : String, required : true},
	subText : String,
	image : String,
	
	tag : {type : String},
	
	stats : [Array, Object],
	statTitle : String,
	statClass : String,
	statItemClass : String,
});
const format_image_name = (name) => {
	name = name.toUpperCase().split(' '); 
	return name.length == 1 ? name[0][0] + name[0][1] : name[0][0] + name[1][0];
}
</script>
<template>
	<div class="component-cards-profil-details-29ee bg-white shadow-xl shadow-neutral-200 hover:shadow-neutral-300 transform scale-95 hover:scale-100 transition-all p-5 flex flex-col rounded-2xl">
		<CardProfile vertical :image="image" :name="name" :sub-text="subText"/>
		<div v-if="stats && statTitle" class="space-y-4 mt-2 text-center">
			<h3 class="ff-jost-medium">{{ statTitle }}</h3>
			<div class="flex flex-wrap px-4 lg:divide-x" :class="{[statClass] : statClass}">
				<template v-for="(stat, index) in stats" :key="index">
					<div class="flex flex-col items-center justify-between space-y-2" :class="{[statItemClass] : statItemClass}">
						<h5 class="ff-jost-medium opacity-60 text-sm px-3 flex flex-col" style="word-break: normal;">
							<span v-if="stat.info" class="inline-block">
								<el-tooltip
									class="box-item"
									placement="top"
									effect="light"
								>
									<template #content>
										<div class="max-w-56 text-center" style="word-break: normal;" v-html="stat.info"></div>
									</template>
									<button class="w-4 h-4">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896m0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768m48-176a48 48 0 1 1-96 0 48 48 0 0 1 96 0m-48-464a32 32 0 0 1 32 32v288a32 32 0 0 1-64 0V288a32 32 0 0 1 32-32"></path></svg>
									</button>
								</el-tooltip>
							</span>
							<span class="!break-normal">{{ stat.title }}</span>
						</h5>
						<p class="text-lg ff-jost-semibold">{{ stat.value }}</p>
					</div>
				</template>
			</div>
		</div>
		<el-tag v-if="tag" type="danger" round :size="'large'" class="absolute top-4 right-4" style="margin-top:0 !important;">{{ tag }}</el-tag>
	</div>
</template>