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
