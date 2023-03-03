import React, { useState, useEffect } from "react";
import { FormattedMessage, useIntl } from "react-intl";
import { useNavigate } from "react-router-dom";
//redux
import { connect } from "react-redux";
import * as actions from "../store/actions";
//utils
import { CheckRef } from "../utils";
//api
import AuthApi from "../apis/AuthApi";

const Logout = (props) => {
    const intl = useIntl();
    const history = useNavigate();
    const [loading, setLoading] = useState(true);
    const prevState = CheckRef.CheckRender();
    /**
     * Handle Logout
     * @param {*} data
     */
    const HandleLogout = async (data) => {
        try {
            const response = await AuthApi.Logout(data);

            const notify = {
                title: "res.title.success",
                text: [intl.formatMessage({ id: "res.logout.success" })],
                icon: "success",
                confirmText: "common.ok",
            };

            if (response.status == 200) {
                props.setNotify(notify);
                props.clearAccessToken();
                props.unsetAdmin();
                history("/login");
            }
        } catch (err) {
            if (err.response) {
                const message = err.response.data.message;
                const notify = {
                    title: "res.title.error",
                    text: [message],
                    icon: "error",
                    confirmText: "common.ok",
                };

                props.clearAccessToken();
                props.unsetAdmin();
                props.setNotify(notify);
                history("/login");
            }
        }
    };
    /**
     * check admin token and handle logout
     */
    useEffect(() => {
        setLoading(false);
        if (!loading && prevState) {
            const access_token = props.access_token;
            HandleLogout(access_token);
        }
        if (props.access_token === false && prevState == true) {
            const notify = {
                title: "res.title.error",
                text: [intl.formatMessage({ id: "res.logout.needlogin" })],
                icon: "error",
                confirmText: "common.ok",
            };
            props.clearAccessToken();
            props.unsetAdmin();
            props.setNotify(notify);
            history("/login");
        }
    }, [loading]);

    return <div></div>;
};
const mapStateToProps = (state) => {
    return {
        access_token: state.admin.access_token,
        notify: state.app.notify,
        language: state.app.language,
        pageInfo: state.app.pageInfo,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),

        unsetAdmin: () => dispatch(actions.unsetAdmin()),
        setAccessToken: (token) => dispatch(actions.setAccessToken(token)),
        clearAccessToken: () => dispatch(actions.clearAccessToken()),

        setRefreshToken: (token) => dispatch(actions.setRefreshToken(token)),
        clearRefreshToken: () => dispatch(actions.clearRefreshToken),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(Logout);
