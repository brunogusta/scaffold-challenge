import Login from "./pages/auth/Login";
import Register from "./pages/auth/Register";
import Home from "./pages/Home";
import VideosManagement from "./pages/VideosManagement";

import store from "./store";

export default [
  {
    path: "/login",
    component: Login,
    name: "login"
  },
  {
    path: "/register",
    component: Register,
    name: "register"
  },
  {
    path: "/",
    component: Home,
    name: "home"
  },
  {
    path: "/videos-management",
    component: VideosManagement,
    name: "videos-management",
    beforeEnter: (to, from, next) => {
      if (!(store.state.user && store.state.user.teacher)) {
        next("/");
      } else {
        next();
      }
    }
  },
  {
    path: "*",
    redirect: "/"
  }
];
