class Notification {
    /**
     * Utils Notification
     * @param {Object} err      - set Object error
     * @returns
     */
    static setNotify = (err) => {
        const statuscode = err.response.status;
        const status = err.response.data.status;
        const message = err.response.data.message;
        let notify;
        switch (statuscode) {
            case 422 || 400:
                notify = {
                    type: "notify",
                    data: {
                        title: "res.title.error",
                        text: message,
                        icon: "error",
                        confirmText: "common.ok",
                    },
                    validate: message,
                };

                break;
            case 403:
                notify = {
                    type: "toasts",
                    data: {
                        status: "error",
                        text: message,
                    },
                };
                break;
            default:
                notify = {
                    type: "notify",
                    data: {
                        title: "res.title." + status,
                        text: [message],
                        icon: status,
                        confirmText: "common.ok",
                    },
                };
                break;
        }

        return notify;
    };
}
export default Notification;
