import Http from "../../services/Item";
import Vue from "vue";
import { Notice, Spin, Message } from "view-design";

export default {
    namespaced: true,
    state: {
        Products: [],
        DisableProducts: [],
        EnableProducts: []
    },
    mutations: {
        SET_PRODUCT(state, payload) {
            state.Products = payload;
        },
        SET_DISABLED_PRODUCT(state, payload) {
            state.DisableProducts = payload;
        },
        SET_ENABLED_PRODUCT(state, payload) {
            state.EnableProducts = payload;
        }
    },
    actions: {
        async getItems({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_PRODUCT", data.data);
                    commit("PAGINATION", data, { root: true });
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
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
        async updateStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.status(payload);
                if (status == 200) {
                    Fire.$emit("reload_product");
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
        async updateStatusPerStore({ commit }, payload) {
            try {
                const { status, data } = await Http.status_per_store(payload);
                if (status == 200) {
                    Fire.$emit("reload_product");
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
        async updateImage({ commit }, payload) {
            try {
                const { status, data } = await Http.update_image(payload);
                if (status === 200) {
                    Fire.$emit("reload_product");
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
        async getDisabledProducts({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show_product_to_disable(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_DISABLED_PRODUCT", data.data);
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
        async disableProduct({ commit }, payload) {
            try {
                const { status, data } = await Http.disable_product_uom(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_disabled_product");
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
        async getEnabledProducts({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();

                const { status, data } = await Http.show_product_to_enable(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();

                    commit("SET_ENABLED_PRODUCT", data.data);
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
        async enableProduct({ commit }, payload) {
            try {
                const { status, data } = await Http.enable_product_uom(payload);
                if (status == 200) {
                    Fire.$emit("reload_enable_product");
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
