export const totalOrderAmount = state => {
    let pickupCharge = 0,
        orderAmount = 0,
        discount = 0,
        lessDiscount = 0,
        grandTotal = 0;

    if (state.Liquidation.cashier_details.length) {
        state.Liquidation.cashier_details.forEach(order => {
            pickupCharge += parseFloat(order.customer_bill[0].picking_charge);
            if (order.hasOwnProperty("final_orders") && order.final_orders) {
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
};

export const totalHourlyCallMonitoring = state => {
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
                xtrans_num += data.result2[iz]["time_data"][i]["trans_num"];
            }
            total_x.push(xtrans_num);
        }
    }
    total_x.filter(d => (total += d));

    return { total_x, total_y, total };
};
export const totalCommission = state => {
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
};
