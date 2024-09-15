<script setup>
const props = defineProps({
	dimension : {type : String, default : 'w-20 h-20'},
	double : {type : Boolean, default : true},
})
</script>
<template>
	<span :class="'block relative z-[1] ' + dimension">
		<span class="z-[-1] absolute top-0 left-0 w-full h-full turn first-bg-color-default rounded-3xl"></span>
		<span v-if="double" class="z-[-1] absolute top-0 left-0 w-full h-full turn-r first-bg-color-default rounded-3xl"></span>
		<span class="peer group block w-full h-full p-5 bg-white rounded-3xl">
			<svg class="transform group-hover:rotate-[315deg] transition-transform duration-1000 svg-ethereum first-color-default" style="fill:currentColor;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M23.964844 0 A 1.50015 1.50015 0 0 0 22.755859 0.66015625L9.3417969 20.535156L9.3300781 20.550781 A 1.50015 1.50015 0 0 0 9.9550781 22.908203L23.308594 29.832031 A 1.50015 1.50015 0 0 0 24.691406 29.832031L38.058594 22.900391 A 1.50015 1.50015 0 0 0 38.681641 20.566406L25.244141 0.66015625 A 1.50015 1.50015 0 0 0 23.964844 0 z M 22.5 6.4042969L22.5 15.126953L14.460938 18.316406L22.5 6.4042969 z M 25.5 6.4042969L33.539062 18.316406L25.5 15.126953L25.5 6.4042969 z M 22.5 18.355469L22.5 26.033203L14.111328 21.681641L22.5 18.355469 z M 25.5 18.355469L33.888672 21.681641L25.5 26.033203L25.5 18.355469 z M 37.519531 27 A 1.50015 1.50015 0 0 0 36.837891 27.154297L24 33.474609L11.162109 27.154297 A 1.50015 1.50015 0 0 0 9.3007812 29.400391L22.697266 47.261719 A 1.50015 1.50015 0 0 0 25.298828 47.267578L38.699219 29.400391 A 1.50015 1.50015 0 0 0 37.519531 27 z M 15.458984 32.613281L22.5 36.080078L22.5 42L15.458984 32.613281 z M 32.541016 32.613281L25.5 42L25.5 36.080078L32.541016 32.613281 z"/></svg>
		</span>
		<span class="peer-hover:block hidden animate-ping z-[-1] absolute inset-0 w-4/5 h-4/5 m-auto first-bg-color-default first-bg-color-opacity-60 rounded-full"></span>
	</span>
</template>
<style scoped>
.turn{
	transform : scale(.9);
	animation: turn-w28hw 10s 1s linear infinite;
}
.turn-r{
	transform : scale(.9);
	animation: turn-w28hw 10s 1s linear infinite reverse;
}
body, body > div, main, main > div{overflow: hidden !important;}
@keyframes turn-w28hw{
	0%{transform: scale(.9) rotate(0deg);}
	50%{transform: scale(1.1) rotate(180deg);}
	100%{transform: scale(.9) rotate(360deg);}
}
</style>
