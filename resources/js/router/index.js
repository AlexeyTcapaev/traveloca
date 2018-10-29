import Vue from "vue";
import VueRouter from 'vue-router'
import {
    homedir
} from "os";
Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
   /* routes: [{
        path: "/",
        component: Home,
        beforeEnter: (to, from, next) => {
            axios.get('/api/auth/user').then(function (resp) {
                store.state.user.user = resp.data
                Cookies.set('user', JSON.stringify(store.state.user.user), {
                    expires: 2,
                    domain: location.hostname
                });

                next();
            }).catch(error => {
                router.push("/login");
            })
        },
    }]*/
});
