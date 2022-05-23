import BaseApi from "../BaseApi";
export default {
    update(payload) {
        return BaseApi.post("/masterfile/province/update", payload);
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/province/show?page=${page}`, {
            params: filterData
        });
    },
    status(payload) {
        return BaseApi.post("/masterfile/province/status", payload);
    },
    save(payload) {
        return BaseApi.post("/masterfile/province/save", payload);
    }
};
