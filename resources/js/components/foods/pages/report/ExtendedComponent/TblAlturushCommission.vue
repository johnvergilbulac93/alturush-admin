<template>
    <div class="w-full mt-2 border rounded">
        <table class="min-w-full d" id="commission_table">
            <thead class="border-b  tracking-normal">
                <tr>
                    <th class=" p-2 text-center">#</th>
                    <th class=" p-2 text-center">
                        Date/Time
                    </th>
                    <th class=" p-2 text-center">
                        Ticket Id
                    </th>
                    <th class=" p-2 text-left">
                        Remarks
                    </th>
                    <th class=" p-2 text-left">
                        Name
                    </th>
                    <th class=" p-2 text-right">
                        Total Purchase Amount
                    </th>
                    <th class=" p-2 text-right">
                        Alturush Percent(10%)
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-if="!Commission.length">
                    <td class="text-center td font-semibold" colspan="7">
                        NO DATA AVAILABLE
                    </td>
                </tr>
                <tr v-for="(data, i) in Commission" :key="i">
                    <td class="td text-center">
                        {{ i + 1 }}
                    </td>
                    <td class="td text-center">{{ data.time }}</td>
                    <td class="td text-center">
                        {{ data.dataz.ticket }}
                    </td>
                    <td class="td text-left">
                        {{
                            data.dataz.type == 3
                                ? "Web-Application"
                                : data.dataz.type == 2
                                ? "Mobile-Application"
                                : "Tele-Ordering"
                        }}
                    </td>
                    <td class="td text-left">
                        {{ data.dataz.customer_name }}
                    </td>
                    <td class="td text-right">
                        {{ data.total_purchase | toCurrency }}
                    </td>
                    <td class="td text-right">
                        {{ (data.total_purchase * 0.1) | toCurrency }}
                    </td>
                </tr>
            </tbody>
            <tfoot v-if="Commission.length">
                <tr>
                    <td class="td text-center font-semibold" colspan="5">
                        TOTAL
                    </td>
                    <td class="td text-right font-semibold">
                        {{ totalCommission.total_purchase | toCurrency }}
                    </td>
                    <td class="td text-right font-semibold">
                        {{ totalCommission.total_percentage | toCurrency }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
    name: "TblAlturushCommission",
    computed: {
        ...mapState("Report", ["Commission"]),
        ...mapGetters("Report", ["totalCommission"])
    }
};
</script>
