<script setup>
import WindmillMenu from '../buttons/WindmillMenu.vue';
import WindmillSearchInput from '../forms/WindmillSearchInput.vue';
import WindmillNotificationButton from '../menus/WindmillNotificationButton.vue';
import WindmillProfilButton from '../menus/WindmillProfilButton.vue';

const props = defineProps({
	profilImage : String 
});
</script>
<template>
	<header class="z-10 py-4 bg-white shadow-md">
		<div class="container flex items-center justify-between h-full px-6 mx-auto first-color-default">
			<!-- Mobile hamburger -->
			<WindmillMenu class="md:hidden mr-5 -ml-1"/>
			<!-- Search input -->
			<div class="flex justify-center flex-1 lg:mr-32">
				<WindmillSearchInput :holder="$__('main.search') + '...'" class="max-w-xl"/>
			</div>
			<ul class="flex items-center flex-shrink-0 space-x-6">
				<!-- Notifications menu -->
				<li class="relative">
					<WindmillNotificationButton/>
				</li>
				<!-- Profile menu -->
				<li>
					<WindmillProfilButton :image="profilImage"/>
				</li>
			</ul>
		</div>
	</header>
</template>