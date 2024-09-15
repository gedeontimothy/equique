<script setup>
import { ref } from 'vue'
import { useStore } from 'vuex';
import { useForm, Link } from '@inertiajs/vue3'
import { FwbRadio } from 'flowbite-vue'

import LayoutAuth from '../../../layouts/Auth.vue';
import InputMain from '../../../components/forms/inputs/Main.vue';
import ButtonMain from '../../../components/buttons/Main.vue';


const store = useStore()

const displayError = ref(false)

const registerForm = useForm({
	name : null, // 'New',
	firstname : null, // 'User',
	lastname : null,
	sexe : null,
	username : null, // 'new_user',
	email : null, // 'new_user@mail.com',
	// phone : null,
	password : null, // '12345678',
	// remember : false,
});

const handleForm = (el) => {
	el.preventDefault();
	// console.log(registerForm.data())
	registerForm.post(route('register', {next : '/verify-email'}), { // {next : route('verification.notice')}
		preserveScroll: true,
		replace: true,
		onStart: visit => {
			if(!store.getters['area/areaKeyExists']('register'))
				store.dispatch('area/addArea', {
					key : 'register',
					type : 'main',
					datas : {
						title : "Création du compte en cours...",
					},
					active : true,
				});
			else
				store.dispatch('area/updateArea', {
					key : 'register',
					datas : { title : "Création du compte en cours...", closeIcon : false, color : null, description : null, spinner : true },
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
				key : 'register',
				datas : { title : "Votre compte a été créer !", closeIcon : true, color : 'success', description : `Bienvenu ${store.getters['app/auth_person']('name')} sur Equique`, spinner : false },
				merge : true,
			});
		},
		onError: (...errors) => {
			displayError.value = true;
			store.dispatch('area/updateArea', {
				key : 'register',
				datas : { title : "Echec de création de compte", closeIcon : true, spinner : false, color : 'danger', description : '<ul class="list-disc list-inside"><li>'+Object.values(registerForm.errors).join("</li><li>")+'</li></ul><span class="text-base ff-jost">Resolvez l\'erreur si possible et réessayez s\'il vous plaît !</span>' },
				merge : true,
			});
		},
	})
}
</script>
<template>
	<LayoutAuth :title="$__('auth.register-title')" :handle-form="handleForm" enlarge google>
		<div class="divide-y divide-gray-200 mt-8">
			<div class="flex flex-row flex-wrap text-base leading-6 text-gray-700 sm:text-lg sm:leading-7">
				<div class="px-3 py-5 w-1/2">
					<InputMain autofocus required v-model="registerForm.name" :label="'*' + $__('auth.label.name')"/>
					<div v-if="displayError && registerForm?.errors?.name" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.name }}</div>
				</div>
				<div class="px-3 py-5 w-1/2">
					<InputMain required v-model="registerForm.firstname" :label="'*' + $__('auth.label.firstname')"/>
					<div v-if="displayError && registerForm?.errors?.firstname" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.firstname }}</div>
				</div>
				<div class="px-3 py-5 w-1/2">
					<InputMain v-model="registerForm.lastname" :label="$__('auth.label.lastname')"/>
					<div v-if="displayError && registerForm?.errors?.lastname" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.lastname }}</div>
				</div>
				<div class="px-3 py-5 w-1/2">
					<div>
						<label class="ff-jost text-gray-600 text-base" for="sex">{{ $__('auth.label.sex.main') }}</label>
						<div class="flex items-center ff-jost text-base space-x-8">
							<FwbRadio class="w-auto" required v-model="registerForm.sexe" name="sex" value="m" :label="$__('auth.label.sex.male')"/>
							<FwbRadio class="w-auto" required v-model="registerForm.sexe" name="sex" value="f" :label="$__('auth.label.sex.female')"/>
						</div>
					</div>
					<div v-if="displayError && registerForm?.errors?.sexe" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.sexe }}</div>
				</div>
				<div class="px-3 py-5 w-1/2">
					<InputMain required v-model="registerForm.username" :label="'*' + $__('auth.label.username')"/>
					<div v-if="displayError && registerForm?.errors?.username" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.username }}</div>
				</div>
				<div class="px-3 py-5 w-1/2">
					<InputMain required v-model="registerForm.email" type="email" :label="'*' + $__('auth.label.email')"/>
					<div v-if="displayError && registerForm?.errors?.email" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.email }}</div>
				</div>
				<div class="px-3 py-5 w-1/2">
					<InputMain required v-model="registerForm.password" type="password" :label="'*' + $__('auth.label.password.main')"/>
					<div v-if="displayError && registerForm?.errors?.password" class="ff-jost-medium text-sm mt-2 text-red-600">{{ registerForm.errors.password }}</div>
				</div>
				<div class="px-3 py-5 relative flex-1">
					<ButtonMain class="w-full" :disabled="registerForm.processing" :title="$__('auth.button.register')"/>
				</div>
			</div>
		</div>
		<template #more>
			<div class="flex justify-center flex-wrap space-x-1 mt-1">
				<span class="ff-jost ">{{ $__('auth.already-account.0') }}</span>
				<Link class="ff-jost text-blue-500" :href="route('sign_in')">{{ $__('auth.already-account.1') }}</Link>
			</div>
		</template>
	</LayoutAuth>
</template>
