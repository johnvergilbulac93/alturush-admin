<template>
    <section>
        <div class="flex flex-col " v-if="filter.store === 'all'">
            <center>
                <h6 class="text-lg">
                    ALL STORES
                </h6>
                <p>
                    ALTURUSH GOODS ORDERING
                </p>
                <p>
                    TOTAL ORDERS REPORT(<span class="text-red-500">{{
                        filter.type
                    }}</span
                    >)
                </p>
                <p class="text-center ">
                    {{ filter.dateFrom | formatDateNoTime }}
                    To
                    {{ filter.dateTo | formatDateNoTime }}
                </p>
            </center>
            <div class="mt-5 border rounded">
                <table class="min-w-full" id="transactions_table">
                    <thead class="tracking-normal border-b">
                        <tr>
                            <th class="p-2 text-left ">
                                Date
                            </th>
                            <th class="p-2 text-left ">
                                Customer
                            </th>
                            <th class="p-2 text-center ">
                                Transaction #.
                            </th>
                            <th class="p-2 text-right ">
                                Gross Amount
                            </th>
                            <th class="p-2 text-right ">
                                Picking Charge
                            </th>
                            <th class="p-2 text-right ">
                                Total Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        class="tbody"
                        v-for="(store, index) in transactionByStore"
                        :key="index"
                    >
                        <tr class="bg-gray-50">
                            <td
                                colspan="6"
                                class="td font-semibold"
                                id="idHeader"
                            >
                                {{ store[0].business_unit }}
                            </td>
                        </tr>
                        <tr
                            v-for="(data, index) in store"
                            :key="index"
                            class="tr"
                        >
                            <td class="td text-center">
                                {{ data.order_pickup | formatDateNoTime }}
                            </td>
                            <td class="td text-left">
                                {{ data.customer }}
                            </td>
                            <td class="td text-center">
                                {{ data.receipt }}
                            </td>
                            <td class="td text-right">
                                {{ orderedAmount(data) | toCurrency }}
                            </td>
                            <td class="td text-right">
                                {{
                                    parseFloat(
                                        data.customer_bill[0].picking_charge
                                    ) | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{ parseFloat(totalAmount(data)) | toCurrency }}
                            </td>
                        </tr>
                        <tr class=" font-semibold bg-gray-100" id="idSubTotal">
                            <td colspan="2" class="td ">
                                Sub Total
                            </td>
                            <td class="td text-center">
                                {{ store.length }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(store).orderAmount
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(store).pickupCharge
                                        | toCurrency
                                }}
                            </td>
                            <td class="td text-right">
                                {{
                                    totalOrderAmount(store).grandTotal
                                        | toCurrency
                                }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot v-if="totalTransaction != 0">
                        <tr class="bg-gray-100">
                            <td colspan="2" class="td font-semibold">
                                GRAND TOTAL
                            </td>
                            <td class="td font-semibold text-center">
                                {{ totalTransaction }}
                            </td>
                            <td class="td font-semibold text-right">
                                {{ orderAmount | toCurrency }}
                            </td>
                            <td class="td font-semibold text-right">
                                {{ totalPickupCharge | toCurrency }}
                            </td>
                            <td class="td font-semibold text-right">
                                {{ grandTotal | toCurrency }}
                            </td>
                        </tr>
                    </tfoot>
                    <tfoot v-else>
                        <tr>
                            <td
                                colspan="6"
                                class="td font-semibold text-center"
                            >
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="flex flex-col " v-else>
            <div v-if="filter.store">
                <center>
                    <h6 class="text-lg">
                        {{
                            Transactions.hasOwnProperty("b_unit") &&
                                Transactions.b_unit.business_unit
                        }}
                    </h6>
                    <p>
                        ALTURUSH GOODS ORDERING
                    </p>
                    <p>
                        TOTAL ORDERS REPORT(<span class="text-red-500">{{
                            filter.type
                        }}</span
                        >)
                    </p>
                    <p class="text-center">
                        {{ filter.dateFrom | formatDateNoTime }}
                        To
                        {{ filter.dateTo | formatDateNoTime }}
                    </p>
                </center>
                <div class="mt-5 border rounded">
                    <table class="min-w-full" id="transactions_table">
                        <thead class=" tracking-normal border-b">
                            <tr>
                                <th class="p-2 text-left ">
                                    Date
                                </th>
                                <th class="p-2  text-left">
                                    Customer
                                </th>
                                <th class="p-2  text-center">
                                    Transaction #
                                </th>
                                <th class="p-2  text-right">
                                    Gross Amount
                                </th>
                                <th class="p-2  text-right">
                                    Pick-up Charge
                                </th>
                                <th class="p-2  text-right">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="tbody"
                            v-for="(byMonth, index) in transactionByMonth"
                            :key="index"
                        >
                            <tr class="bg-gray-50">
                                <td
                                    colspan="6"
                                    class="td font-semibold"
                                    id="idHeader"
                                >
                                    {{
                                        byMonth[0].order_pickup
                                            | formatDateMonthOnly
                                    }}
                                </td>
                            </tr>
                            <tr
                                v-for="(data, innerIndex) in byMonth"
                                :key="innerIndex"
                                class="tr"
                            >
                                <td class="td">
                                    {{ data.order_pickup | formatDateNoTime }}
                                </td>
                                <td class="td ">
                                    {{ data.customer }}
                                </td>
                                <td class="td text-center">
                                    {{ data.receipt }}
                                </td>
                                <td class="td text-right">
                                    {{ orderedAmount(data) | toCurrency }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        parseFloat(
                                            data.customer_bill[0].picking_charge
                                        ) | toCurrency
                                    }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        parseFloat(totalAmount(data))
                                            | toCurrency
                                    }}
                                </td>
                            </tr>
                            <tr
                                class=" font-semibold bg-gray-100"
                                id="idSubTotal"
                            >
                                <td colspan="2" class="td ">
                                    Sub Total
                                </td>
                                <td class="td text-center">
                                    {{ byMonth.length }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        totalOrderAmount(byMonth).orderAmount
                                            | toCurrency
                                    }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        totalOrderAmount(byMonth).pickupCharge
                                            | toCurrency
                                    }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        totalOrderAmount(byMonth).grandTotal
                                            | toCurrency
                                    }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot v-if="totalTransaction != 0">
                            <tr class="bg-gray-100">
                                <td colspan="2" class="td font-semibold">
                                    GRAND TOTAL
                                </td>
                                <td class="td font-semibold text-center">
                                    {{ totalTransaction }}
                                </td>
                                <td class="td font-semibold text-right">
                                    {{ orderAmount | toCurrency }}
                                </td>
                                <td class="td font-semibold text-right">
                                    {{ totalPickupCharge | toCurrency }}
                                </td>
                                <td class="td font-semibold text-right">
                                    {{ grandTotal | toCurrency }}
                                </td>
                            </tr>
                        </tfoot>
                        <tfoot v-else>
                            <tr>
                                <td
                                    colspan="6"
                                    class="td font-semibold text-center"
                                >
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapGetters, mapMutations, mapState } from "vuex";

export default {
    name: "DetailedTransactionsReport",
    props: ["filter"],
    computed: {
        ...mapState("Report", ["Transactions"]),
        ...mapGetters("Report", [
            "transactionByStore",
            "transactionByMonth",
            "totalTransaction",
            "totalPickupCharge",
            "grandTotal",
            "orderAmount"
        ])
    },
    methods: {
        orderedAmount(orders) {
            let orderedAmount = 0;

            const uncancelledORders = orders.final_orders.filter(
                order => order.canceled_status === 0
            );

            uncancelledORders.forEach(
                order => (orderedAmount += parseFloat(order.total_price))
            );

            return orderedAmount;
        },
        totalOrderAmount(orders) {
            let pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0,
                grandTotal = 0;
            orders.forEach(order => {
                // console.log(order);
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
        },
        totalAmount(orders) {
            let total = 0,
                orderedAmount = 0,
                discountAmount = 0,
                pickingCharge = 0;
            if (orders.final_orders != null) {
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
            }
        }
    }
};
</script>
