import Http from "../../services/Order";
import { Spin } from "view-design";

export default {
    namespaced: true,
    state: {
        TenantOrders: []
    },
    mutations: {
        SET_ORDERS(state, payload) {
            state.TenantOrders = payload;
        }
    },
    actions: {
        async getTenantOrders({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.show(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_ORDERS", data);
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
    }
};
