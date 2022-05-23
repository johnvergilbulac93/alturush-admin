import BaseApi from "../BaseApi";
export default {
    show_tenant_goods(page, filterData) {
        return BaseApi.get(`/masterfile/tenant/goods/show?page=${page}`, {
            params: filterData
        });
    },
    save_tenant_goods(payload) {
        return BaseApi.post(`/masterfile/tenant/goods/save`, payload);
    },
    update_tenant_goods(payload) {
        return BaseApi.post(`/masterfile/tenant/goods/update`, payload);
    },
    change_status_tenant_goods(payload) {
        return BaseApi.post("/masterfile/tenant/goods/change_status", payload);
    },
    show_tenant_foods(page, filterData) {
        return BaseApi.get(`/masterfile/tenant/foods/show?page=${page}`, {
            params: filterData
        });
    },
    save_tenant_foods(payload) {
        return BaseApi.post(`/masterfile/tenant/foods/save`, payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    update_tenant_foods(payload) {
        return BaseApi.post(`/masterfile/tenant/foods/update`, payload);
    },
    change_status_tenant_foods(payload) {
        return BaseApi.post("/masterfile/tenant/foods/change_status", payload);
    },
    show_contacts_tenant_foods(payload) {
        return BaseApi.post("/masterfile/tenant/foods/contacts", payload);
    },
    save_contact_tenant_foods(payload) {
        return BaseApi.post("/masterfile/tenant/foods/save_contact", payload);
    },
    remove_contact(payload) {
        return BaseApi.post("/masterfile/tenant/foods/remove_contact", payload);
    },
    change_image_tenant_foods(payload) {
        return BaseApi.post("/masterfile/tenant/foods/change_image", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    }
};
