import BaseApi from "./BaseApi";

export default {
    show(page, filterData) {
        return BaseApi.get(`/rider/foods/show?page=${page}`, {
            params: filterData
        });
    },
    rider_liabilities(payload) {
        return BaseApi.post("/rider/foods/rider_liabilities", payload);
    },
    clear_liabilities(payload) {
        return BaseApi.post("/rider/foods/clear", payload);
    }
};
