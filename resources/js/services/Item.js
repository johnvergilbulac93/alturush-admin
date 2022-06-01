import BaseApi from "./BaseApi";

export default {
    show(page, filterData) {
        return BaseApi.get(`/product/show?page=${page}`, {
            params: filterData
        });
    },
    update_image(payload) {
        return BaseApi.post("/product/image", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    Price_changed_count() {
        return BaseApi.get("/product/change_price/count");
    },
    Price_changed_info(page, filterData) {
        return BaseApi.get(`/product/change_price/show?page=${page}`, {
            params: filterData
        });
    },
    item_not_available(page, filterData) {
        return BaseApi.get(
            `/product/per_store/item_not_available/show?page=${page}`,
            {
                params: filterData
            }
        );
    },
    status(payload) {
        return BaseApi.post("/product/change_status", payload);
    },
    status_per_store(payload) {
        return BaseApi.post("/product/per_store/change_status", payload);
    },

    show_product_to_disable(page, filterData) {
        return BaseApi.get(`/product/disable_uom/show?page=${page}`, {
            params: filterData
        });
    },
    show_product_to_enable(page, filterData) {
        return BaseApi.get(`/product/enable_uom/show?page=${page}`, {
            params: filterData
        });
    },
    disable_product_uom(itemcode) {
        return BaseApi.post("/product/disable_uom", itemcode);
    },
    enable_product_uom(itemcode) {
        return BaseApi.post("/product/enable_uom", itemcode);
    },
    store_item_masterfile(page, filterData) {
        return BaseApi.get(`/product/per_store/show?page=${page}`, {
            params: filterData
        });
    },
    store_item_disable_all(itemcode) {
        return BaseApi.post("/product/per_store/item_disabled", itemcode);
    },
    store_item_enable_all(itemcode) {
        return BaseApi.post("/product/per_store/item_enabled", itemcode);
    },
    export_product(payload) {
        return BaseApi.get("/export/product", {
            params: payload
        });
    }
};
