import React, { useEffect, useState } from "react";
import Swal from "sweetalert2";

import { connect, useDispatch, useSelector } from "react-redux";
import * as actions from "../store/actions";
import { useNavigate } from "react-router-dom";
//format language
import { FormattedMessage, useIntl } from "react-intl";
//utils
import CheckRef from "../utils/CheckRef";
/**
 * Notification
 * @param {Object} props        - Set Object props
 * @property {var} title        - Set title
 * @property {var} text         - Set text content
 * @property {var} icon         - Set icon
 * @property {boolean} cancel   - Set cancel
 * @property {boolean} cancel   - Set cancel
 * @property {var} confirmText  - Set confirmText
 * @property {var} cancelText   - Set cancelText
 * @property {function} confirm - Set confirm function
 * @property {function} cancel  - Set cancel function
 * @returns
 */
const Notify = (props) => {
    const [notify, setNotifyAlert] = useState(props.notify);
    const intl = useIntl();
    const history = useNavigate();
    const [loading, setLoading] = useState(true);
    const prevState = CheckRef.CheckRender();
    useEffect(() => {
        setLoading(false);
        if (prevState && notify) {
            const ArrText = [];
            const texts = notify.text;
            if ( Array.isArray(texts[0])) {
                Object.values(...texts).map((text, i) => {
                    if (notify.data && i == 1) {
                        ArrText.push(
                            " " +
                                intl.formatMessage({
                                    id: text,
                                }) +
                                notify.data
                        );
                    } else {
                        ArrText.push(
                            " " +
                                intl.formatMessage({
                                    id: text,
                                })
                        );
                    }
                });
            } else {
                if (texts.length > 1) {
                    texts.map(text => {
                        ArrText.push(
                            intl.formatMessage({
                                id: text,
                            })
                        );
                    })
                } else {
                    ArrText.push(
                        intl.formatMessage({
                            id: texts,
                        })
                    );
                }

            }

            Swal.fire({
                title: intl.formatMessage({
                    id: notify.title,
                }),
                text: ArrText,
                icon: notify.icon,
                confirmButtonText: intl.formatMessage({
                    id: notify.confirmText,
                }),
                showCancelButton: notify.cancel ? true : false,
                cancelButtonText: notify.cancelText
                    ? intl.formatMessage({
                          id: notify.cancelText,
                      })
                    : null,
            }).then((result) => {
                if (result.isConfirmed) {
                    if (notify.confirm) {
                        notify.confirm();
                    }
                } else {
                    if (notify.cancel) {
                        notify.cancel();
                    }
                }
                props.clearNotify();
                setNotifyAlert(false);
            });
        }
    }, [loading, notify]);
    useEffect(() => {
        const timeOut = setInterval(() => {
            props.clearNotify();
        }, 5000)
        return clearInterval(timeOut);
    })

    return <></>;
};
const mapStateToProps = (state) => {
    return {
        notify: state.app.notify,
        language: state.app.language,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        setNotify: (notify) => dispatch(actions.setNotify(notify)),
        clearNotify: () => dispatch(actions.clearNotify()),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(Notify);
