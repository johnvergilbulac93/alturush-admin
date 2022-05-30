import BaseApi from "../BaseApi";
export default {
    update(payload) {
        return BaseApi.post("/masterfile/voucher/update", payload);
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/voucher/show?page=${page}`, {
            params: filterData
        });
    },
    status(payload) {
        return BaseApi.post("/masterfile/voucher/change_status", payload);
    },
    save(payload) {
        return BaseApi.post("/masterfile/voucher/create", payload);
    }
};
