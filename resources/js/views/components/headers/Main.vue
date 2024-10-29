<script setup>
import {ref} from 'vue'
// import WindmillMenu from '../buttons/WindmillMenu.vue';
// import WindmillSearchInput from '../forms/WindmillSearchInput.vue';
import WindmillNotificationButton from '../menus/WindmillNotificationButton.vue';
import WindmillProfilButton from '../menus/WindmillProfilButton.vue';
import { ElIcon, ElInput } from 'element-plus';

const input4 = ref('');

const props = defineProps({
	profilImage : String 
});

</script>
<template>
	<header class="component-headers-main-9w12 flex items-center space-x-4 z-10 p-4 bg-white">
		<div class="flex-1">
			<el-input
				v-model="input4"
				size="large"
				:placeholder="$__('main.search') + '...'"
			>
				<template #prefix>
					<el-icon class="el-input__icon">
						<x-svg xref="http://cdn.net/icon/svg/icons8_fluent_search.svg"/>
					</el-icon>
				</template>
			</el-input>
		</div>
		<div>
			<WindmillNotificationButton/>
		</div>
		<div class="">
			<WindmillProfilButton :image="profilImage"/>
		</div>
	</header>
</template>
<style>
/* .component-headers-main-9w12 .el-input input:focus,  */
.component-headers-main-9w12 .el-input input
{
	outline: none;
	border-color: transparent;
	box-shadow: none;
}
.component-headers-main-9w12 .is-focus .el-input__prefix{
	color:hsla(26.9, 100%, 60.6%);
}
.component-headers-main-9w12 .el-input {
	width: 100%;
	--el-input-border-radius: 10px;
	--el-input-focus-border-color:hsla(26.9, 100%, 80.6%);
}
</style>