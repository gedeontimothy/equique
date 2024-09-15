<script setup>
import GoogleAuth from '../components/buttons/GoogleAuth.vue';
import SelectLang from '../components/forms/SelectLang.vue';
const props = defineProps({
	title : {type : String, required : true},
	handleForm : {type : Function},
	google : Boolean,
	lang : {type : Boolean, default : true},
	enlarge : Boolean,
});
</script>
<template>
	<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
		<div :class="'relative py-3 '+(enlarge ? 'w-1/2' : 'sm:max-w-xl')+' sm:mx-auto'">
			<div class="absolute inset-0 first-bg-color-default shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 rounded-3xl"
			></div>
			<div class="relative px-4 py-10 bg-white shadow-lg rounded-md sm:rounded-3xl sm:p-20">
				<div class="max-w-md mx-auto">
					<form @submit.prevent="handleForm">
						<div>
							<h1 class="text-2xl ff-jost-semibold">{{ title }}</h1>
						</div>
						<slot/>
					</form>
				</div>

				<slot name="more"></slot>

				<div v-if="google" class="w-full flex justify-center mt-4">
					<GoogleAuth :link="route('redirect-google')" :title="$__('auth.button.google')"/>
				</div>

				<div v-if="lang" class="w-full flex justify-center mt-4">
					<SelectLang :float="1"/>
				</div>
			</div>
		</div>
	</div>
</template>
