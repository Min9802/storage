import React from 'react';
import { Col, Form, Row, InputGroup, Button, Card } from "react-bootstrap";

/**
 * Require
 * @param {Object} label       - Set Label
 * @param {Object} iconStart   - Set Icon Start
 * @param {Object} iconEnd     - Set Icon End
 * @param {Object} error       - Set Error
 * @param {Object} validate    - Set Validate
 * @param {Object} handleFunc  - Set HandleFunction
 * @param {Object} props       - Set Attributes
 */
const InputCustom = ({
    label,
    iconStart,
    iconEnd,
    error,
    validate,
    handleFunc,
    ...props
}) => {
    return (
        <Form.Group className="form_group">
            <Form.Label>{label}</Form.Label>
            <InputGroup>
                <InputGroup.Text id="basic-addon1">{iconStart}</InputGroup.Text>
                <Form.Control {...props} />
                {iconEnd ? (
                    <InputGroup.Text>
                        <i className="icon_end" onClick={handleFunc}>{iconEnd}</i>
                    </InputGroup.Text>
                ) : null}
            </InputGroup>
        </Form.Group>
    );
};

export default InputCustom;
