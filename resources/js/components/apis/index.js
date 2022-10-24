import { useLocation } from "react-router-dom";
import Axios from "axios";
import { API_SERVER } from "../configs/constant";
import reduxStore from "../store/reducers/redux";

reduxStore.subscribe(listener);

const select = (state) => {
    const token = state.admin.access_token;
    const user = state.user.userInfo;
    return token || user;
};

function listener() {
    let token = select(reduxStore.getState());
    if (token) {
        axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${token.access_token}`;
    }
}
const axios = Axios.create({
    baseURL: `${API_SERVER}`,
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.head
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content"),
    },
});

axios.interceptors.request.use(
    (config) => {
        return Promise.resolve(config);
    },
    (error) => Promise.reject(error)
);
axios.interceptors.response.use(
    (response) => Promise.resolve(response),
    (error) => {
        return Promise.reject(error);
    }
);

export default axios;
