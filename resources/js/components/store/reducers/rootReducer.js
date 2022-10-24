import { combineReducers } from "redux";
// import { connectRouter } from "connected-react-router";

import appReducer from "./appReducer";
import adminReducer from "./adminReducer";
import userReducer from "./userReducer";

import autoMergeLevel2 from "redux-persist/lib/stateReconciler/autoMergeLevel2";
import storage from "redux-persist/lib/storage";
import { persistReducer } from "redux-persist";

const persistCommonConfig = {
    storage: storage,
    stateReconciler: autoMergeLevel2,
};

const adminPersistConfig = {
    ...persistCommonConfig,
    key: "admin",
    whitelist: ["adminInfo", "access_token", "refresh_token"],
};
const appPersistConfig = {
    ...persistCommonConfig,
    key: "app",
    whitelist: [
        "language",
        "pageInfo",
        "statusbar",
        "config",
        "notify",
        "toastify",
    ],
};
const userPersistConfig = {
    ...persistCommonConfig,
    key: "user",
    whitelist: ["userInfo", "loggedUser"],
};
export default (history) =>
    combineReducers({
        // router: connectRouter(history),
        admin: persistReducer(adminPersistConfig, adminReducer),
        user: persistReducer(userPersistConfig, userReducer),
        app: persistReducer(appPersistConfig, appReducer),
    });
