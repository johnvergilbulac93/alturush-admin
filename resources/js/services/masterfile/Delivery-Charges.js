import BaseApi from "../BaseApi";

export default {
    createChargeGoods(payload) {
        return BaseApi.post("/masterfile/delivery_charge/goods/save", payload);
    },
    editChargeGoods(payload) {
        return BaseApi.post(
            "/masterfile/delivery_charge/goods/update",
            payload
        );
    },
    showChargeGoods(page, filterData) {
        return BaseApi.get(
            `/masterfile/delivery_charge/goods/show?page=${page}`,
            {
                params: filterData
            }
        );
    },
    statusChargeGoods(payload) {
        return BaseApi.post(
            "/masterfile/delivery_charge/goods/change_status",
            payload
        );
    },
    createChargeFoods(payload) {
        return BaseApi.post("/masterfile/delivery_charge/foods/save", payload);
    },
    editChargeFoods(payload) {
        return BaseApi.post(
            "/masterfile/delivery_charge/foods/update",
            payload
        );
    },
    showChargeFoods(page, filterData) {
        return BaseApi.get(
            `/masterfile/delivery_charge/foods/show?page=${page}`,
            {
                params: filterData
            }
        );
    },
    statusChargeFoods(payload) {
        return BaseApi.post(
            "/masterfile/delivery_charge/foods/change_status",
            payload
        );
    }
};
