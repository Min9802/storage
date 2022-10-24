import React, { useEffect, useState } from "react";
import { Button, Card, Col, Container, Row } from "react-bootstrap";
import ReactDOM from "react-dom";
import { FormattedMessage, useIntl } from "react-intl";
import { FaSignInAlt, FaSignOutAlt } from "react-icons/fa";

import { Outlet, useLocation, useNavigate } from "react-router-dom";
import { Helmet, HelmetProvider } from "react-helmet-async";
//redux
import * as actions from "../store/actions";
import { connect, useDispatch, useSelector } from "react-redux";
import Notify from "../component/Notify";
import Toastify from "../component/Toastify";
//util
import {
    CheckRef,
    Response,
    LANGUAGES,
    CheckRequest,
    Notification,
    CheckToken
} from "../utils";
import AuthApi from "../apis/AuthApi";
import OauthApi from "../apis/OauthApi";

const Layout = (props) => {
    const prevState = CheckRef.CheckRender();
    const [loading, setLoading] = useState(true);
    const routeLocation = useLocation();
    const history = useNavigate();
    const intl = useIntl();
    const { CheckExpired } = CheckToken(props.access_token);
    useEffect(() => {
        setLoading(false);
        if (prevState && !loading) {
            if (!["/login", "logout"].includes(routeLocation.pathname)) {
                CheckExpired(props.access_token)
            }
        }
    }, [loading, routeLocation]);
    useEffect(() => {
        const timeout = setInterval(() => {
            CheckExpired(props.access_token)
        }, 5 * 60 * 1000)
        return () => {
            clearInterval(timeout);
        }
    }, [])
    /**
     * set Helmet;
     * @param {*} param
     * @returns
     */
    const SetHelmet = ({ pageInfo }) => {
        return (
            <Helmet>
                <title>
                    {intl.formatMessage({
                        id: pageInfo?.title,
                    })}
                </title>
                <meta
                    name="description"
                    content={intl.formatMessage({
                        id: pageInfo?.desc,
                    })}
                />
                <meta property="og:title" content={pageInfo?.ogtitle} />
                <meta property="og:site_name" content={pageInfo?.siteName} />
                <meta
                    property="og:description"
                    content={pageInfo?.description}
                />
                <meta property="og:url" content={pageInfo?.url} />
                <meta property="og:image" content={pageInfo?.image} />
                {pageInfo?.image ? (
                    <>
                        <meta property="og:image:width" content="1525" />
                        <meta property="og:image:height" content="538" />
                    </>
                ) : null}
            </Helmet>
        );
    };

    return (
        <Container>
            {props.pageInfo ? <SetHelmet pageInfo={props.pageInfo} /> : null}
            {props.toastify ? <Toastify /> : null}
            {props.notify ? <Notify /> : null}
            <Card className="form_group">
                <Card.Body>
                    <Card.Header className="form_group">
                        <div className="d-flex justify-content-end">
                            {!props.access_token?.access_token ? (
                                <>
                                    <Button
                                        variant="secondary"
                                        className="form_group"
                                        href="/login"
                                    >
                                        <FaSignInAlt />{" "}
                                        <FormattedMessage id="common.login" />
                                    </Button>
                                </>
                            ) : (
                                <div className="form_group">
                                    <Button
                                        variant="secondary"
                                        className="form_group"
                                        href="/logout"
                                    >
                                        <FaSignOutAlt />
                                        <FormattedMessage id="common.logout" />
                                    </Button>

                                </div>
                            )}
                        </div>
                    </Card.Header>
                    <Outlet />
                </Card.Body>
            </Card>
        </Container>
    );
};
const mapStateToProps = (state) => {
    return {

        access_token: state.admin.access_token,
        refresh_token: state.admin.refresh_token,
        adminInfo: state.admin.adminInfo,
        notify: state.app.notify,
        toastify: state.app.toastify,
        language: state.app.language,
        pageInfo: state.app.pageInfo,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        changeLanguageAppRedux: (language) =>
            dispatch(actions.changeLanguageApp(language)),
        clearUserRedux: () => dispatch(actions.userLoginFail()),

        setConfig: (config) => dispatch(actions.setConfig(config)),

        setAccessToken: (token) =>
            dispatch(actions.setAccessToken(token)),
        clearAccessToken: () => dispatch(actions.clearAccessToken()),

        setRefreshToken: (token) =>
            dispatch(actions.setRefreshToken(token)),
        clearRefreshToken: () => dispatch(actions.clearRefreshToken),

        adminLogout: () => dispatch(actions.processLogout()),

        setAdmin: (adminInfo) => dispatch(actions.setAdmin(adminInfo)),
        unsetAdmin: () => dispatch(actions.unsetAdmin()),

        setToastify: (toastify) => dispatch(actions.setToastify(toastify)),
        clearToasts: () => dispatch(actions.clearToastify()),

        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(Layout);

