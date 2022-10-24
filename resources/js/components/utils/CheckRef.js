import { useRef, useEffect } from "react";
class CheckRef {
    /**
     *  Check Ref
     * @return {ref.current} - return ref
     */
    static CheckRender = () => {
        const ref = useRef(false);
        useEffect(() => {
            ref.current = true;
            return () => {
                ref.current = false;
            };
        }, []);
        return ref.current;
    };
}
export default CheckRef;
