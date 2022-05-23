import Http from "../../services/masterfile/User";
import Vue from "vue";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        GoodUser: [],
        TenantUser: [],
        SystemUser: [],
        DefaultUsername: null
    },
    mutations: {
        SET_USER_TENANT(state, payload) {
            state.TenantUser = payload;
        },
        SET_DEFAULT_USERNAME(state, payload) {
            state.DefaultUsername = payload;
        },
        SET_SYSTEM_USER(state, payload) {
            state.SystemUser = payload;
        },
        SET_GOOD_USER(state, payload) {
            state.GoodUser = payload;
        }
    },
    actions: {
        async getGoodUser({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_GOOD_USER", data.data);
                    commit("PAGINATION", data, { root: true });
                }
            } catch (error) {
                Spin.hide();
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async saveGoodsUser({ commit }, payload) {
            try {
                const { status, data } = await Http.saveInfo(payload);
                if (status === 200) {
                    Fire.$emit("reload_good_user");
                    commit("MODAL_FLAG", false, {
                        root: true
                    });
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        commit("SET_ERRORS", data.errors, {
                            root: true
                        });
                        setTimeout(() => {
                            commit("CLEAR_ERRORS", "", {
                                root: true
                            });
                        }, 5000);
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async updateGoodsUser({ commit }, payload) {
            try {
                const { status, data } = await Http.updateInfo(payload);
                if (status === 200) {
                    Fire.$emit("reload_good_user");
                    commit("MODAL_FLAG", false, { root: true });
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        commit("SET_ERRORS", data.errors, {
                            root: true
                        });
                        setTimeout(() => {
                            commit("CLEAR_ERRORS", "", { root: true });
                        }, 5000);
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async changeGoodUserStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.userGoodStatus(payload);
                if (status === 200) {
                    Fire.$emit("reload_good_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        async goodsResetPass({ commit }, id) {
            try {
                const { status, data } = await Http.passResetGoodsUser(id);
                if (status == 200) {
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getTenantUser({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.showTenantUser(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_USER_TENANT", data.data);
                    commit("PAGINATION2", data, { root: true });
                }
            } catch (error) {
                Spin.hide();
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async updateTenantUser({ commit }, payload) {
            try {
                const { status, data } = await Http.editTenantUser(payload);
                if (status == 200) {
                    Fire.$emit("reload_tenant_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                    commit("MODAL_FLAG", false, { root: true });
                }
            } catch (error) {
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        commit("SET_ERRORS", data.errors, {
                            root: true
                        });
                        setTimeout(() => {
                            commit("CLEAR_ERRORS", "", {
                                root: true
                            });
                        }, 5000);
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async createTenantUser({ commit }, payload) {
            try {
                const { status, data } = await Http.saveTenantUser(payload);
                if (status == 200) {
                    Fire.$emit("reload_tenant_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                    commit("MODAL_FLAG", false, { root: true });
                }
            } catch (error) {
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        commit("SET_ERRORS", data.errors, {
                            root: true
                        });
                        setTimeout(() => {
                            commit("CLEAR_ERRORS", "", {
                                root: true
                            });
                        }, 5000);
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async tenantResetPass({ commit }, id) {
            try {
                const { status, data } = await Http.passResetTenantuser(id);
                if (status == 200) {
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async systemResetPass({ commit }, id) {
            try {
                const { status, data } = await Http.passResetSystemUser(id);
                if (status == 200) {
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        async changeTenantUserStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.userTenantStatus(payload);
                if (status == 200) {
                    Fire.$emit("reload_tenant_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getDefaultUsername({ commit }, payload) {
            try {
                const { status, data } = await Http.showDefaultUsername(
                    payload
                );
                if (status == 200) {
                    commit("SET_DEFAULT_USERNAME", data);
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getSystemUser({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.showSystemUser(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_SYSTEM_USER", data.data);
                    commit("PAGINATION", data, { root: true });
                }
            } catch (error) {
                Spin.hide();
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async createSystemUser({ commit }, payload) {
            try {
                const { status, data } = await Http.saveSystemUser(payload);
                if (status == 200) {
                    Fire.$emit("reload_system_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                    commit("MODAL_FLAG", false, { root: true });
                }
            } catch (error) {
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        commit("SET_ERRORS", data.errors, {
                            root: true
                        });
                        setTimeout(() => {
                            commit("CLEAR_ERRORS", "", {
                                root: true
                            });
                        }, 5000);
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async updateSystemUser({ commit }, payload) {
            try {
                const { status, data } = await Http.editSystemUser(payload);
                if (status == 200) {
                    Fire.$emit("reload_system_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                    commit("MODAL_FLAG", false, { root: true });
                }
            } catch (error) {
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        commit("SET_ERRORS", data.errors, {
                            root: true
                        });
                        setTimeout(() => {
                            commit("CLEAR_ERRORS", "", {
                                root: true
                            });
                        }, 5000);
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async updateSystemUserPhoto({ commit }, payload) {
            try {
                const { status, data } = await Http.changePhotoSystemUser(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_system_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                    commit("MODAL_FLAG2", false, { root: true });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async updateTenantUserPhoto({ commit }, payload) {
            try {
                const { status, data } = await Http.changePhotoTenantUser(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_tenant_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                    commit("MODAL_FLAG2", false, { root: true });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async changeSystemUserStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.userSystemStatus(payload);
                if (status == 200) {
                    Fire.$emit("reload_system_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async userRole({ commit }, payload) {
            try {
                const { status, data } = await Http.saveUserRole(payload);
                if (status == 200) {
                    Fire.$emit("reload_system_user");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        }
    }
};
