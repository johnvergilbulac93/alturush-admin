import BaseApi from "../BaseApi";
export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/global_discount/show?page=${page}`, {
            params: filterData
        });
    },
    save(payload) {
        return BaseApi.post(`/masterfile/global_discount/create`, payload);
    },
    update(payload) {
        return BaseApi.post(`/masterfile/global_discount/update`, payload);
    },
    changeStatus(payload) {
        return BaseApi.post(
            "/masterfile/global_discount/change_status",
            payload
        );
    }
};
