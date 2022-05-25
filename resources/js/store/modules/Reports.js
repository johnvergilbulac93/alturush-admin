import Http from "../../services/Report";
import { Notice, Spin, Message } from "view-design";
export default {
    namespaced: true,
    state: {
        Liquidation: [],
        Accountability: [],
        Transactions: [],
        Unfounds: [],
        Instructions: [],
        TenantOrderDetails: [],
        TownMostOrder: [],
        TenantMostOrder: [],
        SourceMostOrder: [],
        RiderTransaction: [],
        RiderDailyEarning: [],
        RiderCountPerDay: [],
        OrderDataReport: [],
        HourlyCallMonitoring: [],
        Commission: []
    },
    mutations: {
        SET_LIQUIDATION(state, payload) {
            state.Liquidation = payload;
        },
        SET_ACCOUNTABILITY(state, payload) {
            state.Accountability = payload;
        },
        SET_TRANSACTION(state, payload) {
            state.Transactions = payload;
        },
        SET_UNFOUNDS(state, payload) {
            state.Unfounds = payload;
        },
        SET_INSTRUCTIONS(state, payload) {
            state.Instructions = payload;
        },
        CLEAR_LIQUIDATION(state) {
            state.Liquidation = [];
        },
        CLEAR_ACCOUNTABILITY(state) {
            state.Accountability = [];
        },
        CLEAR_TRANSACTIONS(state) {
            state.Transactions = [];
        },
        SET_TENANT_ORDER_DETAILS(state, payload) {
            state.TenantOrderDetails = payload;
        },
        SET_TOWN_MOST_ORDER(state, payload) {
            state.TownMostOrder = payload;
        },
        SET_TENANT_MOST_ORDER(state, payload) {
            state.TenantMostOrder = payload;
        },
        SET_SOURCE_MOST_ORDER(state, payload) {
            state.SourceMostOrder = payload;
        },
        SET_RIDER_TRANSACTION(state, payload) {
            state.RiderTransaction = payload;
        },
        SET_RIDER_DAILY_EARNING(state, payload) {
            state.RiderDailyEarning = payload;
        },
        SET_RIDER_COUNT_PER_DAY(state, payload) {
            state.RiderCountPerDay = payload;
        },
        SET_ORDER_DATA_REPORT(state, payload) {
            state.OrderDataReport = payload;
        },
        SET_HOURLY_MONITORING(state, payload) {
            state.HourlyCallMonitoring = payload;
        },
        SET_COMMISSION(state, payload) {
            state.Commission = payload;
        }
    },
    actions: {
        async getLiquidation({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.liquidation_report(payload);
                if (status === 200) {
                    commit("SET_LIQUIDATION", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();

                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getAccountability({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.accountability_report(
                    payload
                );
                if (status === 200) {
                    commit("SET_ACCOUNTABILITY", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getTransactions({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.transactions_report(
                    payload
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_TRANSACTION", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getUnfound({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.store_unfound(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_UNFOUNDS", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getInstruction({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.store_instruction(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_INSTRUCTIONS", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getTenantOrderDetails({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.tenant_order_details(
                    payload
                );
                if (status === 200) {
                    Spin.hide();
                    commit("SET_TENANT_ORDER_DETAILS", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getTownMostOrder({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.town_most_order(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_TOWN_MOST_ORDER", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getTenantMostOrder({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.tenant_most_order(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_TENANT_MOST_ORDER", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getSourceMostOrder({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.source_most_order(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_SOURCE_MOST_ORDER", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getRiderTransaction({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.rider_transaction(payload);
                if (status === 200) {
                    Spin.hide();
                    commit("SET_RIDER_TRANSACTION", data);
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getRiderDailyEarning({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.rider_daily_earning(
                    payload
                );
                if (status === 200) {
                    commit("SET_RIDER_DAILY_EARNING", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();

                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getRiderCountPerDay({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.rider_count_per_day(
                    payload
                );
                if (status === 200) {
                    commit("SET_RIDER_COUNT_PER_DAY", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getOrderDataReport({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.order_data_report(payload);
                if (status === 200) {
                    commit("SET_ORDER_DATA_REPORT", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getHourlyCallMonitoring({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.hourly_call_monitoring(
                    payload
                );
                if (status === 200) {
                    commit("SET_HOURLY_MONITORING", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        async getCommission({ commit }, payload) {
            try {
                Spin.show();
                const { status, data } = await Http.commission(payload);
                if (status === 200) {
                    commit("SET_COMMISSION", data);
                    Spin.hide();
                }
            } catch (error) {
                Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Message.error({
                            background: true,
                            content: "Internal Server Error."
                        });
                        break;
                    default:
                        break;
                }
            }
        }
    },
    getters: {
        totalRiderTransaction(state) {
            let total_trans = 0,
                riders_fee = 0,
                fuel_amt = 0,
                total_amt = 0;

            if (state.RiderTransaction) {
                state.RiderTransaction.forEach(d => {
                    total_trans += d.trans_num;
                });

                state.RiderTransaction.forEach(d => {
                    riders_fee += parseFloat(d.riders_fee);
                });

                state.RiderTransaction.forEach(d => {
                    fuel_amt += parseFloat(d.fuel);
                });

                state.RiderTransaction.forEach(d => {
                    total_amt += parseFloat(d.riders_fee + d.fuel);
                });

                return { total_trans, riders_fee, fuel_amt, total_amt };
            }
        },
        totalOrderAmount(state) {
            let pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0,
                grandTotal = 0;

            if (state.Liquidation.cashier_details) {
                state.Liquidation.cashier_details.forEach(order => {
                    pickupCharge += parseFloat(
                        order.customer_bill[0].picking_charge
                    );
                    if (
                        order.hasOwnProperty("final_orders") &&
                        order.final_orders
                    ) {
                        order.final_orders
                            .filter(order => order.canceled_status === 0)
                            .forEach(order => {
                                orderAmount += parseFloat(order.total_price);
                            });
                    }
                    if (
                        order.hasOwnProperty("discount_amount") &&
                        order.discount_amount
                    ) {
                        order.discount_amount.forEach(order => {
                            discount += parseFloat(order.discount);
                        });
                    }
                });

                lessDiscount = orderAmount - discount;
                grandTotal = orderAmount - discount + pickupCharge;
                return {
                    grandTotal,
                    orderAmount,
                    discount,
                    pickupCharge,
                    lessDiscount
                };
            }
        },
        totalPickupCharge(state) {
            let total = 0;
            if (state.Transactions.data) {
                state.Transactions.data.forEach(transaction => {
                    total += parseFloat(
                        transaction.customer_bill[0].picking_charge
                    );
                });
                return total;
            }
        },
        grandTotal(state) {
            let grandTotal = 0,
                pickupCharge = 0,
                amount = 0,
                discount = 0,
                lessDiscount = 0;
            if (state.Transactions.data) {
                state.Transactions.data.forEach(transaction => {
                    if (
                        transaction.hasOwnProperty("final_orders") &&
                        transaction.final_orders
                    ) {
                        transaction.final_orders
                            .filter(order => order.canceled_status === 0)
                            .forEach(order => {
                                amount += parseFloat(order.total_price);
                            });
                    }
                    if (
                        transaction.hasOwnProperty("discount_amount") &&
                        transaction.discount_amount
                    ) {
                        transaction.discount_amount.forEach(order => {
                            discount += parseFloat(order.discount);
                        });
                    }
                });
                lessDiscount = amount - discount;
                grandTotal = amount - discount + pickupCharge;
                return grandTotal;
            }
        },
        lessDiscount(state) {
            let grandTotal = 0,
                pickupCharge = 0,
                amount = 0,
                discount = 0,
                lessDiscount = 0;
            if (state.Transactions.data) {
                state.Transactions.data.forEach(transaction => {
                    pickupCharge += parseFloat(
                        transaction.customer_bill[0].picking_charge
                    );
                    if (
                        transaction.hasOwnProperty("final_orders") &&
                        transaction.final_orders
                    ) {
                        transaction.final_orders
                            .filter(order => order.canceled_status === 0)
                            .forEach(order => {
                                amount += parseFloat(order.total_price);
                            });
                    }
                    if (
                        transaction.hasOwnProperty("discount_amount") &&
                        transaction.discount_amount
                    ) {
                        transaction.discount_amount.forEach(order => {
                            discount += parseFloat(order.discount);
                        });
                    }
                });
                lessDiscount = amount - discount;
                grandTotal = amount - discount + pickupCharge;
                return lessDiscount;
            }
        },
        orderAmount(state) {
            let grandTotal = 0,
                pickupCharge = 0,
                amount = 0,
                discount = 0,
                lessDiscount = 0;
            if (state.Transactions.data) {
                state.Transactions.data.forEach(transaction => {
                    pickupCharge += parseFloat(
                        transaction.customer_bill[0].picking_charge
                    );
                    if (
                        transaction.hasOwnProperty("final_orders") &&
                        transaction.final_orders
                    ) {
                        transaction.final_orders
                            .filter(order => order.canceled_status === 0)
                            .forEach(order => {
                                amount += parseFloat(order.total_price);
                            });
                    }
                    if (
                        transaction.hasOwnProperty("discount_amount") &&
                        transaction.discount_amount
                    ) {
                        transaction.discount_amount.forEach(order => {
                            discount += parseFloat(order.discount);
                        });
                    }
                });
                lessDiscount = amount - discount;
                grandTotal = amount - discount + pickupCharge;
                return amount;
            }
        },
        orderSummary(state) {
            let grandTotal = 0,
                pickupCharge = 0,
                amount = 0,
                discount = 0,
                lessDiscount = 0;
            if (state.Transactions.data) {
                state.Transactions.data.forEach(transaction => {
                    pickupCharge += parseFloat(
                        transaction.customer_bill[0].picking_charge
                    );
                    if (
                        transaction.hasOwnProperty("final_orders") &&
                        transaction.final_orders
                    ) {
                        transaction.final_orders
                            .filter(order => order.canceled_status === 0)
                            .forEach(order => {
                                amount += parseFloat(order.total_price);
                            });
                    }
                    if (
                        transaction.hasOwnProperty("discount_amount") &&
                        transaction.discount_amount
                    ) {
                        transaction.discount_amount.forEach(order => {
                            discount += parseFloat(order.discount);
                        });
                    }
                });
                lessDiscount = amount - discount;
                grandTotal = amount - discount + pickupCharge;
                return {
                    grandTotal,
                    amount,
                    discount,
                    pickupCharge,
                    lessDiscount
                };
            }
        },
        transactionByStore(state) {
            if (state.Transactions.data) {
                return _.groupBy(state.Transactions.data, "acroname");
            }
        },
        transactionByMonth(state) {
            if (state.Transactions.data) {
                return _.groupBy(state.Transactions.data, function(d) {
                    return moment(d.order_pickup).month();
                });
            }
        },
        totalTransaction(state) {
            if (state.Transactions.data) {
                return state.Transactions.data.length;
            } else {
                return 0;
            }
        },
        checkUnfounds(state) {
            if (state.Unfounds.data) {
                return state.Unfounds.data.length;
            } else {
                return 0;
            }
        },
        totalRiderCountPerDay(state) {
            let total_rider = 0,
                total_transaction = 0;

            if (state.RiderCountPerDay.length) {
                state.RiderCountPerDay.forEach(d => {
                    total_rider += d.no_of_riders;
                });
                state.RiderCountPerDay.forEach(d => {
                    total_transaction += d.no_of_transaction;
                });

                return { total_rider, total_transaction };
            }
        },
        totalHourlyCallMonitoring(state) {
            let total_x = [],
                total_y = [],
                total = 0;
            let data = state.HourlyCallMonitoring;
            if (data.result || data.result2) {
                for (let i = 0; i < data.result2.length; i++) {
                    var ytrans_num = 0;
                    var y_data = data.result2[i]["time_data"];
                    y_data.filter(d => {
                        ytrans_num += d.trans_num;
                    });

                    total_y.push(ytrans_num);
                }

                for (let i = 0; i < data.result.length; i++) {
                    var xtrans_num = 0;
                    for (let iz = 0; iz < data.result2.length; iz++) {
                        xtrans_num +=
                            data.result2[iz]["time_data"][i]["trans_num"];
                    }
                    total_x.push(xtrans_num);
                }
            }
            total_x.filter(d => (total += d));

            return { total_x, total_y, total };
        },
        totalCommission(state) {
            let total_purchase = 0,
                total_percentage = 0;

            if (state.Commission.length) {
                state.Commission.forEach(d => {
                    total_purchase += d.total_purchase;
                });
                state.Commission.forEach(d => {
                    total_percentage += parseFloat(d.total_purchase * 0.1);
                });
                return { total_purchase, total_percentage };
            }
        }
    }
};
