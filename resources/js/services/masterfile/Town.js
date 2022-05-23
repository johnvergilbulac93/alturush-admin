import BaseApi from "../BaseApi";
export default {
    update(payload) {
        return BaseApi.post("/masterfile/town/update", payload);
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/town/show?page=${page}`, {
            params: filterData
        });
    },
    status(payload) {
        return BaseApi.post("/masterfile/town/status", payload);
    },
    save(payload) {
        return BaseApi.post("/masterfile/town/save", payload);
    }
};
