import * as types from "./mutation-types";

export default {
  [types.LOGIN_USER](state, payload) {
    state.user = payload;
  },
  [types.LOGOUT_USER](state, payload) {
    state.user = null;
  },
  [types.REGISTER_USER](state, payload) {
    state.user = payload;
  }
};
