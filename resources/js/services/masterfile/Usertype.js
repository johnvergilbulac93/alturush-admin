import BaseApi from "../BaseApi";

export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/usertype/show?page=${page}`, {
            params: filterData
        });
    },
    createTenantUsertype(payload) {
        return BaseApi.post("/masterfile/usertype/tenant/create", payload);
    },
    updateTenantUsertype(payload) {
        return BaseApi.post("/masterfile/usertype/tenant/update", payload);
    },
    createSystemUsertype(payload) {
        return BaseApi.post("/masterfile/usertype/system/create", payload);
    },
    updateSystemUsertype(payload) {
        return BaseApi.post("/masterfile/usertype/system/update", payload);
    },
    changeStatus(payload) {
        return BaseApi.post("/masterfile/usertype/status", payload);
    }
};
