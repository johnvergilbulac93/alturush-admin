import Http from "../../services/masterfile/Usertype";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        systemUsertype: [],
        tenantUsertype: []
    },
    mutations: {
        SET_USERTYPE_SYSTEM(state, payload) {
            state.systemUsertype = payload;
        },
        SET_USERTYPE_TENANT(state, payload) {
            state.tenantUsertype = payload;
        }
    },
    actions: {
        async getUserType({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    if (filterData.type === "Tenant") {
                        commit("SET_USERTYPE_TENANT", data.data);
                        commit("PAGINATION", data, { root: true });
                    } else {
                        commit("SET_USERTYPE_SYSTEM", data.data);
                        commit("PAGINATION2", data, { root: true });
                    }
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
        async addTenantUsertype({ commit }, payload) {
            try {
                const { status, data } = await Http.createTenantUsertype(
                    payload
                );
                if (status === 200) {
                    Fire.$emit("reload_tenant_usertype");
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
        async updateTenantUsertype({ commit }, payload) {
            try {
                const { status, data } = await Http.updateTenantUsertype(
                    payload
                );
                if (status === 200) {
                    Fire.$emit("reload_tenant_usertype");
                    commit("MODAL_FLAG", false, { root: true });
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                const { status, data } = error.response;
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
        async addSystemUsertype({ commit }, payload) {
            try {
                const { status, data } = await Http.createSystemUsertype(
                    payload
                );
                if (status === 200) {
                    Fire.$emit("reload_system_usertype");
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
        async updateSystemUsertype({ commit }, payload) {
            try {
                const { status, data } = await Http.updateSystemUsertype(
                    payload
                );
                if (status === 200) {
                    Fire.$emit("reload_system_usertype");
                    commit("MODAL_FLAG", false, { root: true });
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
        async updateStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.changeStatus(payload);
                if (status === 200) {
                    if (payload.type === "Tenant") {
                        Fire.$emit("reload_tenant_usertype");
                    } else {
                        Fire.$emit("reload_system_usertype");
                    }
                    commit("MODAL_FLAG", false, { root: true });
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
