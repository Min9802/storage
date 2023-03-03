import React, { useState, useEffect, useRef } from "react";
import { InputGroup, Overlay, Form, Tooltip } from "react-bootstrap";
//redux
import { connect } from "react-redux";
import * as actions from "../store/actions";
//language
import { FormattedMessage, useIntl } from "react-intl";
//ultis
import {
    CheckRef,
    LANGUAGES,
    Response,
    ArrUtils,
    Notification,
} from "../utils";
/**
 * Copy Button component
 * @param {Object} iconStart    - Set Icon start
 * @param {Object} iconEnd      - Set Icon end
 * @param {Object} tooltip      - Set tooltip
 * @param {Object} props        - Set Properties
 * @returns {DomElement}        - return view
 */
const CopyButton = ({ iconStart, iconEnd, tooltip, ...props }) => {
    const intl = useIntl();
    const prevState = CheckRef.CheckRender();

    const [show, setShow] = useState(false);
    const [loading, setLoading] = useState(true);

    const keys = Object.keys(props).filter(
        (key) => typeof props[key] !== "function"
    );
    const values = keys.map((key) => props[key]);
    const newArr = ArrUtils.combine(keys, values);
    const { value } = props;
    const [attr, setAttr] = useState(newArr);

    const target = useRef(null);

    useEffect(() => {
        setLoading(false);
        if (prevState) {
        }
    }, [loading]);
    //handle function copy
    const handleCopy = async (e) => {
        setShow(true);
        try {
            await navigator.clipboard.writeText(value);
            const notify = {
                status: "success",
                text: [
                    intl.formatMessage({ id: "res.copytoclipboard.success" }),
                ],
            };
            props.setToasts(notify);
        } catch (err) {
            const notify = {
                status: "error",
                text: [intl.formatMessage({ id: "res.copytoclipboard.fail" })],
            };
            props.setToasts(notify);
        }
    };
    return (
        <div className="form_group">
            <Form.Label>{attr.label}</Form.Label>
            <InputGroup md={3}>
                <InputGroup.Text id="basic-addon1">{iconStart}</InputGroup.Text>
                <Form.Control {...attr} />
                {iconEnd ? (
                    <>
                        <InputGroup.Text ref={target}>
                            <i className="icon_end" onClick={handleCopy}>
                                {iconEnd}
                            </i>
                        </InputGroup.Text>
                        <Overlay
                            target={target.current}
                            show={show}
                            placement="right"
                        >
                            {(props) => (
                                <Tooltip id="overlay-example" {...props}>
                                    {tooltip}
                                </Tooltip>
                            )}
                        </Overlay>
                    </>
                ) : null}
            </InputGroup>
        </div>
    );
};

const mapStateToProps = (state) => {
    return {};
};
const mapDispatchToProps = (dispatch) => {
    return {
        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),
        setToasts: (toastify) => dispatch(actions.setToastify(toastify)),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(CopyButton);
