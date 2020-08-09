import * as types from "./mutation-types";

export const ActionLoginUser = ({ commit }, payload) => {
  commit(types.LOGIN_USER, payload);
};

export const ActionRegisterUser = ({ commit }, payload) => {
  commit(types.REGISTER_USER, payload);
};

export const ActionLogoutUser = ({ commit }, payload) => {
  commit(types.LOGOUT_USER, payload);
};
