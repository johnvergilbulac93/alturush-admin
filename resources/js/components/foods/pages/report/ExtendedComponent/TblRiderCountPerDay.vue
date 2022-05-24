<template>
    <table class="min-w-full " id="rider_count_per_day_table">
        <thead class="border-b ">
            <tr>
                <th class=" p-2 text-left">Date</th>
                <th class=" p-2 text-center">
                    No. of Transaction
                </th>
                <th class=" p-2 text-center">
                    No. of Riders
                </th>
            </tr>
        </thead>
        <tbody class="tbody">
            <tr v-if="!RiderCountPerDay.length">
                <td class="td text-center font-semibold" colspan="3">
                    NO RESULT FOUND
                </td>
            </tr>
            <tr v-for="(data, i) in RiderCountPerDay" :key="i">
                <td class="td text-left">
                    {{ data.transaction_date }}
                </td>
                <td class="td text-center">
                    {{ data.no_of_transaction | toCurrency }}
                </td>
                <td class="td text-center">
                    {{ data.no_of_riders | toCurrency }}
                </td>
            </tr>
        </tbody>
        <tfoot v-if="RiderCountPerDay.length">
            <tr class=" font-semibold bg-gray-100">
                <td class=" p-2 text-center">
                    GRAND TOTAL
                </td>
                <td class=" p-2 text-center">
                    {{ totalRiderCountPerDay.total_transaction | toCurrency }}
                </td>
                <td class=" p-2 text-center">
                    {{ totalRiderCountPerDay.total_rider | toCurrency }}
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
    name: "TblRiderCountPerDay",
    computed: {
        ...mapState("Report", ["RiderCountPerDay"]),
        ...mapGetters("Report", ["totalRiderCountPerDay"])
    }
};
</script>
