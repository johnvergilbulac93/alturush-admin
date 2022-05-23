<template>
    <div class="w-full mt-2">
        <table
            class="min-w-full divide-y divide-gray-300"
            id="exportable_table"
        >
            <thead class="border bg-gray-100  tracking-normal">
                <tr class="border">
                    <th class="border p-2 text-center">#</th>
                    <th class="border p-2 text-left">
                        Date/Time
                    </th>
                    <th class="border p-2 text-left">Ticket Id</th>
                    <th class="border p-2 text-center">
                        Contact #
                    </th>
                    <th class="border p-2 text-left">
                        Store
                    </th>
                    <th class="border p-2 text-left">
                        Remarks
                    </th>
                    <th class="border p-2 text-center">
                        Mode of Order
                    </th>
                    <th class="border p-2 text-left">
                        Name
                    </th>
                    <th class="border p-2 text-left">
                        Address
                    </th>
                    <th class="border p-2 text-left">
                        Town
                    </th>
                    <th class="border p-2 text-left">
                        Source
                    </th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr v-if="!order_data_details.length">
                    <td class="td text-center" colspan="11">
                        NO RESULT FOUND
                    </td>
                </tr>
                <tr v-for="(data, i) in order_data_details" :key="i">
                    <td class="td text-center">
                        {{ i + 1 }}
                    </td>
                    <td class="td text-left">
                        {{ data.date_tim | formatDateNoTime }}
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
export default {
    name: "OrderDataReportDetails",
    props: ["order_data_details"]
};
</script>
