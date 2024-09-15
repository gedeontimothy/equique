<script setup>
import { computed } from 'vue'
import { useStore } from 'vuex';
import { router } from '@inertiajs/vue3'

import ButtonMain from '../../../components/buttons/Main.vue';
import ButtonMainLink from '../../../components/buttons/MainLink.vue';
import LayoutAuth from '../../../layouts/Auth.vue';
import { nl2br } from '../../../../utils/helpers.native';

const store = useStore()

const user = computed(() => store.getters["app/auth_user"])
const person = computed(() => store.getters["app/auth_person"])

const status = session('status');
const handleForm = (el) => {
	router.post(route('verification.send'), {}, {
		onSuccess : (...a) => {
			console.log('onSuccess', a)
			// store.dispatch('app/loadPage');
			// stat.value = session('status').value;
		},
		
		onError : (...a) => {
			console.log('onError', a)
			// store.dispatch('app/loadPage');
			// stat.value = session('status').value;
		},
		
		onFinish : (...a) => {
			console.log('onFinish', a)
			// store.dispatch('app/loadPage');
			// stat.value = session('status').value;
		}
	})
}
</script>
<template>
	<LayoutAuth :title="$__('mail.email-verification.subject')">
		<div class="mt-8">
			<template v-if="status == 'verification-link-sent'">
				<div class="mb-4 font-medium text-sm text-green-600" v-html="nl2br($__('auth.mail.link-resent', {'email': user('email')}))"></div>
			</template>

			<div class="mb-4 text-sm text-gray-600" v-html="nl2br($__('auth.mail.description'))"></div>

			<div class="mt-4 flex items-center justify-between">
				<ButtonMain mini @click="handleForm" :title="$__('Send Verification Email')"/>
				<ButtonMainLink mini color="danger" :href="route('logout')" as="button" type="button" :title="$__('Logout')"/>
			</div>
		</div>
	</LayoutAuth>
</template>
