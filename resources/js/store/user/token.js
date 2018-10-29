import * as Cookies from 'js-cookie'
export default {
    namespaced: true,
    state: {
        token: Cookies.getJSON('token') || undefined
    },
    getters: {

    },
    mutations: {
        SetToken(state, data) {
            state.token = data
            axios.defaults.headers.common['Authorization'] = state.token.token_type + " " + state.token.access_token
            Cookies.set('token', JSON.stringify(state.token), {
                expires: 2,
                domain: location.hostname
            });
        }
    },
    actions: {
        SetToken(state, data) {
            state.commit('SetToken', data)
        },
    }
}
