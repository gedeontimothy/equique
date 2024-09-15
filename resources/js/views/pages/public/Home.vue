<script setup>
import { Link } from '@inertiajs/vue3'

</script>
<template>
	<div>
		Home Page<br/>
		<Guest>
			<Link class="text-blue-500" :href="route('sign_in')">SignIn</Link><br/>
			<Link class="text-blue-500" :href="route('sign_up')">SignUp</Link>
			<div>Guest</div>
		</Guest>
		<Auth>
			<a class="text-blue-500" :href="route('logout')">Logout</a><br/>
			<Link class="text-blue-500" :href="route('verification.notice')">Verf Email</Link>
			<div>Auth</div>
		</Auth>
	</div>
</template>
