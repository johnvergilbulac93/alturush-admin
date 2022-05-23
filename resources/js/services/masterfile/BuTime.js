import BaseApi from "../BaseApi";
export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/bu_time/show?page=${page}`, {
            params: filterData
        });
    },
    create(payload) {
        return BaseApi.post(`/masterfile/bu_time/create`, payload);
    },
    update(payload) {
        return BaseApi.post(`/masterfile/bu_time/update`, payload);
    },
    changeStatus(payload) {
        return BaseApi.post("/masterfile/bu_time/change_status", payload);
    }
};
