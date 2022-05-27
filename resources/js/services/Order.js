import BaseApi from "./BaseApi";

export default {
    show(filter) {
        return BaseApi.get("/order/foods/tenant_orders", {params: filter } );
    }
};
