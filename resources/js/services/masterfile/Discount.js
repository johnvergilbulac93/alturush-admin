import BaseApi from "../BaseApi";
export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/discount/show?page=${page}`, {
            params: filterData
        });
    },
    save(payload) {
        return BaseApi.post(`/masterfile/discount/create`, payload);
    },
    update(payload) {
        return BaseApi.post(`/masterfile/discount/update`, payload);
    },
    changeStatus(payload) {
        return BaseApi.post("/masterfile/discount/change_status", payload);
    }
};
