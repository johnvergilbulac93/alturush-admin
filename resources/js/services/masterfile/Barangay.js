import BaseApi from "../BaseApi";
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
    save(payload) {
        return BaseApi.post("/masterfile/barangay/save", payload);
    }
};
