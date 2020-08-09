<template>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card w-50 mt-5">
      <div class="card-header">
        <h1>Reset Password</h1>
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
              <label>Password</label>
              <input type="password" class="form-control" placeholder="Password" v-model="password" />
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Confirm Password"
                v-model="confirmPassword"
              />
            </div>
            <button v-if="!loading" class="btn btn-success" type="submit">Send</button>

            <button v-if="loading" class="btn btn-success disabled">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Sending...
            </button>
            <div class="alert alert-success mt-5" v-if="success">
              <strong>Password changed successfully</strong>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "register",
  props: ["app"],
  data() {
    return {
      password: "",
      confirmPassword: "",
      errors: [],
      loading: false,
      success: false,
      reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    };
  },
  methods: {
    onSubmit() {
      this.errors = [];

      if (!this.password) {
        this.errors.push("Password is required.");
      }

      if (!this.confirmPassword) {
        this.errors.push("Confirm Password is required.");
      }

      if (this.confirmPassword !== this.password) {
        this.errors.push("The passwords must be equals.");
      }

      if (!this.errors.length) {
        this.loading = true;
        const data = {
          password: this.password,
        };

        this.app.req
          .put(`auth/reset-password/${this.$route.params.hash}`, data)
          .then(({ data }) => {
            this.password = "";
            this.confirmPassword = "";
            this.loading = false;
            this.success = true;

            this.$router.push("/login");
          })
          .catch((error) => {
            this.password = "";
            this.confirmPassword = "";
            this.loading = false;
            this.errors.push(error.response.data);
          });
      }
    },
  },
};
</script>

