import Vue from "vue";
import Vuex from "vuex";
import token from './user/token'
Vue.use(Vuex);
export default new Vuex.Store({
    modules: {
        token
    }
});
