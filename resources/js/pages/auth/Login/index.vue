<template>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card mt-5">
      <div class="card-header">
        <h1>Login</h1>
      </div>
      <div class="card-body">
        <div>
          <form v-on:submit.prevent="onSubmit">
            <div class="alert alert-danger" v-if="errors.length">
              <ul class="mb-0">
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>
            <div class="form-group">
              <label>E-mail</label>
              <input type="text" class="form-control" placeholder="E-mail" v-model="email" />
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" placeholder="Password" v-model="password" />
            </div>

            <button v-if="!loading" class="btn btn-success" type="submit">Login</button>

            <button v-if="loading" class="btn btn-success disabled">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Sending...
            </button>

            <div class="mt-4">
              <span>
                Forgot your password?
                <router-link to="/forgot-password">Reset here.</router-link>
              </span>
            </div>
            <div>
              <span>
                Don't receive confirmation E-mail?
                <router-link to="/resend-email-confirmation">Resend here.</router-link>
              </span>
            </div>

            <div class="mt-3"></div>
            <h5>Teacher login:</h5>
            <h6>Email: teacher@gmail.com</h6>
            <h6>Password: teacher123</h6>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "login",
  props: ["app"],
  data() {
    return {
      email: "",
      password: "",
      errors: [],
      loading: false,
      reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    };
  },
  methods: {
    onSubmit() {
      this.errors = [];

      if (!this.email) {
        this.errors.push("Email is required.");
      }

      if (!this.reg.test(this.email)) {
        this.errors.push("Email is invalid.");
      }

      if (!this.password) {
        this.errors.push("Password is required.");
      }

      if (!this.errors.length) {
        this.loading = true;
        const data = {
          email: this.email,
          password: this.password,
        };

        this.app.req
          .post("auth/login", data)
          .then(({ data }) => {
            this.email = "";
            this.password = "";
            this.loading = false;
            this.$store.dispatch("ActionLoginUser", data.user);

            this.$router.push("/videos");
          })
          .catch((error) => {
            this.email = "";
            this.password = "";
            this.loading = false;
            this.errors.push(error.response.data);
          });
      }
    },
  },
};
</script>

