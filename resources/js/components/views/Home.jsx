import React, { useEffect, useState } from "react";
import { Button, Card, Col, Container, Form, FormControl, InputGroup, Row } from "react-bootstrap";
import Skeleton from "react-loading-skeleton";
import ReactDOM from "react-dom";
import { FormattedMessage, useIntl } from "react-intl";

import { useNavigate } from "react-router-dom";
//reduxStore
import { connect } from "react-redux";
import * as actions from "../store/actions";
import {
    FaLock,
    FaEyeSlash,
    FaEye,
    FaUserAlt,
    FaSignInAlt,
    FaSignOutAlt,
    FaUserCircle
} from "react-icons/fa";
import { TbApps, TbLockAccess, TbApi } from "react-icons/tb";
import { BsFileEarmarkLock2Fill, BsClockHistory } from "react-icons/bs"
import {
    MdContentCopy,
    MdDriveFileRenameOutline,
    MdLabel,
    MdRemoveCircle
} from "react-icons/md"
//util
import {
    CheckRef,
    Response,
    LANGUAGES,
    CheckRequest,
    DateTime,
    Notification,
} from "../utils";
import OauthApi from "../apis/OauthApi";
import CardCustom from "../component/CardCustom";
import CopyButton from "../component/CopyButton";
import ModalCustom from "../component/ModalCustom";
import InputCustom from "../component/InputCustom";
//image
import Logo from "../assets/images/logo192.png";
import AuthApi from "../apis/AuthApi";

