import BaseApi from "./BaseApi";

export default {
    liquidation_report(filter) {
        return BaseApi.get("/report/liquidation", {
            params: filter
        });
    },
    accountability_report(filter) {
        return BaseApi.get("/report/accountability", {
            params: filter
        });
    },
    transactions_report(filter) {
        return BaseApi.get("/report/transactions", {
            params: filter
        });
    },
    store_item_report(filter) {
        return BaseApi.get("/report/store/item_report", {
            params: filter
        });
    },
    store_liquidation_report(filter) {
        return BaseApi.get("/report/store/liquidation", {
            params: filter
        });
    },
    store_cashier_accountability_report(filter) {
        return BaseApi.get("/report/store/accountability", {
            params: filter
        });
    },
    store_instruction(filter) {
        return BaseApi.get("/report/instruction", { params: filter });
    },
    store_unfound(filter) {
        return BaseApi.get("/report/unfound", { params: filter });
    },
    tenant_order_details(filter) {
        return BaseApi.get("/report/foods/getTenantOrders", { params: filter });
    },
    town_most_order(filter) {
        return BaseApi.get("/report/foods/getTownMostOrders", {
            params: filter
        });
    },
    tenant_most_order(filter) {
        return BaseApi.get("/report/foods/getTenantMostOrders", {
            params: filter
        });
    },
    source_most_order(filter) {
        return BaseApi.get("/report/foods/getSourceMostOrder", {
            params: filter
        });
    },
    rider_transaction(filter) {
        return BaseApi.get("/report/foods/getRiderTransaction", {
            params: filter
        });
    },
    rider_daily_earning(filter) {
        return BaseApi.get("/report/foods/getRidersDailyEarning", {
            params: filter
        });
    },
    rider_count_per_day(filter) {
        return BaseApi.get("/report/foods/getRiderCountPerDay", {
            params: filter
        });
    },
    order_data_report(filter) {
        return BaseApi.get("/report/foods/getOrderDataReport", {
            params: filter
        });
    },
    most_cancelled_item() {
        return BaseApi.get("/report/foods/getMostCancelledItem");
    },
    hourly_call_monitoring(filter) {
        return BaseApi.get("/report/foods/getHourlyCallMonitoring", {
            params: filter
        });
    },
    commission(filter) {
        return BaseApi.get("/report/foods/getCommission", { params: filter });
    }
};
