<script setup>
import { ref, Transition } from 'vue';
import WindmillProfil from '../lists/WindmillProfil.vue';

const props = defineProps({
	datas : {type : Array},
	notificationCount : {type : Number, default : 0},
})

const isNotificationsMenuOpen = ref(false);

const toggleNotificationsMenu = () => {
	isNotificationsMenuOpen.value = !isNotificationsMenuOpen.value;
};

const closeNotificationsMenu = () => {
	isNotificationsMenuOpen.value = false;
}
</script>
<template>
	<div class="relative">
		<button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
			aria-label="Notifications"
			aria-haspopup="true"
			@click="toggleNotificationsMenu"
			@keydown.escape="closeNotificationsMenu"
		>
			<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
				<path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
			</svg>
			<!-- Notification badge -->
			<span v-if="notificationCount > 0" aria-hidden="true" class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full"
			></span>
		</button>

		<Transition name="fade">
			<ul
				v-if="isNotificationsMenuOpen"
				@click.self="closeNotificationsMenu"
				class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md"
			>
				<template v-if="datas && datas.length > 0">
					<li><h5>{{ $__('Notif LIST...') }}</h5></li>
				</template>
				<template v-else>
					<li><h5>{{ $__('You haven\'t anything Notification') }}</h5></li>
				</template>
			</ul>
		</Transition>
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
