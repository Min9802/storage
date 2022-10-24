import React,{useState, useEffect} from 'react';
import { Modal,Button } from "react-bootstrap";
import { FormattedMessage, useIntl } from "react-intl";
//check render
import { CheckRef, LANGUAGES } from "../utils";
/**
 * Require
 * @property {Object} props            - Object props
 * @property {var} show                - Set Show
 * @property {var} title               - Set Title
 * @property {var} content             - Set content
 * @property {var} close               - Set close
 * @property {var} confirm             - Set confirm
 * @property {function} handleConfirm  - Set handleConfirm
 * @property {function} closeFunc      - Set closeFunc
 */
const ModalCustom = (props) => {
    const intl = useIntl();
    const prevState = CheckRef.CheckRender();
    const [show, setShow] = useState(false);
    const [loading, setLoading] = useState(true);
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
    useEffect(() => {
        setLoading(false);
        if (prevState) {
            setShow(props.show);
        }
    },[loading])
    return (
        <div>
            <Modal
                show={show}
                onHide={() => {
                    handleClose();
                    props.closeFunc();
                }}
            >
                <Modal.Header closeButton>
                    <Modal.Title>
                        {props.title ?<FormattedMessage id={props.title} />: null }

                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>{props?.content}</Modal.Body>
                <Modal.Footer>
                    <Button
                        variant="secondary"
                        onClick={() => {
                            handleClose();
                            props.closeFunc();
                        }}
                    >
                        <FormattedMessage id={props.close} />
                    </Button>
                    <Button variant="primary" onClick={props.handleConfirm}>
                        <FormattedMessage id={props.confirm} />
                    </Button>
                </Modal.Footer>
            </Modal>
        </div>
    );
};

export default ModalCustom;
