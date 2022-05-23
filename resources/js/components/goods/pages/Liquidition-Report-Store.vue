<template>
    <div class=" space-y-2 border">
        <div class=" text-gray-800 overflow-x-auto">
            <div class="mb-2 bg-gray-100 p-2">
                <label for="" class="font-semibold text-lg "
                    >Liquidation Report</label
                >
            </div>
            <div class="p-2">
                <div
                    class="flex sm:flex-col sm:space-y-5 md:space-y-0 md:flex-row justify-between items-center"
                >
                    <div
                        class=" w-3/4 flex sm:flex-col lg:flex-row sm:space-x-0 sm:space-y-5 lg:space-x-5 lg:space-y-0 space-x-5"
                    >
                        <div class="block w-3/4 sm:w-full md:w-1/2 ">
                            <label for="" class="font-semibold"
                                >Date from</label
                            >
                            <input
                                type="date"
                                class="form "
                                tabindex="2"
                                v-model="filter.dateFrom"
                            />
                        </div>
                        <div class="block w-1/4 sm:w-full md:w-1/2">
                            <label for="" class="font-semibold">Date to</label>
                            <input
                                type="date"
                                class="form "
                                tabindex="3"
                                v-model="filter.dateTo"
                            />
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button
                            tabindex="4"
                            @click="generate()"
                            class="h-10 px-4 py-2  focus:outline-none text-white  bg-blue-500 hover:bg-blue-600 rounded"
                        >
                            Generate
                        </button>

                        <button
                            tabindex="4"
                            class="h-10 px-4 py-2 flex disabled:opacity-50  focus:outline-none text-white bg-green-500 hover:bg-green-600 rounded"
                            @click="printBtn"
                            v-if="transactions.b_unit != null"
                            :disabled="transactions.cashier_details.length"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                />
                            </svg>
                            Print
                        </button>
                    </div>
                </div>
                <hr class="mt-2" />
                <div class="mt-2" id="section-to-print2">
                    <div class="flex justify-center items-center">
                        <div
                            v-if="transactions.b_unit != null"
                            class="tracking-wide"
                        >
                            <center>
                                <h6 class="text-lg">
                                    {{
                                        transactions.hasOwnProperty("b_unit") &&
                                            transactions.b_unit.business_unit
                                    }}
                                </h6>
                                <p>ALTURUSH GOODS ORDERING</p>
                                <p>LIQUIDATION REPORT</p>
                                <p class="text-center ">
                                    {{ filter.dateFrom | formatDateNoTime }} To
                                    {{ filter.dateTo | formatDateNoTime }}
                                </p>
                            </center>
                        </div>
                    </div>
                    <div
                        class="my-10"
                        id="body-content"
                        v-for="(cashier, index) in transactions.cashier_details"
                        :key="index"
                    >
                        <span class=" font-semibold"
                            >Cashier:
                            <span class="uppercase ">{{
                                cashier[0].name
                            }}</span>
                        </span>
                        <table
                            id="table-body-content"
                            class="min-w-full divide-y divide-gray-300"
                        >
                            <thead
                                class="bg-gray-200 tracking-normal border"
                            >
                                <tr class="border">
                                    <!-- <th>Cashier</th> -->
                                    <th class="p-2 border text-left">Date</th>
                                    <th class="p-2 border text-left">Ticket #</th>
                                    <th class="p-2 border text-left">Customer</th>
                                    <th class="p-2 border text-left">Transaction #</th>
                                    <th class="p-2 border text-right">Gross Amt.</th>
                                    <th class="p-2 border text-right">Disc.</th>
                                    <th class="p-2 border text-right">Less Disc.</th>
                                    <th class="p-2 border text-right">Picking Charge</th>
                                    <th class="p-2 border text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <!-- <tr v-if="cashier.length != 0">
                                <td colspan="9" class="text-center">
                                    NO DATA AVAILABLE
                                </td>
                            </tr> -->

                                <tr
                                    v-for="(trans, index) in cashier"
                                    :key="index"
                                    class="tr"
                                >
                                    <td class="td">
                                        {{
                                            trans.final_order_status[0]
                                                .order_pickup | formatDateNoTime
                                        }}
                                    </td>
                                    <td class="td">
                                        {{ trans.tickets[0].ticket }}
                                    </td>
                                    <td class="td">
                                        {{ trans.tickets[0].customer }}
                                    </td>
                                    <td class="td">
                                        {{ trans.tickets[0].receipt }}
                                    </td>
                                    <td class="td text-right">
                                        {{ orderedAmount(trans) | toCurrency }}
                                    </td>
                                    <td class="td text-right">
                                        {{ discountAmount(trans) | toCurrency }}
                                    </td>
                                    <td class="td text-right">
                                        {{ lessDiscount(trans) | toCurrency }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            parseFloat(
                                                trans.customer_bill[0]
                                                    .picking_charge
                                            ) | toCurrency
                                        }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            parseFloat(totalAmount(trans))
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr class="tr font-semibold">
                                    <td colspan="3" class="td">
                                        GRAND TOTAL:
                                    </td>
                                    <td class="td">{{ cashier.length }}</td>
                                    <td class="td text-right">
                                        {{
                                            totalOrderAmount(cashier)
                                                .orderAmount | toCurrency
                                        }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            totalOrderAmount(cashier).discount
                                                | toCurrency
                                        }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            totalOrderAmount(cashier)
                                                .lessDiscount | toCurrency
                                        }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            totalOrderAmount(cashier)
                                                .pickupCharge | toCurrency
                                        }}
                                    </td>
                                    <td class="td text-right">
                                        {{
                                            totalOrderAmount(cashier)
                                                .grandTotal | toCurrency
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <small
                        class="text-xs flex justify-end mt-2"
                        v-if="transactions.b_unit != null"
                        >Run Time: {{ dateNow }}</small
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Report from "../../../services/Report";
export default {
    name: "Liquidation-Report",
    data() {
        return {
            total_result: null,
            transactions: [],
            totalTransaction: null,
            logo: null,
            dateNow: null,
            filter: {
                dateFrom: null,
                dateTo: null
            }
        };
    },
    methods: {
        totalOrderAmount(orders) {
            let pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0,
                grandTotal = 0;

            orders.forEach(order => {
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
        },
        printBtn() {
            window.print();
        },
        generate() {
            let filter = {
                startDate: this.filter.dateFrom,
                endDate: this.filter.dateTo
            };
            if (this.filter.dateFrom > this.filter.dateTo) {
                swal.fire("Invalid Date!", "Please check.", "warning");
            } else {
                Report.store_liquidation_report(filter).then(res => {
                    this.transactions = res.data;
                });
            }
        }
    },
    mounted() {
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
};
</script>
