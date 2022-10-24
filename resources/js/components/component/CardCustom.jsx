import React from "react";
import { Response } from "../utils";
/**
 * Card Custom
 *
 * @param {Object} style            - Style
 * @param {Object} content.header   - header card content
 * @param {Object} content.body     - body card content
 * @property {var} md               - style margin
 * @property {var} hg               - style height
 * @property {var} border           - style border
 * @return {DomElement}             - return view
 */
const CardCustom = ({ style, content, ...props }) => {
    const mobile = Response.CheckMobile();
    const colors = {
        primary: "#0d6efd",
        success: "#22a033",
        secondary: "#dee2e6",
        warning: "#efbd49",
        danger: "#dc3545",
    };

    const makeColor = `${colors[props.color]}` || "#22a033";
    const width = mobile? "276" : props?.md * 100 || "300";
    const height = props?.hg * 100 || "300";
    const styled = {
        maxWidth:  `${width}px`,
        backgroundColor: "#fff",
        border: "1px solid #e9ecef",
        borderRadius: `${props?.border}px` || "12px",
        justifyContent: "center",
        alignItems: "center",
        flex: "0 0 32%",
        boxShadow: "0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)"
    };
    const styled2 = {
        minHeight: `${height / 3}px`,
        maxWidth: `${width * 0.95}px`,
        marginLeft: "auto",
        marginRight: "auto",
        position: "relative",
        top: "50%",
        transform: "translate( -0.5%,-33%)",
        borderRadius: `${props?.border}px` || "5px",
        backgroundImage: "linear-gradient(to right, #1dd1a1, #1abc9c)",
        boxShadow:
            "0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)",
    };
    return (
        <div
            className="wrappcard"
            style={{
                paddingTop: (height + height / 3 + (height * 2) / 100) / 10,
                paddingBottom: ((height / 3) * 20) / 100,
                maxWidth: `${width + 30}px`,
                maxHeight: `${height + height / 3 + (height * 2) / 100}px`,
            }}
        >
            <div className="card_custom" style={style?.card || { ...styled }}>
                <div
                    className="header_card"
                    style={
                        style?.header || {
                            ...styled2,
                        }
                    }
                >
                    {content?.header}
                </div>
                <div className="content">{content?.body}</div>
            </div>
        </div>
    );
};

export default CardCustom;
