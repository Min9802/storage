import { useCallback, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import AuthApi from "../apis/AuthApi";
import OauthApi from "../apis/OauthApi";
// redux
import { connect, useDispatch } from "react-redux";
import * as actions from "../store/actions";
import reduxStore from "../store/reducers/redux";
import { CheckRef } from "../utils";
function CheckToken(token) {
    const prevState = CheckRef.CheckRender();
    const [loading, setLoading] = useState(true);
    const [notify, setNotify] = useState(false);
    const [check, setCheck] = useState(false);
    const [checked, setChecked] = useState(false);
    const [binding, setBinding] = useState(false);
    const [checkInfo, setCheckInfo] = useState(false);
    const [checkLogged, setCheckLogged] = useState(false);

    const [access_token, setAccessToken] = useState(false);
    const [refresh_token, setRefresh_Token] = useState(false);
    const [dataUser, setDataUser] = useState(false);

    const history = useNavigate();
    const dispatch = useDispatch();

    const select = (state) => {
        const access_token = state.admin.access_token;
        const refresh_token = state.admin.refresh_token;
        const admin = state.admin.adminInfo;
        return { access_token, refresh_token, admin };
    };

    function listener() {
        var { access_token, refresh_token, admin } = select(
            reduxStore.getState()
        );

        setAccessToken(access_token);
        setRefresh_Token(refresh_token);
        setDataUser(admin);
        setBinding(true);
    }

    useEffect(() => {
        if (prevState) {
            setLoading(false);
            reduxStore.subscribe(listener);
        }
    }, [prevState]);
    useEffect(() => {
        if (notify) {
            dispatch(actions.setNotify(notify));
        } else {
            dispatch(actions.clearNotify());
        }
    }, [notify]);

    /**
     * check refresh token
     * @param {*} refresh_token
     */
    const checkRefreshToken = (refresh_token) => {
        if (refresh_token) {
            Refresh(refresh_token.refresh_token);
        }
    };
    /**
     * check token expires
     * @param {*} token
     * @returns
     */
    const CheckExpired = (token) => {
        setLoading(true);
        try {
            const accessToken = token;
            if (!accessToken) {
                const notify = {
                    title: "res.title.error",
                    text: ["res.auth.token.invalid"],
                    icon: "error",
                    confirmText: "common.ok",
                    confirm: () => {
                        dispatch(actions.clearNotify());
                        history("/login");
                    },
                };
                setNotify(notify);
                setChecked(true);
            } else {
                const expires = accessToken.expires;
                const timeNow = new Date();
                const timeLeft = Date.parse(expires) - Date.parse(timeNow);
                if (timeLeft <= 0) {
                    const notify = {
                        title: "res.title.error",
                        text: ["res.auth.token.invalid"],
                        icon: "error",
                        confirmText: "common.ok",
                        confirm: () => {
                            dispatch(actions.clearNotify());
                            history("/login");
                        },
                    };
                    dispatch(actions.unsetAdmin());
                    dispatch(actions.clearAccessToken());
                } else {
                    if (parseInt(timeLeft) <= 60) {
                        console.log(refresh_token);
                        Refresh(refresh_token);
                    }
                    GetInfo(accessToken.access_token);
                    setChecked(true);
                }
            }
        } catch (err) {
            const notify = {
                title: "res.title.error",
                text: ["res.serverError"],
                icon: "error",
                confirmText: "common.ok",
                confirm: () => {
                    dispatch(actions.clearNotify());
                    history("/login");
                },
            };
            setNotify(notify);
            setChecked(true);
            dispatch(actions.clearAccessToken());
        } finally {
            setLoading(false);
            setChecked(true);
        }
    };
    const GetInfo = async (token) => {
        setLoading(true);
        const accessToken = token;

        try {
            const response = await AuthApi.Info(accessToken.access_token);
            const dataUser = response.data;
            dispatch(actions.setAdmin(dataUser));
            setLoading(false);
        } catch (err) {
            const statusRes = err.response.data.status;
            const message = err.response.data.message;
            const notify = {
                title: "res.title." + statusRes,
                text: [message],
                icon: statusRes,
                confirmText: "common.ok",
                confirm: () => {
                    dispatch(actions.clearNotify());
                    history("/login");
                },
            };
            setNotify(notify);
            dispatch(actions.unsetAdmin());
            dispatch(actions.clearAccessToken());
            setLoading(false);
        } finally {
            setLoading(false);
            setChecked(true);
        }
    };
    const Refresh = async (token) => {
        try {
            const { CLIENT_ID, CLIENT_SECRET } = process.env;
            const data = {
                grant_type: "refresh_token",
                client_id: CLIENT_ID,
                client_secret: CLIENT_SECRET,
                refresh_token: token,
                scope: "storage",
            };
            const response = await OauthApi.Token(data);
            const user = {
                ...response.data,
            };
            const expires_in = user.expires_in;
            const expires = new Date();
            expires.setTime(expires.getTime() + expires_in * 1000);

            const access_token = {
                access_token: user.access_token,
                expires: expires,
            };
            const RefreshToken_expries = new Date();
            RefreshToken_expries.setTime(
                RefreshToken_expries.getTime() + 31556926 * 1000
            );
            const refresh_token = {
                refresh_token: user.refresh_token,
                expires: RefreshToken_expries,
            };
            dispatch(actions.setAccessToken(access_token));
            dispatch(actions.setRefreshToken(refresh_token));
        } catch (err) {
            const notify = {
                title: "res.title.error",
                text: ["res.auth.token.invalid"],
                icon: "error",
                confirmText: "common.ok",
                confirm: () => {
                    dispatch(actions.clearNotify());
                    history("/login");
                },
            };
            setNotify(notify);
            dispatch(actions.unsetAdmin());
        } finally {
            setChecked(true);
        }
    };

    const isLoged = () => {
        const notify = {
            title: "res.title.info",
            text: ["res.logged"],
            icon: "info",
            confirmText: "common.ok",
            confirm: () => {
                dispatch(actions.clearNotify());
                history("/");
            },
        };
        setNotify(notify);
    };

    return { CheckExpired, GetInfo, Refresh };
}

export default CheckToken;
