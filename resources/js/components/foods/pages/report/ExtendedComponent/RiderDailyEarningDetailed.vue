<template>
    <div class="w-3/4 mt-2 border rounded">
        <table class="min-w-full" id="rider_daily_earning_table">
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
                <tr
                    v-for="({
                        rider,
                        dates,
                        grandTotalRates,
                        grandTotalTransactions,
                        grandTotalTotal
                    },
                    index) in RiderDailyEarning.tableData"
                    :key="rider"
                >
                    <td colspan="5" class="td">{{ rider }}</td>
                    <template
                        v-for="({ date, towns, dateSubTotal },
                        dateIndex) in dates"
                    >
                        <td :key="`${index}+${dateIndex}`">
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>

        <!-- <table
            class="min-w-full divide-y divide-gray-300 mb-2"
            id="exportable_table"
            v-for="({
                rider,
                dates,
                grandTotalRates,
                grandTotalTransactions,
                grandTotalTotal
            },
            index) in data_rider_earning.tableData"
            :key="rider"
        >
            <thead class="border bg-gray-100  tracking-normal">
                <tr>
                    <th colspan="5" class=" p-2 border">
                        <span class="font-semibold flex justify-start">{{
                            rider
                        }}</span>
                    </th>
                </tr>
                <tr class="border">
                    <th class="border p-2 text-left">Date</th>
                    <th class="border p-2 text-center">
                        Location
                    </th>
                    <th class="border p-2 text-center">
                        Rates (Rider's Fee + Fuel)
                    </th>
                    <th class="border p-2 text-center">
                        No. of Transaction
                    </th>
                    <th class="border p-2 text-right">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
                <template
                    v-for="({ date, towns, dateSubTotal }, dateIndex) in dates"
                    :key="'a' + date"
                >
                    <tr>
                        <td class="td text-left" :rowspan="towns.length">
                            {{ date }}
                        </td>
                        <td class="td text-center">
                            {{ towns[0].town }}
                        </td>
                        <td class="td text-center">
                            {{ towns[0].rates }}
                        </td>
                        <td class="td text-center">
                            {{ towns[0].noOfTransactions }}
                        </td>
                        <td class="td text-right">
                            {{ towns[0].total | toCurrency2 }}
                        </td>
                    </tr>
                    <tr
                        v-for="{
                            town,
                            rates,
                            key,
                            noOfTransactions,
                            total
                        } in slicedTowns(towns)"
                        :key="key"
                    >
                        <td class="td text-center">{{ town }}</td>
                        <td class="td text-center">{{ rates }}</td>
                        <td class="td text-center">
                            {{ noOfTransactions }}
                        </td>
                        <td class="td text-right">{{ total | toCurrency2 }}</td>
                    </tr>
                    <tr
                        class="font-semibold bg-gray-200"
                        :key="`${dateIndex}-${rider}`"
                    >
                        <td colspan="2" class="td">Sub-Total</td>
                        <td class="text-center td">
                            {{ dateSubTotal.subTotalRates }}
                        </td>
                        <td class="text-center td">
                            {{ dateSubTotal.subTotalNoOfTransactions }}
                        </td>
                        <td class="text-right td">
                            {{ dateSubTotal.subTotal | toCurrency2 }}
                        </td>
                    </tr>
                </template>

                <tr
                    class="font-semibold bg-gray-300 "
                    :key="`${index} - ${rider} `"
                >
                    <td class="td" colspan="2">Grand Total</td>
                    <td class="td text-center">
                        {{ grandTotalRates }}
                    </td>
                    <td class="td text-center">
                        {{ grandTotalTransactions }}
                    </td>
                    <td class="td text-right">
                        {{ grandTotalTotal | toCurrency2 }}
                    </td>
                </tr>
            </tbody>
        </table> -->
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "RiderDailyEarningDetailed",
    computed: {
        ...mapState(["RiderDailyEarning"])
    },
    methods: {
        slicedTowns(towns) {
            return towns.slice(1);
        }
    }
};
</script>
