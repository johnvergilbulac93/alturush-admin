import Vue from "vue";
import Http from "../../services/masterfile/MinOrder";
import { Spin } from "view-design";
export default {
    namespaced: true,
    state: {
        MinOrderGoods: [],
        MinOrderFoods: []
    },
    mutations: {
        SET_MIN_ORDER_FOODS(state, payload) {
            state.MinOrderFoods = payload;
        },
        SET_MIN_ORDER_GOODS(state, payload) {
            state.MinOrderGoods = payload;
        }
    },
    actions: {
        async getMinOrderGoods({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show_min_order_goods(
                    currentPage,
                    filterData
                );
                if (status == 200) {
                    Spin.hide();
                    commit("SET_MIN_ORDER_GOODS", data.data);
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
        async saveMinOrderGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.save_min_order_goods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_min_order_goods");
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
        async updateMinOrderGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.update_min_order_goods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_min_order_goods");
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
        async updateStatusMinOrderGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.status_min_order_goods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_min_order_goods");
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
        async getMinOrderFoods({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show_min_order_foods(
                    currentPage,
                    filterData
                );
                if (status == 200) {
                    Spin.hide();
                    commit("SET_MIN_ORDER_FOODS", data.data);
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
        async saveMinOrderFoods({ commit }, payload) {
            try {
                const { status, data } = await Http.save_min_order_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_min_order_foods");
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
        async updateMinOrderFoods({ commit }, payload) {
            try {
                const { status, data } = await Http.update_min_order_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_min_order_foods");
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
        async updateStatusMinOrderFoods({ commit }, payload) {
            try {
                const { status, data } = await Http.status_min_order_foods(
                    payload
                );
                if (status == 200) {
                    Fire.$emit("reload_min_order_foods");
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
