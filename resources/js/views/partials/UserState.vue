<script setup>
import { ElTooltip } from 'element-plus';

import { stats_format } from '../../utils/helpers';

const props = defineProps({
	user : {type : Object, required : true},
});
</script>
<template>
	<div class="flex flex-wrap items-stretch px-4 text-center">
		<template v-for="(stat, index) in stats_format({name : user?.person?.name, stats : user?.stats})" :key="index">
			<div class="p-2 w-full xxs:w-1/2 lg:w-1/4">
				<div class="h-full bg-white rounded-2xl shadow-xl py-4 sm:py-6 lg:py-9 px-4 sm:px-5 lg:px-6 flex flex-col items-center justify-between space-y-3">
					<h5 class="ff-jost-medium opacity-60 text-sm flex flex-col items-center" style="word-break: normal;">
						<span v-if="stat.info" class="inline-block mb-3">
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
			</div>
		</template>
	</div>
</template>