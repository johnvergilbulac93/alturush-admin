import axios from "axios";
import NProgress from "nprogress";
import { Message } from "view-design";

const Http = axios.create({
    baseURL: "/api/"
});

Http.interceptors.request.use(
    config => {
        // Called on request
        // NProgress.start()

        return config;
    },
    error => {
        // NProgress.done()

        return Promise.reject(error);
    }
);
Http.interceptors.response.use(
    response => {
        // Called on response
        // NProgress.done()

        return response;
    },
    error => {
        // NProgress.done()

        // store.commit("CHECK_SESSION", true);

        const { status } = error.response;

        const UNAUTHORIZED = 401;

        if (status === UNAUTHORIZED) {
            Message.error({
                background: true,
                content: "Session Expired. Please reload the page to continue."
            });
        }
        return Promise.reject(error);
    }
);

export default Http;
