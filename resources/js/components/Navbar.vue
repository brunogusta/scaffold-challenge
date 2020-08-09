<template>
  <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <div class="container">
      <router-link to="/" class="navbar-brand">Watch&Learn</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              >Videos</a
            >
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <router-link
                to="/videos-management"
                class="dropdown-item"
                v-bind:class="{
                  disabled: !(
                    this.$store.state.user && this.$store.state.user.teacher
                  )
                }"
                >Videos Management</router-link
              >
              <div class="dropdown-divider" />
              <router-link
                to="/videos"
                class="dropdown-item"
                v-bind:class="{ disabled: !this.$store.state.user }"
                >Watch Videos</router-link
              >
            </div>
          </li>
          <li class="nav-item">
            <router-link
              v-if="this.$store.state.user && this.$store.state.user.teacher"
              to="/users"
              class="nav-link"
              >Users</router-link
            >
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              >{{
                this.$store.state.user ? this.$store.state.user.name : "Account"
              }}</a
            >
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <div v-if="!this.$store.state.user">
                <router-link to="/login" class="dropdown-item"
                  >Login</router-link
                >
                <router-link to="/register" class="dropdown-item"
                  >Register</router-link
                >
              </div>
              <a
                v-else
                @click="logout"
                href="javascript:;"
                class="dropdown-item"
                >Logout</a
              >
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  props: ["app"],
  name: "navbar",
  data() {
    return {
      user: null
    };
  },
  methods: {
    logout() {
      this.app.req.post("auth/logout").then(() => {
        this.$store.dispatch("ActionLogoutUser");
        this.$router.push("/login");
      });
    }
  }
};
</script>

<style lang="scss" scoped></style>
