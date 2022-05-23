import BaseApi from "./BaseApi";

export default {
    update(payload) {
        return BaseApi.post("/masterfile/barangay/update", payload);
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/barangay/show?page=${page}`, {
            params: filterData
        });
    },
    status(payload) {
        return BaseApi.post("/masterfile/barangay/status", payload);
    },
    create(payload) {
        return BaseApi.post("/masterfile/barangay/create", payload);
    }
};
