import Http from "../../services/masterfile/Delivery-Charges";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        ChargeGoods: [],
        ChargeFoods: []
    },
    mutations: {
        SET_CHARGE_GOODS(state, payload) {
            state.ChargeGoods = payload;
        },
        SET_CHARGE_FOODS(state, payload) {
            state.ChargeFoods = payload;
        }
    },
    actions: {
        async getChargeGoods({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.showChargeGoods(
                    currentPage,
                    filterData
                );
                if (status == 200) {
                    Spin.hide();
                    commit("SET_CHARGE_GOODS", data.data);
                    commit("PAGINATION", data, {
                        root: true
                    });
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
        async saveChargeGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.createChargeGoods(payload);
                if (status == 200) {
                    Fire.$emit("reload_charges_goods");
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
        async updateChargeGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.editChargeGoods(payload);
                if (status == 200) {
                    Fire.$emit("reload_charges_goods");
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
        async changeStatusChargeGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.statusChargeGoods(payload);
                if (status == 200) {
                    Fire.$emit("reload_charges_goods");
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
        async getChargeFoods({ commit }, { currentPage, filterData }) {
            try {
                const { status, data } = await Http.showChargeFoods(
                    currentPage,
                    filterData
                );
                if (status == 200) {
                    commit("SET_CHARGE_FOODS", data.data);
                    commit("PAGINATION2", data, {
                        root: true
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
        async saveChargeFoods({ commit }, payload) {
            try {
                const { status, data } = await Http.createChargeFoods(payload);
                if (status == 200) {
                    Fire.$emit("reload_charges_foods");
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
        async updateChargeFoods({ commit }, payload) {
            try {
                const { status, data } = await Http.editChargeFoods(payload);
                if (status == 200) {
                    Fire.$emit("reload_charges_foods");
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
        async changeStatusChargeGoods({ commit }, payload) {
            try {
                const { status, data } = await Http.statusChargeFoods(payload);
                if (status == 200) {
                    Fire.$emit("reload_charges_foods");
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
