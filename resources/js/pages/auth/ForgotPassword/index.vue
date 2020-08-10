<template>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card mt-5">
      <div class="card-header">
        <h1>Forgot Password</h1>
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
              <label>Inform your registered E-mail:</label>
              <input
                type="text"
                class="form-control"
                placeholder="Your registered email"
                v-model="email"
              />
            </div>
            <button v-if="!loading" class="btn btn-success" type="submit">Send</button>

            <button v-if="loading" class="btn btn-success disabled">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Sending...
            </button>

            <div class="alert alert-success mt-3" v-if="success">
              <ul class="mb-0">
                <li>{{ message }}</li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ForgotPassword",
  props: ["app"],
  data() {
    return {
      email: "",
      errors: [],
      loading: false,
      success: false,
      message: "",
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

      if (!this.errors.length) {
        this.loading = true;
        const data = {
          email: this.email,
        };

        this.app.req
          .post("auth/forgot-password", data)
          .then(({ data }) => {
            this.email = "";
            this.loading = false;
            this.success = true;
            this.message = data.message;
            this.errors = [];
          })
          .catch((error) => {
            this.email = "";
            this.loading = false;
            this.errors.push(error.response.data);
          });
      }
    },
  },
};
</script>

