<script setup>
import {ref} from 'vue';

const props = defineProps({
	label : {type : String, required : true},
	type : {type : String, default : 'text'},
	name : String,
	id : String,
	modelValue: String,
	required : {type : Boolean, default : false},
	autofocus : {type : Boolean, default : false},
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event) => {
	emit('update:modelValue', input_val)
}

const input_val = ref(props.modelValue)

</script>
<template>
	<div class="relative z-[1]">
		<input
			:id="id"
			:name="name"
			:type="type" class="ff-jost peer bg-transparent placeholder-transparent h-10 w-full border-transparent border-b-2 border-b-gray-300 text-gray-900 focus:outline-none focus:first-border-b-color-default"
			:placeholder="label"
			style="outline: none !important;"
			v-model="input_val"
			@input="updateValue"
			:required="required"
			:autofocus="autofocus"
		/>
		<label
			:for="id ?? name" class="ff-jost absolute z-[-1] left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">{{ label }}</label>
	</div>
</template>
