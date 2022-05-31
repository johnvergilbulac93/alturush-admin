import Http from "./../../services/Chart";

export default {
    namespaced: true,
    state: {
        TopProductLabels: [],
        TopProductQty: [],
        TopProduct: []
    },
    mutations: {
        SET_LABELS(state, payload) {
            state.TopProductLabels = payload;
        },
        SET_QTY(state, payload) {
            state.TopProductQty = payload;
        },
        SET_PRODUCT(state, payload) {
            state.TopProduct = payload;
        }
    },
    actions: {
        async getTopProduct({ commit }, payload) {
            try {
                const { status, data } = await Http.show(payload);
                if (status === 200) {
                    commit("SET_PRODUCT", data);
                    let labels = [],
                        qty = [];
                    data.forEach(item => {
                        labels.push(`${item.product_name}(${item.UOM})`);
                        qty.push(Math.round(item.sales));
                    });
                    commit("SET_LABELS", labels);
                    commit("SET_QTY", qty);
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