const Home = (props) => {
    const history = useNavigate();
    const prevState = CheckRef.CheckRender();
    const [loading, setLoading] = useState(true);
    const intl = useIntl();
    const mobile = Response.CheckMobile();
    const tablet = Response.CheckTablet();
    const [adminProfile, setAdminProfile] = useState(false);
    const [clients, setClients] = useState([]);
    const [modal, setModal] = useState(false);
    const initValues = {
        name: "",
        redirect: "http://127.0.0.1",
    }
    const [formValues, setFormValues] = useState(initValues);
    const [formErr, setFormErrs] = useState([]);
    useEffect(() => {
        setLoading(false);
        const infoPage = {
            title: "page.home",
            desc: "page.home",
        };
        props.setPageInfo(infoPage);
        if (prevState) {
            setAdminProfile(props.adminInfo);
            if (props.access_token) {
                getClients();
            }
        }
    }, [loading]);
    useEffect(() => {
        if (prevState) {
            getClients();
        }
    }, [props.access_token])
    const input = {
        label: intl.formatMessage({ id: "label.refresh_token" }),
        name: "copy",
        type: "text",
        iconStart: (
            <BsFileEarmarkLock2Fill
                sx={{
                    color: "green",
                    fontSize: 20,
                }}
            />
        ),
        disable: true,
        iconEnd: <MdContentCopy />,
    };
    const input2 = {
        label: intl.formatMessage({ id: "label.name" }),
        name: "name",
        type: "text",
        iconStart: (
            <MdDriveFileRenameOutline
                sx={{
                    color: "green",
                    fontSize: 20,
                }}
            />
        ),
    }
    const OnChange = (e) => {
        const { name, value } = e.target;
        setFormValues({ ...formValues, [name]: value });
    }
    const toggleModal = () => {
        setModal(!modal);
    }
    const getClients = async () => {
        try {
            const response = await OauthApi.getClient();
            setClients(response.data)
        } catch (err) {
            const notify = {
                title: "res.title.error",
                text: ["res.getdata.fail"],
                icon: "error",
                confirmText: "common.ok",
            }
            props.setNotify(notify);
        }
    }
    const Submit = async () => {
        try {
            const response = await OauthApi.createClient(formValues);
            const notify = {
                title: "res.title.success",
                text: ["res.add.success"],
                icon: "success",
                confirmText: "common.ok",
            }
            props.setNotify(notify);
            getClients();
            setModal(!modal);
        } catch (err) {
            const notify = {
                title: "res.title.error",
                text: ["res.add.fail"],
                icon: "error",
                confirmText: "common.ok",
            }
            props.setNotify(notify);
            setModal(!modal);
        }
    }
    const toggleDelete = (id) => {
        const notify = {
            title: "res.title.warning",
            text: ["res.ask.delete"],
            icon: "warning",
            confirmText: "common.ok",
            cancelText: "common.cancel",
            confirm: () => {
                removeClient(id);
            },
            cancel: () => {
                props.clearNotify();
            },
        };
        props.setNotify(notify);
    }
    const removeClient = async (id) => {
        try {
            const response = await OauthApi.deleteClient(id);
            const notify = {
                title: "res.title.success",
                text: ["res.delete.success"],
                icon: "success",
                confirmText: "common.ok",
            }
            props.setNotify(notify);
            getClients();
        } catch (err) {
            const notify = {
                title: "res.title.error",
                text: ["res.delete.fail"],
                icon: "error",
                confirmText: "common.ok",
            }
            props.setNotify(notify);
        }
    }
    return (
        <Col md={12}>
            <Row className="justify-content-md-center">
                {modal ? (
                    <ModalCustom show={modal}
                        closeFunc={toggleModal}
                        title={"label.add"}
                        close={"common.close"}
                        confirm={"common.confirm"}
                        handleClose={toggleModal}
                        handleConfirm={Submit}
                        content={
                            <>
                                <Form>
                                    <InputCustom
                                        required
                                        label={input2.label}
                                        name={input2.name}
                                        type={input2.type}
                                        placeholder={input.placeholder}
                                        iconStart={input2.iconStart}
                                        iconEnd={input2.iconEnd}
                                        errorshow={input2.errorshow}
                                        error={input2.error}
                                        onChange={OnChange}
                                        isInvalid={input.error}
                                    />
                                </Form>
                            </>
                        } />
                ) : null}
                <Col md={mobile ? 12 : 4} className="d-flex justify-content-center">
                    <CardCustom
                        md={3}
                        hg={3}
                        border={12}
                        content={{
                            header: (
                                <>
                                    {prevState && props.adminInfo ? (
                                        <img className="avatar" src={Logo} />
                                    ) : (
                                        <FaUserCircle size="2em" />
                                    )}

                                    {prevState ? (
                                        <h4 style={{ fontWeight: 600 }}>
                                            {props.adminInfo.name}
                                        </h4>
                                    ) : (
                                        <strong>
                                            <Skeleton />
                                        </strong>
                                    )}
                                </>
                            ),
                            body: (
                                <>
                                    <Col>
                                        <strong htmlFor="username">
                                            <FormattedMessage
                                                id={"label.username"}
                                            />
                                            {": "}
                                        </strong>
                                        {prevState ? (
                                            <span id="username">
                                                {props.adminInfo.username}
                                            </span>
                                        ) : (
                                            <Skeleton />
                                        )}
                                    </Col>
                                    <Col>
                                        <strong htmlFor="name">
                                            <FormattedMessage id={"label.name"} />
                                            {": "}
                                        </strong>
                                        {props.adminInfo ? (
                                            <span id="name">
                                                {props.adminInfo.name}
                                            </span>
                                        ) : (
                                            <Skeleton />
                                        )}
                                    </Col>
                                    <Col>
                                        <strong htmlFor="email">
                                            <FormattedMessage id={"label.email"} />
                                            {": "}
                                        </strong>
                                        {prevState ? (
                                            <span id="email">
                                                {props.adminInfo.email}
                                            </span>
                                        ) : (
                                            <Skeleton />
                                        )}
                                    </Col>
                                </>
                            ),
                        }}
                    />
                </Col>
                <Col md={12}>
                    <Card>
                        <div className="form_group">
                            {prevState && props.access_token ? (
                                <div className="form-group">
                                    <Button variant="success" onClick={toggleModal} className="float-start form_group">
                                        <TbApps />{" "}
                                        <FormattedMessage id="common.add" />
                                    </Button>
                                    <Button
                                        variant="success"
                                        className="float-end form_group"
                                        onClick={() => { window.open('/api/docs', '_blank') }
                                        }
                                    >
                                        <TbApi /> {"API"}
                                    </Button>
                                    <Button
                                        variant="primary"
                                        className="float-end form_group"
                                        onClick={() => { window.open('/log', '_blank') }
                                        }
                                    >
                                        <BsClockHistory /> {"Logs"}
                                    </Button>
                                </div>
                            ) : null}
                        </div>
                        <div className="form_group">
                            <Row>
                                {clients ? clients.map((client, key) => (
                                    <Col md={6} key={key}>
                                        <Card className="form_group" >
                                            <Card.Header>
                                                <span>App {client.name}  {key}</span>
                                                <Button
                                                    variant="danger"
                                                    className="float-end"
                                                    onClick={() => {
                                                        toggleDelete(client.id)
                                                    }
                                                    }
                                                >
                                                    <MdRemoveCircle />
                                                </Button>
                                            </Card.Header>
                                            <CopyButton
                                                label={<FormattedMessage id="label.name" />}
                                                disabled={true}
                                                value={client.name}
                                                tooltip={<FormattedMessage id="label.name" />}
                                                iconStart={<MdLabel />}
                                                iconEnd={<MdContentCopy />}
                                            />
                                            <CopyButton
                                                label={<FormattedMessage id="label.client_id" />}
                                                disabled={true}
                                                value={client.id}
                                                tooltip={<FormattedMessage id="label.client_id" />}
                                                iconStart={<MdLabel />}
                                                iconEnd={<MdContentCopy />}
                                            />
                                            <CopyButton label={<FormattedMessage id="label.client_secret" />}
                                                disabled={true}
                                                value={client.secret}
                                                tooltip={<FormattedMessage id="label.client_secret" />}
                                                iconStart={<MdLabel />}
                                                iconEnd={<MdContentCopy />}
                                            />
                                            <span className="form_group">{DateTime.format(client.updated_at)}</span>
                                        </Card>
                                    </Col>
                                )) : null}
                            </Row>
                        </div>
                    </Card>
                </Col>
            </Row>
        </Col>
    );
};
const mapStateToProps = (state) => {
    return {
        access_token: state.admin.access_token,
        refresh_token: state.admin.refresh_token,
        adminInfo: state.admin.adminInfo,
        language: state.app.language,
        sidebar: state.app.statusbar,
        config: state.app.config,
        notify: state.app.notify,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        setAccessToken: (token) =>
            dispatch(actions.setAccessToken(token)),
        clearAccessToken: () => dispatch(actions.clearAccessToken()),

        setRefreshToken: (token) =>
            dispatch(actions.setRefreshToken(token)),
        clearRefreshToken: () => dispatch(actions.clearRefreshToken),
        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),
        clearNotify: () => dispatch(actions.clearNotify()),
        setToasts: (toastify) => dispatch(actions.setToastify(toastify)),
        setConfig: (config) => dispatch(actions.setConfig(config)),
        setPageInfo: (infoPage) => dispatch(actions.appSetInfoPage(infoPage)),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(Home);

