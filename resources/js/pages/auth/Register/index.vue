<template>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card w-50 mt-5">
      <div class="card-header">
        <h1>Register</h1>
      </div>
      <div class="card-body">
        <div>
          <form v-on:submit.prevent="onSubmit">
            <div class="alert alert-danger" v-if="errors.length">
              <ul class="mb-0">
                <li v-for="(error, index) in errors" :key="index">
                  {{ error }}
                </li>
              </ul>
            </div>
            <div class="form-group">
              <label>Name</label>
              <input
                type="text"
                class="form-control"
                placeholder="Name"
                v-model="name"
              />
            </div>
            <div class="form-group">
              <label>E-mail</label>
              <input
                type="text"
                class="form-control"
                placeholder="E-mail"
                v-model="email"
              />
            </div>
            <div class="form-group">
              <label>Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password"
              />
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
            <button v-if="!loading" class="btn btn-success" type="submit">
              Register
            </button>

            <button v-if="loading" class="btn btn-success disabled">
              <span
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true"
              ></span>
              Sending...
            </button>
            <div class="alert alert-success mt-5" v-if="success">
              Successfully Registered
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
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
      errors: [],
      loading: false,
      success: false,
      reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
    };
  },
  methods: {
    onSubmit() {
      this.errors = [];

      if (!this.name) {
        this.errors.push("Name is required.");
      }

      if (!this.email) {
        this.errors.push("Email is required.");
      }

      if (!this.reg.test(this.email)) {
        this.errors.push("Email is invalid.");
      }

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
          name: this.name,
          email: this.email,
          password: this.password
        };

        this.app.req
          .post("auth/register", data)
          .then(({ data }) => {
            this.name = "";
            this.email = "";
            this.password = "";
            this.confirmPassword = "";
            this.loading = false;
            this.success = true;

            this.$store.dispatch("ActionRegisterUser", data.user);
            this.$router.push("/videos");
          })
          .catch(error => {
            this.name = "";
            this.email = "";
            this.password = "";
            this.confirmPassword = "";
            this.loading = false;
            this.errors.push(error.response.data);
          });
      }
    }
  }
};
</script>

<style lang="scss" scoped />
