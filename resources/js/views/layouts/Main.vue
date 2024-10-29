<script setup>
import { computed, watch } from 'vue';
import { useStore } from 'vuex';
import WindmillSlider from '../components/menus/WindmillSlider.vue';
import WindmillHeader from '../components/headers/WindmillHeader.vue'
import MainHeader from '../components/headers/Main.vue'
import SelectLang from '../components/forms/SelectLang.vue';

const store = useStore();

const user = computed(() => store.getters['app/auth_user']);
const menu = computed(() => store.getters['menu/dashboardMenu']);
const person = computed(() => store.getters['app/auth_person']);
const file = computed(() => person.value('file'));

const profil_image = computed(() => file.value ? file.value.url : null);

// const more = computed(() => store.state.active.more);
// const menu_act = computed(() => store.state.active.menu);

// const props = defineProps({});
store.commit('menu/disableActiveMenu');
store.commit('menu/activeMenu', {name : 'users'})

</script>
<template>
    
</template>
