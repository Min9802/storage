import actionTypes from "../actions/actionTypes";

const initContentOfConfirmModal = {
    isOpen: false,
    messageId: "",
    handleFunc: null,
    dataFunc: null,
};

const initialState = {
    started: true,
    config: null,
    notify: false,
    toastify: false,
    language: "vi",
    statusbar: false,
    systemMenuPath: "/system/user-manage",
    pageInfo: null,
    contentOfConfirmModal: {
        ...initContentOfConfirmModal,
    },
};
const appReducer = (state = initialState, action) => {
    switch (action.type) {
        case actionTypes.APP_START_UP_COMPLETE:
            return {
                ...state,
                started: true,
            };
        case actionTypes.SET_CONTENT_OF_CONFIRM_MODAL:
            return {
                ...state,
                contentOfConfirmModal: {
                    ...state.contentOfConfirmModal,
                    ...action.contentOfConfirmModal,
                },
            };
        case actionTypes.CHANGE_LANGUAGE:
            return {
                ...state,
                language: action.language,
            };
        case actionTypes.SET_INFO_PAGE:
            return {
                ...state,
                pageInfo: action.pageInfo,
            };
        case actionTypes.SET_SIDE_BAR:
            return {
                ...state,
                statusbar: action.statusbar,
            };
        case actionTypes.SET_CONFIG:
            return {
                ...state,
                config: action.config,
            };
        case actionTypes.SET_NOTIFY:
            return {
                ...state,
                notify: action.notify,
            };
        case actionTypes.CLEAR_NOTIFY:
            return {
                ...state,
                notify: false,
            };
        case actionTypes.SET_TOASTYFY:
            return {
                ...state,
                toastify: action.toastify,
            };
        case actionTypes.CLEAR_TOASTYFY:
            return {
                ...state,
                toastify: false,
            };
        default:
            return state;
    }
};

export default appReducer;
