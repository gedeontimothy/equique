<script setup>
import { ref, Transition } from 'vue';
import WindmillProfil from '../lists/WindmillProfil.vue';

const props = defineProps({
	menu : {type : Array, default : [
		{
			'title' : 'Profile',
			'href' : '',
			'icon' : 'profile',
		},
		{
			'title' : 'Setting',
			'href' : '',
			'icon' : 'setting',
		},
		{
			'title' : 'Logout',
			'href' : route('logout'),
			'icon' : 'logout',
		},
	]},
	image : {type : String, default : 'http://cdn.net/image/5/1?resize&category=face,person'}
})

const isProfileMenuOpen = ref(false);

const toggleProfileMenu = () => {
	isProfileMenuOpen.value = isProfileMenuOpen.value ? false : true;
};

const closeProfileMenu = () => {
	isProfileMenuOpen.value = false;
}
</script>
<template>
	<div class="relative">
		<button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
			@click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
			aria-haspopup="true">
			<img class="object-cover w-8 h-8 rounded-full"
				:src="image"
				alt="" aria-hidden="true">
		</button>
		<template v-if="isProfileMenuOpen">
			<Transition name="fade">
				<ul v-if="isProfileMenuOpen" @click="closeProfileMenu" @keydown.escape="closeProfileMenu"
					:class="{ 'transition ease-in duration-150 opacity-0': !isProfileMenuOpen, 'opacity-100': isProfileMenuOpen }"
					class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md"
					aria-label="submenu"
					v-show="isProfileMenuOpen"
				>
					<template v-for="(item, index) in menu" :key="index" >
						<li class="flex">
							<WindmillProfil v-bind="item"/>
						</li>
					</template>
				</ul>
			</Transition>
		</template>
	</div>
</template>
<style>
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.15s;
	}
	.fade-enter-from,
	.fade-leave-to {
		opacity: 0;
	}
</style>
