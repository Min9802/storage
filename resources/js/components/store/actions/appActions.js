import actionTypes from "./actionTypes";

export const appStartUpComplete = () => ({
    type: actionTypes.APP_START_UP_COMPLETE,
});

export const setContentOfConfirmModal = (contentOfConfirmModal) => ({
    type: actionTypes.SET_CONTENT_OF_CONFIRM_MODAL,
    contentOfConfirmModal: contentOfConfirmModal,
});
export const changeLanguageApp = (languagechange) => ({
    type: actionTypes.CHANGE_LANGUAGE,
    language: languagechange,
});
/**
 * set page info
 * @param {var} title           - Set title
 * @param {var} desc            - Set Description
 * @returns
 */
export const appSetInfoPage = (pageInfo) => ({
    type: actionTypes.SET_INFO_PAGE,
    pageInfo: pageInfo,
});
export const setSidebar = (sidebar) => ({
    type: actionTypes.SET_SIDE_BAR,
    statusbar: sidebar,
});
export const setConfig = (config) => ({
    type: actionTypes.SET_CONFIG,
    config: config,
});
/**
 * Notification
 * @param {Object} props        - Set Object props
 * @property {var} title        - Set title
 * @property {var} text         - Set text content
 * @property {var} icon         - Set icon
 * @property {boolean} cancel   - Set cancel
 * @property {boolean} cancel   - Set cancel
 * @property {var} confirmText  - Set confirmText
 * @property {var} cancelText   - Set cancelText
 * @property {function} confirm - Set confirm function
 * @property {function} cancel  - Set cancel function
 * @returns
 */
export const setNotify = (notify) => ({
    type: actionTypes.SET_NOTIFY,
    notify: notify,
});

export const clearNotify = () => ({
    type: actionTypes.CLEAR_NOTIFY,
    notify: false,
});
/**
 * Toastify
 * @param {Object} props       - set Object props
 * @property {var} status      - set Status
 * @property {var} text        - set Text content
 * @property {var} close       - set time close
 * @returns
 */
export const setToastify = (toastify) => ({
    type: actionTypes.SET_TOASTYFY,
    toastify: toastify,
});
export const clearToastify = () => ({
    type: actionTypes.CLEAR_TOASTYFY,
    toastify: false,
});
