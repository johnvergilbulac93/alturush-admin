<template>
    <div class=" space-y-2 border">
        <div class=" text-gray-800 overflow-x-auto">
            <div class="mb-2 bg-gray-100 p-2">
                <label for="" class="font-semibold text-lg "
                    >Cashier Accountability Report</label
                >
            </div>
            <div class="p-2">
                <div
                    class="flex sm:flex-col sm:space-y-5 md:space-y-0 md:flex-row justify-between items-center"
                >
                    <div
                        class=" w-3/4 flex sm:flex-col lg:flex-row sm:space-x-0 sm:space-y-5 lg:space-x-5 lg:space-y-0 space-x-5"
                    >
                        <div class="block w-1/4 sm:w-full md:w-1/2 ">
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
                            class="h-10 px-4 py-2 flex disabled:opacity-50  focus:outline-none text-white  bg-green-500 hover:bg-green-600 rounded"
                            @click="printBtn"
                            v-if="transactions.b_unit != null"
                            :disabled="!transactions.data.length"
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
                <div id="section-to-print2" class="mt-2">
                    <div v-if="transactions.b_unit != null">
                        <div class="flex justify-center items-center">
                            <center>
                                <h6 class="text-lg">
                                    {{
                                        transactions.hasOwnProperty("b_unit") &&
                                            transactions.b_unit.business_unit
                                    }}
                                </h6>
                                <p>ALTURUSH GOODS ORDERING</p>
                                <p>ACCOUNTABILITY REPORT</p>
                                <p class="text-center ">
                                    {{ filter.dateFrom | formatDateNoTime }} To
                                    {{ filter.dateTo | formatDateNoTime }}
                                </p>
                            </center>
                        </div>
                        <table class="min-w-full divide-y divide-gray-300 mt-2">
                            <thead class="tracking-normal border bg-gray-200">
                                <tr class=" border">
                                    <th class="p-2 border text-left">Cashier</th>
                                    <th class="p-2 border text-left">Ticker #</th>
                                    <th class="p-2 border text-left">Transaction #</th>
                                    <th class="p-2 border text-right">Net Amount</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <tr v-if="!transactions.data.length" class="tr">
                                    <td colspan="4" class="td text-center">
                                        NO DATA AVAILABLE
                                    </td>
                                </tr>
                                <tr
                                    v-for="(trans, i) in transactions.data"
                                    :key="i"
                                    class="tr"
                                >
                                    <td class="td">
                                        {{ trans.cashier_monitoring[0].name }}
                                    </td>
                                    <td class="td">{{ trans.ticket }}</td>
                                    <td class="td">{{ trans.receipt }}</td>
                                    <td class="td text-right">
                                        {{
                                            parseFloat(totalAmount(trans))
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                    class="tr font-semibold"
                                >
                                    <td colspan="5" class="td">
                                        SUMMARY
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                    class="tr font-semibold"
                                >
                                    <td colspan="2" class="td"></td>
                                    <td class="td">
                                        SUB TOTAL :
                                    </td>
                                    <td colspan="2" class="td text-right">
                                        {{
                                            orderSummary.lessDiscount
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                    class="tr font-semibold"
                                >
                                    <td colspan="2" class="td"></td>
                                    <td class="td">
                                        TOTAL PICKING CHARGE :
                                    </td>
                                    <td colspan="2" class="td text-right">
                                        {{
                                            orderSummary.pickupCharge
                                                | toCurrency
                                        }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="
                                        transactions.hasOwnProperty('data') &&
                                            transactions.data.length
                                    "
                                    class="tr font-semibold"
                                >
                                    <td colspan="2" class="tr"></td>
                                    <td class="td">
                                        GRAND TOTAL :
                                    </td>
                                    <td colspan="2" class="td text-right">
                                        {{
                                            orderSummary.grandTotal | toCurrency
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <small class="text-xs flex justify-end mt-2"
                            >Run Time: {{ dateNow }}</small
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Report from "../../../services/Report";
export default {
    name: "Cashier-Accountability",
    data() {
        return {
            transactions: [],
            stores: [],
            logo: null,
            dateNow: null,
            filter: {
                dateFrom: null,
                dateTo: null
            }
        };
    },
    computed: {
        orderSummary() {
            let grandTotal = 0,
                pickupCharge = 0,
                orderAmount = 0,
                discount = 0,
                lessDiscount = 0;

            this.transactions.data.forEach(transaction => {
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
        printBtn() {
            window.print();
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

            // total = orderedAmount - discountAmount + pickingCharge
            total = orderedAmount - discountAmount;
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

            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );

            lessDiscount = orderedAmount - discountAmount;

            return lessDiscount;
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
        discountAmount(orders) {
            let discountAmount = 0;
            orders?.discount_amount?.forEach(
                order => (discountAmount += parseFloat(order.discount))
            );
            return discountAmount;
        },
        generate() {
            let filter = {
                startDate: this.filter.dateFrom,
                endDate: this.filter.dateTo
            };
            if (this.filter.dateFrom > this.filter.dateTo) {
                swal.fire("Invalid Date!", "Please check.", "warning");
            } else {
                Report.store_cashier_accountability_report(filter).then(res => {
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
