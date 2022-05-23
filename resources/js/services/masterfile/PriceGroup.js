import BaseApi from "../BaseApi";

export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/price_group/show?page=${page}`, {
            params: filterData
        });
    },
    update(payload) {
        return BaseApi.post("/masterfile/price_group/update", payload);
    }
};
