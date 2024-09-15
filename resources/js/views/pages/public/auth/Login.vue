<script setup>
import { ref } from 'vue'
import { useStore } from 'vuex';
import { useForm, Link} from '@inertiajs/vue3'

import LayoutAuth from '../../../layouts/Auth.vue';
import InputMain from '../../../components/forms/inputs/Main.vue';
import ButtonMain from '../../../components/buttons/Main.vue';



const store = useStore()

const displayError = ref(false)

const loginForm = useForm({
	email : null,
	password : null,
	// remember : false,
});

const handleForm = (el) => {
	el.preventDefault();
	loginForm.post(route('login'), {
		preserveScroll: true,
		onStart: visit => {
			if(!store.getters['area/areaKeyExists']('login'))
				store.dispatch('area/addArea', {
					key : 'login',
					type : 'main',
					datas : {
						title : "Tentative de connexion...",
					},
					active : true,
				});
			else
				store.dispatch('area/updateArea', {
					key : 'login',
					datas : { title : "Reconnexion...", closeIcon : false, color : null, description : null, spinner : true },
					merge : true,
				});
			displayError.value = false;
		},
		// onFinish: visit => {
		// 	console.log('finish', visit)
		// },
		onSuccess: (page) => {
			store.commit('app/setPageProps', {value : page.props});
			store.dispatch('area/updateArea', {
				key : 'login',
				datas : { title : "Connected !", closeIcon : true, color : 'success', description : `Ravie de vous voir ${store.getters['app/auth_person']('name')}`, spinner : false },
				merge : true,
			});
		},
		onError: (...errors) => {
			displayError.value = true;

			store.dispatch('area/updateArea', {
				key : 'login',
				datas : { title : "Echec de connexion...", closeIcon : true, spinner : false, color : 'danger', description : '<ul class="list-disc list-inside"><li>'+Object.values(loginForm.errors).join("</li><li>")+'</li></ul>' },
				merge : true,
			});
		},
	})
}
</script>
<template>
	<LayoutAuth :title="$__('auth.login-title')" :handle-form="handleForm" google>
		<div class="divide-y divide-gray-200 mt-8">
			<div class="flex flex-col text-base leading-6 space-y-6 text-gray-700 sm:text-lg sm:leading-7">
				<div>
					<InputMain required v-model="loginForm.email" :label="$__('auth.label.email_or_username')"/>
					<div v-if="displayError && loginForm?.errors?.email" class="ff-jost-medium text-sm mt-2 text-red-600">{{ loginForm.errors.email }}</div>
				</div>
				<div>
					<InputMain required v-model="loginForm.password" type="password" :label="$__('auth.label.password.main')"/>
					<div v-if="displayError && loginForm?.errors?.password" class="ff-jost-medium text-sm mt-2 text-red-600">{{ loginForm.errors.password }}</div>
				</div>
				<div class="relative">
					<ButtonMain class="w-full" :disabled="loginForm.processing" :title="$__('auth.button.login')"/>
				</div>
			</div>
		</div>
		<template #more>
			<div class="flex flex-wrap space-x-1 mt-1">
				<span class="ff-jost ">{{ $__('auth.not-account.0') }}</span>
				<Link class="ff-jost text-blue-500" :href="route('sign_up')">{{ $__('auth.not-account.1') }}</Link>
			</div>
		</template>
	</LayoutAuth>
</template>
