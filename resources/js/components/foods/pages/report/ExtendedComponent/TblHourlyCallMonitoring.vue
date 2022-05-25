<template>
    <div class="w-full mt-2 border rounded">
        <table class="min-w-full  " id="hourly_call_monitoring_table">
            <thead class="border-b  tracking-normal text-xs ">
                <tr>
                    <th class=" p-2 text-left">TENANT(S)</th>
                    <th
                        class=" p-2 text-center"
                        v-for="(data, i) in HourlyCallMonitoring.result"
                        :key="i"
                    >
                        {{ data.trans_time }}
                    </th>
                    <td class=" p-2 text-center font-semibold">
                        TOTAL
                    </td>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr
                    v-for="(result2, i) in HourlyCallMonitoring.result2"
                    :key="i"
                >
                    <td class="td text-left">
                        {{ result2.tenant }}
                    </td>
                    <td
                        class="td text-center"
                        v-for="(data, i) in result2.time_data"
                        :key="i"
                    >
                        {{ data.trans_num }}
                    </td>
                    <td class="text-center td font-semibold">
                        {{ totalHourlyCallMonitoring.total_y[i] }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="td text-left font-semibold">
                        TOTAL ORDER PER HOUR
                    </td>
                    <td
                        class="td text-center font-semibold"
                        v-for="(result, i) in totalHourlyCallMonitoring.total_x"
                        :key="i"
                    >
                        {{ result }}
                    </td>
                    <td class="td text-center font-semibold">
                        {{ totalHourlyCallMonitoring.total }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "TblHourlyCallMonitoring",
    computed: {
        ...mapState("Report", ["HourlyCallMonitoring"]),
        ...mapGetters("Report", ["totalHourlyCallMonitoring"])
    }
};
</script>
