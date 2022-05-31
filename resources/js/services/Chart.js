import BaseApi from "./BaseApi";

export default {
    show(filter) {
        return BaseApi.get("/chart/top_items", { params: filter });
    }
};
