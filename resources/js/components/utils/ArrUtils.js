class ArrUtils {
    /**
     * join array with character
     * @param {*} char
     * @param  {...any} array
     * @returns {string} value
     */
    static joinArrays = (char, ...array) => {
        return array.join(char);
    };
    /**
     * combine data
     * @param {Array} first   - Array 1.
     * @param {Array} second  - Array 2.
     *
     * @return {Array}        - return array data
     */
    static combine = (first, second) => {
        return first.reduce((acc, val, ind) => {
            acc[val] = second[ind];
            return acc;
        }, {});
    };
    /**
     * remove duplicate data
     * @param {Array} arr   Array.
     *
     * @return {Array} return array data
     */
    static removeDuplicate = (arr) => {
        var seen = {};
        var out = [];
        var len = arr.length;
        var j = 0;
        for (var i = 0; i < len; i++) {
            var item = arr[i];
            if (seen[item] !== 1) {
                seen[item] = 1;
                out[j++] = item;
            }
        }
        return out;
    };
    /**
     * random string
     * @param {String} type   type random (text, num).
     * @param {Number} length Lenght random
     *
     * @returns {String} return string data
     */
    static Random = (type, length) => {
        var result = "";
        switch (type) {
            case "text":
                var characters =
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                break;
            case "num":
                var characters = "0123456789";
                break;
            default:
                var characters =
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        }
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(
                Math.floor(Math.random() * charactersLength)
            );
        }
        return result;
    };
}
export default ArrUtils;
