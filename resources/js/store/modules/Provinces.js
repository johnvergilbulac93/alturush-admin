import Http from "../../services/masterfile/Province";
import { Spin } from "view-design";
export default {
    namespaced: true,
    state: {
        Provinces: []
    },
    mutations: {
        SET_PROVINCES(state, payload) {
            state.Provinces = payload;
        }
    },
    actions: {
        async getProvince({ commit }, { currentPage, filterData }) {
            try {
                Spin.show();
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_PROVINCES", data.data);
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
        async saveProvince({ commit }, payload) {
            try {
                const { status, data } = await Http.save(payload);
                if (status === 200) {
                    Fire.$emit("reload_province");
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
        async updateProvince({ commit }, payload) {
            try {
                const { status, data } = await Http.update(payload);
                if (status === 200) {
                    Fire.$emit("reload_province");
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
                const { status, data } = await Http.status(payload);
                if (status == 200) {
                    Fire.$emit("reload_province");
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
