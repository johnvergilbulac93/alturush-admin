import Http from "../../services/masterfile/BuGroup";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        BuGroup: []
    },
    mutations: {
        SET_BU_GROUP(state, payload) {
            state.BuGroup = payload;
        }
    },
    actions: {
        async getBuGroup({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_BU_GROUP", data.data);
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
        async createGroup({ commit }, payload) {
            try {
                const { status, data } = await Http.saveGroup(payload);
                if (status == 200) {
                    Fire.$emit("reload_group");
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
        async updateGroup({ commit }, payload) {
            try {
                const { status, data } = await Http.editGroup(payload);
                if (status == 200) {
                    Fire.$emit("reload_group");
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
        async updateStatus({ commit }, payload) {
            try {
                const { status, data } = await Http.changeStatus(payload);
                if (status == 200) {
                    Fire.$emit("reload_group");
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
