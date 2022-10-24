import actionTypes from "../actions/actionTypes";

const initialState = {
    adminInfo: false,
    access_token: false,
    refresh_token: false,
};

const appReducer = (state = initialState, action) => {
    switch (action.type) {
        case actionTypes.SET_ACCESS_TOKEN:
            return {
                ...state,
                isLoggedIn: true,
                access_token: action.access_token,
            };
        case actionTypes.CLEAR_ACCESS_TOKEN:
            return {
                ...state,
                access_token: false,
            };
        case actionTypes.SET_REFRESH_TOKEN:
            return {
                ...state,
                refresh_token: action.refresh_token,
            };
        case actionTypes.CLEAR_REFRESH_TOKEN:
            return {
                ...state,
                refresh_token: false,
            };
        case actionTypes.PROCESS_LOGOUT:
            return {
                ...state,
                token: false,
            };
        case actionTypes.SET_ADMIN:
            return {
                ...state,
                adminInfo: action.adminInfo,
            };
        case actionTypes.UNSET_ADMIN:
            return {
                ...state,
                adminInfo: false,
            };
        default:
            return state;
    }
};

export default appReducer;
