import { ToastContainer, toast } from "react-toastify";
import { connect, useDispatch, useSelector } from "react-redux";
import * as actions from "../store/actions";
//language
import { FormattedMessage, useIntl } from "react-intl";
//utils
import CheckRef from "../utils/CheckRef";
import { useEffect, useState } from "react";
/**
 * Toastify
 * @param {Object} props  - set Object props
 * @property {var} status - set Status
 * @property {var} text   - set Text content
 * @property {var} close  - set time close
 * @returns
 */
const Toastify = (props) => {
    const intl = useIntl();
    let toastify = props.toastify;
    const [loading, setLoading] = useState(true);
    const prevState = CheckRef.CheckRender();
    const CheckToastify = () => {
        if (toastify) {
            switch (toastify.status) {
                case "success":
                    toast.success(
                        toastify.text,
                        {
                            position: toast.POSITION.TOP_RIGHT,
                        },
                        {
                            autoClose: toastify.close ? toastify.close : 5000,
                        }
                    );
                    setTimeout(
                        () => {
                            props.clearToasts();
                        },
                        toastify.close ? toastify.close : 6000
                    );
                    break;
                case "error":
                    toast.error(
                        toastify.text,
                        {
                            position: toast.POSITION.TOP_RIGHT,
                        },
                        {
                            autoClose: toastify.close ? toastify.close : 5000,
                        }
                    );
                    setTimeout(
                        () => {
                            props.clearToasts();
                        },
                        toastify.close ? toastify.close : 6000
                    );
                    break;
                case "warn":
                    toast.warn(
                        toastify.text,
                        {
                            position: toast.POSITION.TOP_RIGHT,
                        },
                        {
                            autoClose: toastify.close ? toastify.close : 5000,
                        }
                    );
                    setTimeout(
                        () => {
                            props.clearToasts();
                        },
                        toastify.close ? toastify.close : 6000
                    );
                    break;
                case "info":
                    toast.info(
                        toastify.text,
                        {
                            position: toast.POSITION.TOP_RIGHT,
                        },
                        {
                            autoClose: toastify.close ? toastify.close : 5000,
                        }
                    );
                    setTimeout(
                        () => {
                            props.clearToasts();
                        },
                        toastify.close ? toastify.close : 6000
                    );
                    break;
            }
        }
    };
    useEffect(() => {
        setLoading(false);
        if (prevState) {
            CheckToastify();
        }
    }, [loading]);
    return (
        <ToastContainer
            position="top-right"
            autoClose={6000}
            hideProgressBar={false}
            newestOnTop={false}
            closeOnClick
            rtl={false}
            pauseOnFocusLoss
            draggable
            pauseOnHover
        />
    );
};
const mapStateToProps = (state) => {
    return {
        notify: state.app.notify,
        toastify: state.app.toastify,
        language: state.app.language,
    };
};
const mapDispatchToProps = (dispatch) => {
    return {
        setToasts: (toastify) => dispatch(actions.setToastify(toastify)),
        clearToasts: () => dispatch(actions.clearToastify()),
    };
};
export default connect(mapStateToProps, mapDispatchToProps)(Toastify);
