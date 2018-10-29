require('./bootstrap');
import Vue from 'vue'
import store from './store/index'
import router from './router/index'


if (store.state.token.token !== undefined) {
    axios.defaults.headers.common['Authorization'] = store.state.token.token.token_type + " " + store.state.token.token.access_token
}
const App = () =>
    import('./views/App.vue');
const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
