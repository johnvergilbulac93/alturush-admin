import BaseApi from "../BaseApi";

export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/global_categories/show?page=${page}`, {
            params: filterData
        });
    },
    save(payload) {
        return BaseApi.post("/masterfile/global_categories/create", payload);
    },
    update(payload) {
        return BaseApi.post("/masterfile/global_categories/update", payload);
    },
    status(payload) {
        return BaseApi.post("/masterfile/global_categories/change_status", payload);
    }
};
