import Http from "../../services/Rider";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        Riders: [],
        Liabilities: []
    },
    mutations: {
        SET_RIDERS(state, payload) {
            state.Riders = payload;
        },
        SET_LIABILITIES(state, payload) {
            state.Liabilities = payload;
        }
    },
    actions: {
        async getRiderLists({ commit }, { currentPage, filterData }) {
            try {
                const { status, data } = await Http.show(
                    currentPage,
                    filterData
                );
                if (status === 200) {
                    commit("SET_RIDERS", data.data);
                    commit("PAGINATION", data, { root: true });
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
        async getLiabilities({ commit }, payload) {
            try {
                const { status, data } = await Http.rider_liabilities(payload);
                if (status === 200) {
                    commit("SET_LIABILITIES", data);
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
        async clearLiabilities({ commit }, payload) {
            try {
                const { status, data } = await Http.clear_liabilities(payload);
                if (status === 200) {
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
