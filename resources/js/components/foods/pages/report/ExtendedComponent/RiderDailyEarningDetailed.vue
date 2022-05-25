<template>
    <div class="w-3/4 mt-2 border rounded">
        <table class="min-w-full " id="rider_daily_earning_table">
            <thead class="border-b tracking-normal">
                <tr>
                    <th class=" p-2 text-left">Date</th>
                    <th class=" p-2 text-left">
                        Location
                    </th>
                    <th class=" p-2 text-center">
                        Rates (Rider's Fee + Fuel)
                    </th>
                    <th class=" p-2 text-center">
                        No. of Transaction
                    </th>
                    <th class=" p-2 text-right">
                        Total
                    </th>
                </tr>
            </thead>

            <tbody class="tbody">
                <tr v-if="RiderDailyEarning.grandTotal == 0">
                    <td colspan="5" class="font-semibold text-center td"> NO DATA AVAILABLE </td>
                </tr>
                <template v-for="({
                rider,
                dates,
                grandTotalRates,
                grandTotalTransactions,
                grandTotalTotal
            },
                index) in RiderDailyEarning.tableData">

                    <tr :key="`${rider}-${index}`">
                        <td class="p-2  bg-gray-50 border-b font-semibold text-gray-600  text-xs uppercase" colspan="5">
                            {{ rider }}
                        </td>
                    </tr>

                    <template v-for="({ date, towns, dateSubTotal }, dateIndex) in dates">

                        <tr :key="`a-${index}-${dateIndex}`">
                            <td class="td text-center"> {{ date }}</td>
                            <td class="border-b border-x ">
                                <table class="w-full">
                                    <tr v-for="(town, townIndex) in towns" :key="`${townIndex}-${index}`"
                                        class="border-b last:border-0">
                                        <td class="p-2 text-xs text-gray-600">{{ town.town }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-b border-x ">
                                <table class="w-full">
                                    <tr v-for="(town, townIndex) in towns" :key="`${townIndex}-${index}`"
                                        class="border-b last:border-0">
                                        <td class="p-2 text-xs text-gray-600 text-center">{{ town.rates }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-b border-x ">
                                <table class="w-full">
                                    <tr v-for="(town, townIndex) in towns" :key="`${townIndex}-${index}`"
                                        class="border-b last:border-0">
                                        <td class="p-2 text-xs text-gray-600 text-center">{{ town.noOfTransactions }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="border-b border-l ">
                                <table class="w-full">
                                    <tr v-for="(town, townIndex) in towns" :key="`${townIndex}-${index}`"
                                        class="border-b last:border-0">
                                        <td class="p-2 text-xs text-gray-600 text-right">{{ town.total }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="font-semibold  bg-gray-100" :key="`${index}-${dateIndex}`">
                            <td colspan="2" class="td ">Sub-Total</td>
                            <td class="text-center td">
                                {{ dateSubTotal.subTotalRates }}
                            </td>
                            <td class="text-center td">
                                {{ dateSubTotal.subTotalNoOfTransactions }}
                            </td>
                            <td class="text-right td">
                                {{ dateSubTotal.subTotal }}
                            </td>
                        </tr>

                    </template>
                    <tr class="font-semibold bg-gray-200 " :key="`b-${rider}-${index}`">
                        <td class="td" colspan="2">Grand Total</td>
                        <td class="td text-center">
                            {{ grandTotalRates }}
                        </td>
                        <td class="td text-center">
                            {{ grandTotalTransactions }}
                        </td>
                        <td class="td text-right">
                            {{ grandTotalTotal | toCurrency }}
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "RiderDailyEarningDetailed",
    computed: {
        ...mapState('Report', ["RiderDailyEarning"])

    },
};
</script>
