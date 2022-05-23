import Vue from "vue";
import Http from "../../services/masterfile/GlobalDisc";
import { Spin } from "view-design";
export default {
    namespaced: true,
    state: {
        GlobalDisc: []
    },
    mutations: {
        SET_GLOBAL_DISCOUNT(state, payload) {
            state.GlobalDisc = payload;
        }
    },
    actions: {
        async getGlobalDisc({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status == 200) {
                    Spin.hide();
                    commit("SET_GLOBAL_DISCOUNT", data.data);
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
        async saveGlobalDisc({ commit }, payload) {
            try {
                const { status, data } = await Http.save(payload);
                if (status == 200) {
                    Fire.$emit("reload_global_disc");
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
        async updateGlobalDisc({ commit }, payload) {
            try {
                const { status, data } = await Http.update(payload);
                if (status == 200) {
                    Fire.$emit("reload_global_disc");
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
        async updateStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.changeStatus(payload);
                if (status == 200) {
                    Fire.$emit("reload_global_disc");
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
