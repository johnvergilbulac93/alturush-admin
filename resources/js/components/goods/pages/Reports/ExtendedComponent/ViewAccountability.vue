<template>
    <div class="w-full">
        <center>
            <h2 class="text-lg">
                {{
                    Accountability.hasOwnProperty("b_unit") &&
                        Accountability.b_unit.business_unit
                }}
            </h2>
            <p>ALTURUSH GOODS ORDERING</p>
            <p>ACCOUNTABILITY REPORT</p>
            <p class="text-center">
                {{ dateFrom | formatDateNoTime }} To
                {{ dateTo | formatDateNoTime }}
            </p>
        </center>
        <div class="border rounded">
            <table class="min-w-full " id="accountability_table">
                <thead class="tracking-normal border-b">
                    <tr>
                        <th class="p-2  text-left ">
                            Cashier
                        </th>
                        <th class="p-2  text-center">
                            Ticket #
                        </th>
                        <th class="p-2  text-right">
                            Transaction #
                        </th>
                        <th class="p-2 text-right">Net Amount</th>
                    </tr>
                </thead>
                <tbody class="tbody ">
                    <tr v-if="!Accountability.data.length">
                        <td colspan="4" class="text-center td font-semibold">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr
                        v-for="(trans, i) in Accountability.data"
                        :key="i"
                        class="tr"
                    >
                        <td class="td text-left">
                            {{ trans.cashier_monitoring[0].name }}
                        </td>
                        <td class="td text-center">
                            {{ trans.ticket }}
                        </td>
                        <td class="td text-right">
                            {{ trans.receipt }}
                        </td>
                        <td class="td text-right">
                            {{ parseFloat(totalAmount(trans)) | toCurrency }}
                        </td>
                    </tr>
                    <tr
                        v-if="
                            Accountability.hasOwnProperty('data') &&
                                Accountability.data.length
                        "
                    >
                        <td colspan="5" class="text-center td" id="idHeader">
                            <span class="font-semibold">SUMMARY</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot
                    v-if="
                        Accountability.hasOwnProperty('data') &&
                            Accountability.data.length
                    "
                >
                    <tr>
                        <td class="td" colspan="3">
                            <span class="font-semibold">SUB TOTAL :</span>
                        </td>
                        <td class="font-semibold td text-right">
                            {{ orderSummary.lessDiscount | toCurrency }}
                        </td>
                    </tr>
                    <tr>
                        <td class=" td font-semibold " colspan="3">
                            TOTAL PICKING CHARGE :
                        </td>
                        <td class="td font-semibold text-right">
                            {{ orderSummary.pickupCharge | toCurrency }}
                        </td>
                    </tr>
                    <tr>
                        <td class="td font-semibold" colspan="3">
                            GRAND TOTAL :
                        </td>
                        <td class="font-semibold td text-right">
                            {{ orderSummary.grandTotal | toCurrency }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ["Accountability", "dateFrom", "dateTo", "dateNow"],
    name: "View-Accountability",
    computed: {
        orderSummary() {
            let grandTotal = 0,
                pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0;

            this.Accountability.data.forEach(transaction => {
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
                            orderAmount += parseFloat(order.total_price);
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
    methods: {
        totalAmount(orders) {
            let total = 0,
                orderedAmount = 0,
                discountAmount = 0,
                pickingCharge = 0;

            const uncancelledORders = orders.final_orders.filter(
                order => order.canceled_status === 0
            );

            uncancelledORders.forEach(
                order => (orderedAmount += parseFloat(order.total_price))
            );

            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );

            orders?.customer_bill?.forEach(
                order => (pickingCharge += parseFloat(order.picking_charge))
            );

            // total = orderedAmount - discountAmount + pickingCharge
            total = orderedAmount - discountAmount;
            return parseFloat(total).toFixed(2);
        }
    }
};
</script>
