<template>
    <div class="w-full">
        <center>
            <h2 class="text-lg ">
                {{
                    Liquidation.hasOwnProperty("b_unit") &&
                        Liquidation.b_unit.business_unit
                }}
            </h2>
            <p>ALTURUSH GOODS ORDERING</p>
            <p>LIQUIDATION REPORT</p>
            <p class="text-center  ">
                {{ dateFrom | formatDateNoTime }} To
                {{ dateTo | formatDateNoTime }}
            </p>
        </center>

        <div class="border rounded">
            <table id="liquidation_table" class="min-w-full">
                <thead class="  tracking-normal border-b">
                    <tr class="tr">
                        <th class="p-2  text-left">
                            Cashier
                        </th>
                        <th class="p-2 ">Date</th>
                        <th class="p-2 ">Ticket #</th>
                        <th class="p-2  text-left">
                            Customer
                        </th>
                        <th class="p-2 ">
                            Transaction #
                        </th>
                        <th class="p-2  text-right">
                            Gross Amt.
                        </th>
                        <th class="p-2  text-right">
                            Disc.
                        </th>
                        <th class="p-2  text-right">
                            Less Disc.
                        </th>
                        <th class="p-2  text-right">
                            Picking Charge
                        </th>
                        <th class="p-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <tr class="tr" v-if="!Liquidation.cashier_details.length">
                        <td class="td text-center font-semibold" colspan="10">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr
                        v-for="(trans, index) in Liquidation.cashier_details"
                        :key="index"
                        class="tr"
                    >
                        <td class="td ">
                            {{ trans.name }}
                        </td>
                        <td class="td">
                            {{
                                trans.final_order_status[0].order_pickup
                                    | formatDateNoTime
                            }}
                        </td>
                        <td class="td ">
                            {{ trans.tickets[0].ticket }}
                        </td>
                        <td class="td ">
                            {{ trans.tickets[0].customer }}
                        </td>
                        <td class="td ">
                            {{ trans.tickets[0].receipt }}
                        </td>
                        <td class="td text-right">
                            {{ orderedAmount(trans) | toCurrency }}
                        </td>
                        <td class="td text-right ">
                            {{ discountAmount(trans) | toCurrency }}
                        </td>
                        <td class="td text-right">
                            {{ lessDiscount(trans) | toCurrency }}
                        </td>
                        <td class="td text-right">
                            {{
                                parseFloat(
                                    trans.customer_bill[0].picking_charge
                                ) | toCurrency
                            }}
                        </td>
                        <td class="td text-right">
                            {{ parseFloat(totalAmount(trans)) | toCurrency }}
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="Liquidation.cashier_details.length">
                    <tr class="font-semibold ">
                        <td colspan="4" class="text-center p-2 ">
                            GRAND TOTAL:
                        </td>
                        <td class="p-2  text-center">
                            {{ Liquidation.cashier_details.length }}
                        </td>
                        <td class="text-right p-2 ">
                            {{ totalOrderAmount.orderAmount | toCurrency }}
                        </td>
                        <td class="text-right p-2 ">
                            {{ totalOrderAmount.discount | toCurrency }}
                        </td>
                        <td class="text-right p-2 ">
                            {{ totalOrderAmount.lessDiscount | toCurrency }}
                        </td>
                        <td class="text-right p-2 ">
                            {{ totalOrderAmount.pickupCharge | toCurrency }}
                        </td>
                        <td class="text-right p-2 ">
                            {{ totalOrderAmount.grandTotal | toCurrency }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    props: ["Liquidation", "dateFrom", "dateTo", "dateNow"],
    computed: {
        ...mapGetters("Report", ["totalOrderAmount"])
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

            total = orderedAmount - discountAmount + pickingCharge;
            return parseFloat(total).toFixed(2);
        },
        lessDiscount(orders) {
            let orderedAmount = 0,
                discountAmount = 0,
                lessDiscount = 0;

            const uncancelledORders = orders.final_orders.filter(
                order => order.canceled_status === 0
            );

            uncancelledORders.forEach(
                order => (orderedAmount += parseFloat(order.total_price))
            );

            orders.discount_amount.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );

            lessDiscount = orderedAmount - discountAmount;

            return lessDiscount;
        },
        discountAmount(orders) {
            let discountAmount = 0;
            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );
            return discountAmount;
        },
        orderedAmount(orders) {
            let orderedAmount = 0;

            const uncancelledORders = orders.final_orders.filter(
                order => order.canceled_status === 0
            );

            uncancelledORders.forEach(
                order => (orderedAmount += parseFloat(order.total_price))
            );

            return orderedAmount;
        }
    }
};
</script>
