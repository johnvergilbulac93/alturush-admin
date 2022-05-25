<template>
    <div class="w-full mt-2 border rounded">
        <table class="min-w-full " id="order_data_report_table">
            <thead class=" border-b tracking-normal">
                <tr class="">
                    <th class=" p-2 text-center">#</th>
                    <th class=" p-2 text-left">
                        Date/Time
                    </th>
                    <th class=" p-2 text-left">Ticket Id</th>
                    <th class=" p-2 text-center">
                        Contact #
                    </th>
                    <th class=" p-2 text-left">
                        Store
                    </th>
                    <th class=" p-2 text-left">
                        Remarks
                    </th>
                    <th class=" p-2 text-center">
                        Mode of Order
                    </th>
                    <th class=" p-2 text-left">
                        Name
                    </th>
                    <th class=" p-2 text-left">
                        Address
                    </th>
                    <th class=" p-2 text-left">
                        Town
                    </th>
                    <th class=" p-2 text-left">
                        Source
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-if="!OrderDataReport.length">
                    <td class="td text-center font-semibold" colspan="11">
                        NO DATA AVAILABLE
                    </td>
                </tr>
                <tr v-for="(data, i) in OrderDataReport" :key="i">
                    <td class="td text-center">
                        {{ i + 1 }}
                    </td>
                    <td class="td text-left">
                        {{ data.date_tim | formatDate2 }}
                    </td>
                    <td class="td text-left">
                        {{ data.ticket }}
                    </td>
                    <td class="td text-left">
                        {{ data.contact_num }}
                    </td>
                    <td class="td text-left">
                        <span v-for="(tdata, ti) in data.tenants" :key="ti"
                            >{{ tdata }} <br
                        /></span>
                    </td>
                    <td class="td text-left">
                        {{ data.remarks }}
                    </td>
                    <td class="td text-center">
                        {{ data.mode }}
                    </td>
                    <td class="td text-left">{{ data.name }}</td>
                    <td class="td text-left">{{ data.address }}</td>
                    <td class="td text-left">{{ data.town }}</td>
                    <td class="td text-left">{{ data.source }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "TblOrderDataReportDetails",
    computed: {
        ...mapState("Report", ["OrderDataReport"])
    }
};
</script>
