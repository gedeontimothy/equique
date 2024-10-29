<script setup>
import { ref, Transition } from 'vue';
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
	title : {type : String, required : true},
	icon : String,
	href : String,
	active : {type : Boolean, default : false},
	more : {type : Array},
});

const isPagesMenuOpen = ref(false);

const togglePagesMenu = () => {
	if(props.more && props.more.length > 0){
		isPagesMenuOpen.value = !isPagesMenuOpen.value;
	}
	else{
		router.visit(props.href);
	}
};
</script>
<template>
	<div class="relative px-6 py-3">
		<template v-if="active">
			<span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
		</template>
		<button
			class="inline-flex items-center w-full text-sm ff-jost-medium transition-colors duration-150 hover:text-gray-800 "
			:class="{'text-gray-800' : active, 'hover:text-gray-800' : !active, 'justify-between' : more && more.length > 0}"
			@click="togglePagesMenu"
			:aria-haspopup="more && more.length > 0 ? 'true' : undefined"
		>
			<span class="inline-flex items-center">
				<x-svg v-if="icon" class="w-5 h-5 mr-4" :xref="icon"/>
				<span class="ff-jost">{{ $__(title) }}</span>
			</span>
			<svg v-if="more && more.length > 0" class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
				<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
			</svg>
		</button>
		<template v-if="more && more.length > 0">
			<Transition name="fade">
				<ul
					v-if="isPagesMenuOpen"
					class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50"
					aria-label="submenu"
				>
					<template v-for="(item, index) in more" :key="index">
						<li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800">
							<Link class="w-full" :href="item.href ?? ''">{{ $__(item.title) }}</Link><!-- Login, Create account, Forgot password, 404 -->
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
		transition: all 0.3s ease-in-out;
	}
	.fade-enter-from {
		opacity: 0;
		max-height: 0;
	}
	.fade-enter-to {
		opacity: 1;
		max-height: 1000px; /* A large value to ensure smooth expansion */
	}
	.fade-leave-from {
		opacity: 1;
		max-height: 1000px;
	}
	.fade-leave-to {
		opacity: 0;
		max-height: 0;
	}
</style>
