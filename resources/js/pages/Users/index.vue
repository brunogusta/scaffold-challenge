<template>
  <div class="container">
    <div class="mt-5">
      <h1 class="display-3">All users...</h1>
    </div>

    <button @click="fetchUsers" v-if="!loading" class="btn btn-success" type="submit">Refresh</button>
    <button v-if="loading" class="btn btn-success disabled">
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Fetching...
    </button>
    <div class="card my-5">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">E-mail</th>
            <th scope="col">Active</th>
            <th scope="col">Teacher</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <th scope="row">{{user.id}}</th>
            <td>{{user.name}}</td>
            <td>{{user.email}}</td>
            <td>{{user.confirmed ? 'Yes': 'No'}}</td>
            <td>{{user.teacher ? 'Yes': 'No'}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "Users",
  props: ["app"],
  components: {},
  data() {
    return {
      users: [],
      loading: false,
      errors: [],
    };
  },
  methods: {
    fetchUsers() {
      this.loading = true;

      this.app.req
        .get("users")
        .then(({ data }) => {
          this.loading = false;
          this.users = data;
        })
        .catch((error) => {
          this.loading = false;
          console.log(error.response.data);
        });
    },
  },
  mounted() {
    this.fetchUsers();
  },
};
</script>

