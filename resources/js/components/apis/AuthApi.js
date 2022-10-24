import axios from "./index";

class AuthApi {
    static Login = (data) => {
        return axios.post(`${base}/login`, data);
    };

    static Register = (data) => {
        return axios.post(`${base}/register`, data);
    };

    static Logout = (data) => {
        return axios.post(`${base}/logout`);
    };
    static Info = (data) => {
        return axios.get(`${base}/info`, data, {
            headers: { Authorization: "Bearer" + `${data}` },
        });
    };
    static Refresh = (data) => {
        return axios.post(`${base}/refresh`, data, {
            headers: { Authorization: "Bearer" + `${data}` },
        });
    };
    static UpdateInfo = (data) => {
        return axios.post(`${base}/update`, data);
    };
    static getClient = (data) => {
        return axios.get(`${base}/client`, data, {
            headers: { Authorization: "Bearer" + `${data}` },
        });
    };
    static createClient = (data) => {
        return axios.post(`${base}/create`, data);
    };
}

let base = "auth";

export default AuthApi;
