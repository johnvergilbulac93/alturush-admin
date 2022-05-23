import BaseApi from "../BaseApi";
export default {
    show(page, filterData) {
        return BaseApi.get(`/masterfile/bunit/show?page=${page}`, {
            params: filterData
        });
    },
    createBusinessUnit(payload) {
        return BaseApi.post("/masterfile/bunit/create", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    updateBusinessUnit(payload) {
        return BaseApi.post("/masterfile/bunit/update", payload);
    },
    changeStatus(payload) {
        return BaseApi.post("/masterfile/bunit/status", payload);
    },
    checkAvailability(payload) {
        return BaseApi.post("/masterfile/bunit/set_global_category", payload);
    },
    changePhoto(payload) {
        return BaseApi.post("/masterfile/bunit/change_photo", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    }
};
