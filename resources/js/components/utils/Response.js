import { useRef, useEffect, useState } from "react";
import { useMediaQuery } from "react-responsive";
import CheckRef from "./CheckRef";
/**
 * Check Response
 * @return size screen device
 */
class Response {
    /**
     *
     * @returns {var} isMobile
     */
    static CheckMobile = () => {
        const isDesktop = useMediaQuery({
            query: "(min-width: 1224px)",
        });
        const isMobile = useMediaQuery({
            query: "(min-width: 375px) and (max-width:480px)",
        });

        const isTabletOrMobile = useMediaQuery({
            query: "(max-width: 1224px)",
        });

        return isMobile;
    };
    /**
     *
     * @returns {var} isTablet
     */
    static CheckTablet = () => {
        const isTablet = useMediaQuery({ query: "(min-width: 768px)" });
        return isTablet;
    };
}
export default Response;
