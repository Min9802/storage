import React, { useState, useEffect } from "react";
import {
    Col,
    Form,
    Row,
    InputGroup,
    Button,
    Card,
    FormCheck,
} from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { ImHome } from "react-icons/im";
import { AiFillBackward } from "react-icons/ai";
//reduxStore
import * as actions from "../store/actions";
import { connect } from "react-redux";
//language
import { FormattedMessage, useIntl } from "react-intl";
//util
import {
    LANGUAGES,
    CheckRef,
    Response,
    CheckRequest,
    Notification,
} from "../utils";
const NotFound = (props) => {
    const intl = useIntl();
    const prevState = CheckRef.CheckRender();
    const history = useNavigate();
    const mobile = Response.CheckMobile();
    const [loading, setLoading] = useState(true);
    useEffect(() => {
        setLoading(false);
        const infoPage = {
            title: "page.notfound",
            desc: "page.notfound",
        };
        props.setPageInfo(infoPage);
    }, [loading]);
    return (
        <Card>
            <Card.Body className={mobile ? "wrrap404 mobile" : "wrrap404"}>
                <Col className={mobile ? "top_text mobile" : "top_text"}>
                    <h1 className="text">
                        <FormattedMessage id={"page.notfound"} />
                    </h1>
                    <Col className="form_group">
                        <Button
                            onClick={() => {
                                history("/");
                            }}
                        >
                            <ImHome /> <FormattedMessage id={"page.home"} />
                        </Button>
                    </Col>
                    <Col className="form_group">
                        <Button
                            onClick={() => {
                                history(-1);
                            }}
                        >
                            <AiFillBackward />{" "}
                            <FormattedMessage id={"page.back"} />
                        </Button>
                    </Col>
                </Col>
                <h1 className={mobile ? "bg_text mobile" : "bg_text"}>404</h1>
            </Card.Body>
        </Card>
    );
};
const mapStateToProps = (state) => {
    return {
        notify: state.app.notify,
        admin: state.admin.admin,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),
        setToasts: (toastify) => dispatch(actions.setToastify(toastify)),
        setPageInfo: (infoPage) => dispatch(actions.appSetInfoPage(infoPage)),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(NotFound);
