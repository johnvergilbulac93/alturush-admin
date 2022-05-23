import { Spin } from "view-design";
import Http from "../../services/masterfile/Tenant";

export default {
    namespaced: true,
    state: {
        TenantGoods: [],
        TenantFoods: [],
        Contacts: []
    },
    mutations: {
        SET_TENANT_GOODS(state, payload) {
            state.TenantGoods = payload;
        },
        SET_TENANT_FOODS(state, payload) {
            state.TenantFoods = payload;
        },
        SET_CONTACTS(state, payload) {
            state.Contacts = payload;
        }
    },
    actions: {
        async getTenantGoods({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show_tenant_goods(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_TENANT_GOODS", data.data);
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
        async saveGoodsTenant({ commit }, payload) {
            try {
                const { status, data } = await Http.save_tenant_goods(payload);
                if (status == 200) {
                    Fire.$emit("reload_goods_tenant");
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
                    case 409:
                        Vue.$toast.open({
                            message: `${data.errors.message[0]}`,
                            type: "error"
                        });
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
        async updateGoodsTenant({ commit }, payload) {
            try {
                const { status, data } = await Http.update_tenant_goods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_goods_tenant");
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
        async changeStatusTenantGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.change_status_tenant_goods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_goods_tenant");
                    Vue.$toast.open({
                        message: `${data.msg}`,
                        type: `${data.status}`
                    });
                }
            } catch (error) {
                console.error(error);
            }
        },
        async getTenantFoods({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show_tenant_foods(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_TENANT_FOODS", data.data);
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
        async getContacts({ commit }, payload) {
            try {
                const { status, data } = await Http.show_contacts_tenant_foods(
                    payload
                );
                if (status == 200) {
                    commit("SET_CONTACTS", data);
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
        async saveContact({ commit }, payload) {
            try {
                const { status, data } = await Http.save_contact_tenant_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_foods_contacts");
                    Fire.$emit("reload_foods_tenant");
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
        async deleteContact({ commit }, payload) {
            try {
                const { status, data } = await Http.remove_contact(payload);
                if (status == 200) {
                    Fire.$emit("reload_foods_contacts");
                    Fire.$emit("reload_foods_tenant");
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
        async changeStatusTenantFoods({ commit }, payload) {
            try {
                const { status, data } = await Http.change_status_tenant_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_foods_tenant");
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
        async saveFoodsTenant({ commit }, payload) {
            try {
                const { status, data } = await Http.save_tenant_foods(payload);
                if (status == 200) {
                    Fire.$emit("reload_foods_tenant");
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
                    case 409:
                        Vue.$toast.open({
                            message: `${data.errors.message[0]}`,
                            type: "error"
                        });
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
        async updateFoodsTenant({ commit }, payload) {
            try {
                const { status, data } = await Http.update_tenant_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_foods_tenant");
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
        async updateImageFoodsTenant({ commit }, payload) {
            try {
                const { status, data } = await Http.change_image_tenant_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_foods_tenant");
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
