<script setup>
const props = defineProps({
	title : {type : [String, Number], required : true},
	value : {type : [String, Number], required : true },
	icon : {type : String, required : true },
	color : {default : null },
});
</script>

<template>
	<div class="flex items-center p-4 bg-white rounded-lg shadow-xs">
		<div class="p-3 mr-4 rounded-full" :class="{
			'text-orange-500 bg-orange-100' : !color || color == 'orange',
			'text-green-500 bg-green-100' : color == 'green',
			'text-blue-500 bg-blue-100' : color == 'blue',
			'text-teal-500 bg-teal-100' : color == 'teal',
			'text-red-500 bg-red-100' : color == 'red',
			'text-gray-500 bg-gray-100' : color == 'gray',
		}">
			<template v-if="icon == 'users'">
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
					<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
				</svg>
			</template>
			<template v-else-if="icon == 'money'">
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
				</svg>
			</template>
			<template v-else-if="icon == 'cart'">
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
					<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
				</svg>
			</template>
			<template v-else-if="icon == 'product'">
				<svg class="svg-product w-5 h-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" style="fill: currentcolor;"><path d="M3.5 3C2.673 3 2 3.673 2 4.5L2 9L3 9L3 19C3 20.103 3.897 21 5 21L19 21C20.103 21 21 20.103 21 19L21 9L22 9L22 4.5C22 3.673 21.327 3 20.5 3L3.5 3 z M 4 5L20 5L20 7L4 7L4 5 z M 5 9L19 9L19.001953 19L5 19L5 9 z M 13 15L13 17L17 17L17 15L13 15 z"></path></svg>
			</template>
			<template v-else-if="icon == 'deviation'">
				<svg style="fill:currentColor;" class="svg-deviation w-5 h-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M17.5 26h-7C8.019 26 6 28.019 6 30.5v7c0 2.481 2.019 4.5 4.5 4.5h7c2.481 0 4.5-2.019 4.5-4.5v-7C22 28.019 19.981 26 17.5 26zM34 22c4.411 0 8-3.589 8-8s-3.589-8-8-8-8 3.589-8 8S29.589 22 34 22zM17.5 6h-7C8.019 6 6 8.019 6 10.5v7c0 2.481 2.019 4.5 4.5 4.5h7c2.481 0 4.5-2.019 4.5-4.5v-7C22 8.019 19.981 6 17.5 6zM37.5 26h-7c-2.481 0-4.5 2.019-4.5 4.5v7c0 2.481 2.019 4.5 4.5 4.5h7c2.481 0 4.5-2.019 4.5-4.5v-7C42 28.019 39.981 26 37.5 26z"></path></svg>
			</template>
		</div>
		<div>
			<h4 class="mb-2 text-sm text-gray-600">{{ title }}</h4>
			<h3 class="text-lg ff-jost-medium text-gray-700">{{ value }}</h3>
		</div>
	</div>
</template>