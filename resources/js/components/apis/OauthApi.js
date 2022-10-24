import axios from "./index";
class OauthApi {
    static Authorize = (data) => {
        return axios.get(`${base}/authorize`, {
            params: {
                ...data,
            },
        });
    };
    static Approve = (data) => {
        return axios.post(`${base}/authorize`, data);
    };
    static Deny = (data) => {
        return axios.delete(`${base}/authorize`, data);
    };
    static Token = (data) => {
        return axios.post(`${base}/token`, data);
    };
    static GetToken = (data) => {
        return axios.get(`${base}/tokens`, data);
    };
    static DeleteToken = (data) => {
        return axios.post(`${base}/tokens/${data}`);
    };
    static Scopes = (data) => {
        return axios.get(`${base}/scopes`);
    };
    static getClient = (data) => {
        return axios.get(`${base}/clients`);
    };
    static createClient = (data) => {
        return axios.post(`${base}/clients`, data);
    };
    static deleteClient = (data) => {
        return axios.delete(`${base}/clients/${data}`);
    };
}
var base = "oauth";
export default OauthApi;
