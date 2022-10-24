import actionTypes from "./actionTypes";

export const setAccessToken = (token) => ({
    type: actionTypes.SET_ACCESS_TOKEN,
    access_token: token,
});
export const clearAccessToken = () => ({
    type: actionTypes.CLEAR_ACCESS_TOKEN,
});
export const setRefreshToken = (token) => ({
    type: actionTypes.SET_REFRESH_TOKEN,
    refresh_token: token,
});
export const clearRefreshToken = () => ({
    type: actionTypes.CLEAR_REFRESH_TOKEN,
});
export const processLogout = () => ({
    type: actionTypes.PROCESS_LOGOUT,
});
export const setAdmin = (adminInfo) => ({
    type: actionTypes.SET_ADMIN,
    adminInfo: adminInfo,
});
export const unsetAdmin = () => ({
    type: actionTypes.UNSET_ADMIN,
});
