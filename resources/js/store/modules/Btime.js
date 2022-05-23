import Http from "../../services/masterfile/BuTime";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        BuTime: []
    },
    mutations: {
        SET_BU_TIME(state, payload) {
            state.BuTime = payload;
        }
    },
    actions: {
        async getBuTime({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_BU_TIME", data.data);
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
        async addBuTime({ commit }, payload) {
            try {
                const { status, data } = await Http.create(payload);
                if (status === 200) {
                    Fire.$emit("reload_bu_time");
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
        async updateBuTime({ commit }, payload) {
            try {
                const { status, data } = await Http.update(payload);
                if (status === 200) {
                    Fire.$emit("reload_bu_time");
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
        async updateStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.changeStatus(payload);
                if (status === 200) {
                    Fire.$emit("reload_bu_time");
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
        }
    }
};
