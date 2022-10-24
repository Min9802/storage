class DateTime {
    static format = (time) => {
        const options = {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        };
        return new Date(time).toLocaleDateString(undefined, options);
    };
}

export default DateTime;
