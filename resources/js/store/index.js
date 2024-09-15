import { createStore } from 'vuex'
import { modules, debug, plugin } from './modules'

const store = createStore({
	modules: modules,
	strict: debug,
	plugins: plugin
});

export default store;
