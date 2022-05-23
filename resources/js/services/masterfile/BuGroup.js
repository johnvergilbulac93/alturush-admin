import BaseApi from "../BaseApi";

export default {
    bu_group() {
        return BaseApi.get("/masterfile/bu_group/bu_group");
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/bu_group/show?page=${page}`, {
            params: filterData
        });
    },
    saveGroup(payload) {
        return BaseApi.post("/masterfile/bu_group/create", payload);
    },
    editGroup(payload) {
        return BaseApi.post("/masterfile/bu_group/update", payload);
    },
    changeStatus(payload) {
        return BaseApi.post("/masterfile/bu_group/change_status", payload);
    }
};
