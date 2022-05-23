import Http from "../../services/masterfile/BRule";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        BRule: []
    },
    mutations: {
        SET_B_RULE(state, payload) {
            state.BRule = payload;
        }
    },
    actions: {
        async getRule({ commit }) {
            try {
                Spin.show();
                const { status, data } = await Http.show();
                if (status === 200) {
                    Spin.hide();
                    commit("SET_B_RULE", data);
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
        async updateRule({ commit }, payload) {
            try {
                const { status, data } = await Http.update(payload);
                if (status === 200) {
                    Fire.$emit("reload_rule");
                    commit("MODAL_FLAG", false, {
                        root: true
                    });
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
