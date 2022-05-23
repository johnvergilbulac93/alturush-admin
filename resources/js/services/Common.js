import BaseApi from "./BaseApi";

export default {
    ViewStore() {
        return BaseApi.get("/masterfile/store");
    },
    ViewDepartment() {
        return BaseApi.get("/masterfile/department");
    },
    ViewProvince() {
        return BaseApi.get("/masterfile/province");
    },
    ViewBarangay() {
        return BaseApi.get("/masterfile/barangay");
    },
    ViewTown() {
        return BaseApi.get("/masterfile/town");
    },
    ViewTransportation() {
        return BaseApi.get("/masterfile/transportation");
    },
    ViewUserType() {
        return BaseApi.get("/user/usertype");
    },
    ViewFoodUsertype(payload) {
        return BaseApi.get("/user/food/usertype", { params: payload });
    },
    ViewEmployee(employee) {
        return BaseApi.get(`/user/employees`, {
            params: { employee: employee }
        });
    },
    ViewPriceGroup() {
        return BaseApi.get("/masterfile/price_group");
    },
    viewGlobalCategory() {
        return BaseApi.get("/masterfile/global_category");
    },
    viewBuGroup() {
        return BaseApi.get("/masterfile/bu_group/bu_group");
    },
    ViewSelectedTenant(id) {
        return BaseApi.get(`/masterfile/selected_tenant`, {
            params: { id: id }
        });
    },
    ViewUserRole(payload) {
        return BaseApi.get(`/user/userrole`, {
            params: payload
        });
    },
    viewDiscount() {
        return BaseApi.get("/masterfile/discount");
    },
    viewRangeLevel() {
        return BaseApi.get("/masterfile/range_level");
    },
    ViewItemCategory() {
        return BaseApi.get("/product/category");
    }
};
