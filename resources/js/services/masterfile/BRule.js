import BaseApi from "../BaseApi";

export default {
    show() {
        return BaseApi.get("/masterfile/rule/show");
    },
    update(payload) {
        return BaseApi.post("/masterfile/rule/update", payload);
    }
};
