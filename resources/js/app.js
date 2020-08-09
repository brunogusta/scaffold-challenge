require("./bootstrap");

window.Vue = require("vue");

import VueRouter from "vue-router";
import Embed from "v-video-embed";
import VModal from "vue-js-modal";

import routes from "./routes";
import App from "./App.vue";
import store from "./store";

Vue.use(VueRouter);
Vue.use(Embed);
Vue.use(VModal);

const router = new VueRouter({
  routes
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
