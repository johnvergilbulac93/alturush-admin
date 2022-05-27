import Http from "../../services/masterfile/Location-Group";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        LocationGroup: [],
        DefaultData: []
    },
    mutations: {
        SET_LOCATION_GROUP(state, payload) {
            state.LocationGroup = payload;
        },
        SET_DEFAULT_DATA(state, payload) {
            state.DefaultData = payload;
        }
    },
    actions: {
        async getLocationGroup({ commit }) {
            try {
                Spin.show();
                const { status, data } = await Http.show();
                if (status === 200) {
                    Spin.hide();
                    commit("SET_LOCATION_GROUP", data);
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
        async getDefaultData({ commit }) {
            try {
                const { status, data } = await Http.default_data();
                if (status === 200) {
                    commit("SET_DEFAULT_DATA", data);
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
        async updateData({ commit }, payload) {
            try {
                const { status, data } = await Http.update(payload);
                if (status === 200) {
                    Fire.$emit("reload_location_group");
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
        }
    }
};
