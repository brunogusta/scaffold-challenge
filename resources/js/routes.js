import Login from "./pages/auth/Login";
import Register from "./pages/auth/Register";
import Home from "./pages/Home";
import Videos from "./pages/Videos";
import Users from "./pages/Users";
import ForgotPassword from "./pages/auth/ForgotPassword";
import ResendEmailConfirmation from "./pages/auth/ResendEmailConfirmation";
import ResetPassword from "./pages/auth/ResetPassword";
import ConfirmEmail from "./pages/auth/ConfirmEmail";

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
    path: "/forgot-password",
    component: ForgotPassword,
    name: "forgot-password"
  },
  {
    path: "/resend-email-confirmation",
    component: ResendEmailConfirmation,
    name: "resend-email-confirmation"
  },
  {
    path: "/confirm-email/:hash",
    component: ConfirmEmail,
    name: "confirm-email"
  },
  {
    path: "/reset-password/:hash",
    component: ResetPassword,
    name: "reset-password"
  },
  {
    path: "/",
    component: Home,
    name: "home"
  },
  {
    path: "/videos",
    component: Videos,
    name: "videos",
    beforeEnter: (to, from, next) => {
      if (!store.state.user) {
        next("/");
      } else {
        next();
      }
    }
  },
  {
    path: "/users",
    component: Users,
    name: "users",
    beforeEnter: (to, from, next) => {
      if (!(store.state.user && store.state.user.teacher)) {
        next("/");
      } else {
        next();
      }
    }
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
