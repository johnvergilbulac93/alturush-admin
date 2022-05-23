import BaseApi from "../BaseApi";

export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/payment_method/show?page=${page}`, {
            params: filterData
        });
    },
    save(payload) {
        return BaseApi.post("/masterfile/payment_method/create", payload);
    },
    update(payload) {
        return BaseApi.post("/masterfile/payment_method/update", payload);
    },
    changeStatus(payload) {
        return BaseApi.post("/masterfile/payment_method/change_status",payload);
    }
};
