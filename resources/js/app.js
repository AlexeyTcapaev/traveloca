require('./bootstrap');
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vue from 'vue'
import store from './store/index'
import router from './router/index'


/*if (store.state.user.token !== undefined) {
    axios.defaults.headers.common['Authorization'] = store.state.user.token.token_type + " " + store.state.user.token.access_token
}*/
const App = () =>
    import('./views/App.vue');
const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
