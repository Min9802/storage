class CheckRequest {
    static fail = (err) => {
        const error = err.response.data.message;
        const ListErrs = [];
        const listErr = Object.keys(error).map((key, i) => {
            const Err = error[key][0];
            ListErrs.push(key.concat(Err.split("validation.").join(".")));
        });
        return ListErrs;
    };
}
export default CheckRequest;
