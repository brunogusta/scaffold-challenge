<template>
  <div class="h-100">
    <navbar :app="this" />

    <router-view :app="this" />
  </div>
</template>

<script>
import Navbar from "./components/Navbar";

export default {
  name: "app",
  components: {
    Navbar,
  },
  data() {
    return {
      user: null,
      req: axios.create({
        baseUrl: "{{  URL::to(" / ")  }}",
      }),
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.req.get("auth/init").then(({ data }) => {
        this.$store.dispatch("ActionLoginUser", data.user);
      });
    },
  },
};
</script>
