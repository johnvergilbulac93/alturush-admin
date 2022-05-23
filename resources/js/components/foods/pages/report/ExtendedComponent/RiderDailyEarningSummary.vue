<template>
    <div class="w-1/2 mt-2 border rounded">
        <table class="min-w-full " id="rider_daily_earning_table">
            <thead class="border-b tracking-normal">
                <tr>
                    <th class=" p-2 text-left">Rider(s) Name</th>
                    <th class=" p-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-if="!RiderDailyEarning.summary.length">
                    <td colspan="2" class="td text-center font-semibold">
                        NO DATA AVAILABLE
                    </td>
                </tr>
                <tr v-for="(summary, i) in RiderDailyEarning.summary" :key="i">
                    <td class="text-left td">{{ summary.rider }}</td>
                    <td class="text-right td">
                        {{ summary.grandTotalTotal | toCurrency }}
                    </td>
                </tr>
            </tbody>
            <tfoot v-if="RiderDailyEarning.grandTotal != 0">
                <tr class="tracking-normal font-semibold">
                    <td class="text-center td">GRAND TOTAL</td>
                    <td class="text-right td">
                        {{ RiderDailyEarning.grandTotal | toCurrency }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "RiderDailyEarningSummary",
    computed: {
        ...mapState(["RiderDailyEarning"])
    }
};
</script>
