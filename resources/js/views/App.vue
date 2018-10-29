<template>
    <div>
        <input type="text" placeholder="name" v-model="user.name">
        <input type="text" placeholder="email" v-model="user.email">
        <input type="password" placeholder="password" v-model="user.password">
        <input type="password" placeholder="confrim password" v-model="user.password_confirmation" >
        <button @click="Submit"></button>
        <h1>{{alert}}</h1>
        <button @click="GetUser">get user</button>
        {{BDuser}}
    </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  data: () => ({
    user: {},
    alert: {},
    BDuser: {}
  }),
  methods: {
    ...mapActions({ SetToken: "token/SetToken" }),
    Submit() {
      const init = this;
      axios
        .post("/api/auth/signup", {
          email: this.user.email,
          password: this.user.password,
          name: this.user.name,
          password_confirmation: this.user.password_confirmation
        })
        .then(resp => {
          init.alert = resp;
          axios
            .post("/api/auth/login", {
              email: init.user.email,
              password: init.user.password,
              remember_me: true
            })
            .then(function(resp) {
              init.SetToken(resp.data);
              init.$router.push("/app");
            });
        });
    },
    GetUser() {
      const init = this;
      axios.get("/api/auth/user").then(function(resp) {
        init.BDuser = resp.data;
      });
    }
  },
  computed: {
    ...mapState("token", ["token"])
  }
};
</script>
