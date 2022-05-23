import BaseApi from "../BaseApi";

export default {
    saveInfo(payload) {
        return BaseApi.post("/user/good/create", payload);
    },
    updateInfo(payload) {
        return BaseApi.post("/user/good/update", payload);
    },
    show(page, filterData) {
        return BaseApi.get(`/user/good/show?page=${page}`, {
            params: filterData
        });
    },
    userGoodStatus(payload) {
        return BaseApi.post("/user/good/status", payload);
    },
    passResetGoodsUser(id) {
        console.log(id);
        return BaseApi.post("/user/good/reset_password", id);
    },
    changePassword(payload) {
        return BaseApi.post("/user/good/change_password", payload);
    },
    changeUsername(payload) {
        return BaseApi.post("/user/good/change_username", payload);
    },
    profilePhoto(payload, axiosSource) {
        return BaseApi.post("/user/good/profile_image", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
            cancelToken: axiosSource.token
        });
    },
    showTenantUser(page, filterData) {
        return BaseApi.get(`/user/food/tenant/show?page=${page}`, {
            params: filterData
        });
    },
    showUsertypeTenant() {
        return BaseApi.get("/user/food/tenant/tenant_usertype");
    },
    editTenantUser(payload) {
        return BaseApi.post("/user/food/tenant/update_user", payload);
    },
    saveTenantUser(payload) {
        return BaseApi.post("/user/food/tenant/create_user", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    passResetTenantuser(id) {
        return BaseApi.post("/user/food/tenant/reset_password", id);
    },
    passResetSystemUser(id) {
        return BaseApi.post("/user/food/system/reset_password", id);
    },
    userTenantStatus(payload) {
        return BaseApi.post("/user/food/tenant/status", payload);
    },
    userSystemStatus(payload) {
        return BaseApi.post("/user/food/system/status", payload);
    },
    changePhotoTenantUser(payload) {
        return BaseApi.post("/user/food/tenant/user_photo", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    showSystemUser(page, filterData) {
        return BaseApi.get(`/user/food/system/show?page=${page}`, {
            params: filterData
        });
    },
    showDefaultUsername(payload) {
        return BaseApi.get("/user/food/default", { params: payload });
    },
    saveSystemUser(payload) {
        return BaseApi.post("/user/food/system/create_user", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    editSystemUser(payload) {
        return BaseApi.post("/user/food/system/update_user", payload);
    },
    changePhotoSystemUser(payload) {
        return BaseApi.post("/user/food/system/user_photo", payload, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    saveUserRole(payload) {
        return BaseApi.post("/user/food/system/save_user_role", payload);
    }
};
