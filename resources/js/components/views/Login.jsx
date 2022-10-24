import React, { useEffect, useState, useRef } from "react";
import { useNavigate } from "react-router-dom";

import {
    Col,
    Row,
    Form,
    InputGroup,
    Button,
    ButtonGroup,
    ButtonToolbar,
    Card,
    Container,
} from "react-bootstrap";
import {
    FaLock,
    FaEyeSlash,
    FaEye,
    FaUserAlt,
    FaSignInAlt,
} from "react-icons/fa";
//util
import {
    CheckRef,
    Response,
    LANGUAGES,
    CheckRequest,
    Notification,
    DateTime,
    CheckToken
} from "../utils";
//reduxStore
import { connect } from "react-redux";
import * as actions from "../store/actions";
//language
import { FormattedMessage, useIntl } from "react-intl";
//component
import Notify from "../component/Notify";
import InputCustom from "../component/InputCustom";
import ModalCustom from "../component/ModalCustom";
//image
import Logo from "../assets/images/logo192.png";
import VI from "../assets/images/lang/VI.png";
import EN from "../assets/images/lang/EN.png";
//api
import AuthApi from "../apis/AuthApi";
import OauthApi from "../apis/OauthApi";


const Login = (props) => {
    const history = useNavigate();
    const prevState = CheckRef.CheckRender();
    const intl = useIntl();
    const mobile = Response.CheckMobile();
    const tablet = Response.CheckTablet();
    const [loading, setLoading] = useState(true);

    const { APP_NAME } = process.env;
    const initValues = {
        username: "",
        password: "",
        recaptcha: "",
    };
    const [validated, setValidated] = useState(false);
    //type input
    const [typeInput, setTypeInput] = useState("password");
    //showpasswd
    const [showpasswd, setShowpass] = useState(false);
    //form value
    const [formValues, setFormValues] = useState(initValues);

    //form err
    const [formErrs, setFormErrs] = useState(false);
    const handleShowPasswd = () => {
        setShowpass(true);
    };
    const handleHidePasswd = () => {
        setShowpass(false);
    };
    /**
    * toggle set show password
    */
    useEffect(() => {
        showpasswd ? setTypeInput("text") : setTypeInput("password");
    }, [showpasswd, formValues, formErrs]);
     //input
    const input = [
        {
            label: intl.formatMessage({ id: "label.username" }),
            name: "username",
            type: "text",
            value: formValues["username"],
            placeholder: intl.formatMessage({
                id: "placeholder.username",
            }),
            iconStart: (
                <FaUserAlt
                    sx={{
                        color: "green",
                        fontSize: 20,
                    }}
                />
            ),
            iconEnd: null,
            error:
                formErrs && formErrs.find((err) => err.includes("username"))
                    ? intl.formatMessage({
                          id: formErrs.find((err) => err.includes("username")),
                      })
                    : null,
        },
        {
            label: intl.formatMessage({ id: "label.password" }),
            name: "password",
            type: typeInput,
            value: formValues["password"],
            placeholder: intl.formatMessage({
                id: "placeholder.password",
            }),
            iconStart: (
                <FaLock
                    sx={{
                        color: "green",
                        fontSize: 20,
                    }}
                />
            ),
            error:
                formErrs && formErrs.find((err) => err.includes("password"))
                    ? intl.formatMessage({
                          id: formErrs.find((err) => err.includes("password")),
                      })
                    : null,
            iconEnd: showpasswd ? <FaEyeSlash /> : <FaEye />,
            handleFunc: showpasswd ? handleHidePasswd : handleShowPasswd,
        },
    ];

    const ChangeLang = () => {
        props.language && props.language === "en"
            ? props.changeLanguageAppRedux(LANGUAGES.VI)
            : props.changeLanguageAppRedux(LANGUAGES.EN);
    };


    useEffect(() => {
        setLoading(false);
        if (prevState) {
            if (props.access_token && props.refresh_token) {
                const notify = {
                    title: "res.title.info",
                    text: ["res.logged"],
                    icon: "info",
                    confirmText: "common.ok",
                    confirm: () => {
                        props.clearNotify();
                        history("/");
                    },
                };
                props.setNotify(notify);
            }
        }
    }, [loading]);
    const OnChange = (e) => {
        const { name, value } = e.target;
        const { error } = e.target;
        setFormValues({ ...formValues, [name]: value });
    };

    const Submit = async (e) => {
        e.preventDefault();
        const form = e.currentTarget;
        if (form.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        setValidated(true);
        try {
            const { CLIENT_ID, CLIENT_SECRET } = process.env;
            const data = {
                grant_type: 'password',
                client_id: CLIENT_ID,
                client_secret: CLIENT_SECRET,
                username: formValues.username,
                password: formValues.password,
                scope: "storage"
            }
            const response = await OauthApi.Token(data);
            return setAdmin(response);
        } catch (err) {
            const notify = {
                title: "res.title.error",
                text: ["common.bad-request"],
                icon: "error",
                confirmText: "common.ok",
                confirm: () => {
                    props.clearNotify();
                },
            };
            props.setNotify(notify);
        }
    }
    const setAdmin = (response) => {

        const user = { ...response.data };

        const expires_in = (user.expires_in);
        const expires = new Date();
        expires.setTime(expires.getTime() + expires_in * 1000);

        const access_token = {
            access_token: user.access_token,
            expires: expires,
        };
        const RefreshToken_expries = new Date();
        RefreshToken_expries.setTime(RefreshToken_expries.getTime() + 31556926 * 1000);
        const refresh_token = {
            refresh_token: user.refresh_token,
            expires: RefreshToken_expries
        }
        props.setAccessToken(access_token);
        props.setRefreshToken(refresh_token);
        const notify = {
            title: "res.title.success",
            text: ["res.loginsuccess"],
            icon: "success",
            confirmText: "common.ok",
        };
        props.setNotify(notify);
        history("/");
    };
    return (
        <Container>
            <Col
                md={4}
                className={mobile ? "mobile auth-wrapper" : "auth-wrapper"}
            >
                <Row className={mobile ? "mobile auth-inner" : "auth-inner"}>
                    <Col
                        md={12}
                        className="logo-center d-flex justify-content-center"
                    >
                        <Row className="d-flex justify-content-column">
                            <img src={props.config?.site.logo || Logo} alt="" />
                            <h3 >
                                {APP_NAME}
                            </h3>
                        </Row>
                    </Col>

                    <Form
                        noValidate
                        validated={validated}
                        onSubmit={Submit}
                    >
                        {input.map((input, key) => {
                            return (
                                <InputCustom
                                    required
                                    key={key}
                                    type={input.type}
                                    label={input.label}
                                    name={input.name}
                                    placeholder={input.placeholder}
                                    iconStart={input.iconStart}
                                    iconEnd={input.iconEnd}
                                    error={input.error}
                                    onChange={OnChange}
                                    handleFunc={input.handleFunc}
                                    isInvalid={input.error}
                                />
                            );
                        })}
                        <Col
                            md={6}
                            className="btn-submit"
                        >
                            <Button variant="success" type="submit">
                                <FaSignInAlt />{" "}
                                {intl.formatMessage({
                                    id: "common.login",
                                })}
                            </Button>
                        </Col>
                        <Col md={4} className="language">
                            <Button
                                variant="outline-secondary"
                                size="sm"
                                id="action"
                                className="btn-circle"
                                onClick={ChangeLang}
                            >
                                <img src={props.language === "en" ? EN : VI} />
                            </Button>
                        </Col>
                    </Form>
                </Row>
            </Col>
        </Container>
    );
};

const mapStateToProps = (state) => {
    return {
        access_token: state.admin.access_token,
        refresh_token: state.admin.refresh_token,
        language: state.app.language,
        sidebar: state.app.statusbar,
        config: state.app.config,
        notify: state.app.notify,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        setAppSidebar: (sidebar) => dispatch(actions.setSidebar(sidebar)),
        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),

        setConfig: (config) => dispatch(actions.setConfig(config)),

        changeLanguageAppRedux: (language) =>
            dispatch(actions.changeLanguageApp(language)),

        setAccessToken: (token) =>
            dispatch(actions.setAccessToken(token)),
        clearAccessToken: () => dispatch(actions.clearAccessToken()),

        setRefreshToken: (token) =>
            dispatch(actions.setRefreshToken(token)),

        clearRefreshToken: () => dispatch(actions.clearRefreshToken),
        unsetAdmin: () => dispatch(actions.unsetAdmin()),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(Login);

