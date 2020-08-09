<template>
  <div class="container h-75 d-flex justify-content-center align-items-center">
    <div v-if="success" class="alert alert-success" role="alert">
      <h4 class="alert-heading">Well done!</h4>
      <p>Aww yeah, you successfully confirm your E-mail!</p>
      <hr />
      <strong class="mb-0">Now, you just need to make login to have access to all videos!</strong>
    </div>

    <div v-if="loading" class="spinner-border" style="width: 4rem; height: 4rem;" role="status" />

    <div v-if="error" class="alert alert-danger" role="alert">
      <h4 class="alert-heading">Oh no!</h4>
      <strong>There was an error verifying your E-mail, please try again!</strong>
    </div>
  </div>
</template>

<script>
export default {
  name: "ConfirmEmail",
  props: ["app"],
  data() {
    return {
      loading: false,
      success: false,
      error: false,
    };
  },
  methods: {
    verifyConfirmation() {
      this.loading = true;

      this.app.req
        .put(`auth/confirm-email/${this.$route.params.hash}`)
        .then(({ data }) => {
          this.loading = false;
          this.success = true;
          this.error = false;
        })
        .catch((error) => {
          this.loading = false;
          this.error = true;
          this.success = false;
        });
    },
  },
  mounted() {
    this.verifyConfirmation();
  },
};
</script>

