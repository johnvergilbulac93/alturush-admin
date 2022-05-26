import BaseApi from "../BaseApi";
export default {
    save_min_order_goods(payload) {
        return BaseApi.post("/masterfile/min_order/goods/save", payload);
    },
    update_min_order_goods(payload) {
        return BaseApi.post("/masterfile/min_order/goods/update", payload);
    },
    show_min_order_goods(page, filterData) {
        return BaseApi.get(`/masterfile/min_order/goods/show?page=${page}`, {
            params: filterData
        });
    },
    status_min_order_goods(payload) {
        return BaseApi.post(`/masterfile/min_order/goods/change_status`, payload);
    },
    show_min_order_foods(page, filterData) {
        return BaseApi.get(`/masterfile/min_order/foods/show?page=${page}`, {
            params: filterData
        });
    },
    save_min_order_foods(payload) {
        return BaseApi.post("/masterfile/min_order/foods/save", payload);
    },
    update_min_order_foods(payload) {
        return BaseApi.post("/masterfile/min_order/foods/update", payload);
    },
    status_min_order_foods(payload) {
        return BaseApi.post(`/masterfile/min_order/foods/change_status`, payload);
    },
};
