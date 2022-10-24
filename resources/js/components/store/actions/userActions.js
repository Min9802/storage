import actionTypes from "./actionTypes";

export const addUserSuccess = () => ({
    type: actionTypes.ADD_USER_SUCCESS,
});
export const userLoginSuccess = (usertoken) => ({
    type: actionTypes.USER_LOGIN_SUCCESS,
    userInfo: usertoken,
});
export const userLoginFail = (usertoken) => ({
    type: actionTypes.USER_LOGIN_FAIL,
    userInfo: null,
});
export const userSignOut = (usertoken) => ({
    type: actionTypes.USER_SIGN_OUT,
    userInfo: null,
});
