import BaseApi from "../BaseApi";
export default {
    show() {
        return BaseApi.get("/masterfile/location_group/show");
    },
    default_data() {
        return BaseApi.get("/masterfile/location_group/default_data");
    },
    update(payload) {
        return BaseApi.post(`/masterfile/location_group/update`, payload);
    }
};
