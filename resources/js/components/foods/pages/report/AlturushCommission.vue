<template>
    <div class="border text-gray-800 overflow-x-auto">
        <div class="mb-2 bg-gray-100 p-2">
            <label for="" class="text-lg font-semibold"
                >Alturush Commission</label
            >
        </div>
        <div class="p-2">
            <div class="flex justify-between items-center gap-4">
                <div class="w-1/4">
                    <label class="text-xs text-gray-500"
                        >Filter by Category:</label
                    >
                    <select
                        v-model="filter.category"
                        class="form"
                        @change="fetch"
                    >
                        <option value="">Food, etc...</option>
                        <option value="1">Grocery</option>
                    </select>
                </div>
                <div class="w-1/4">
                    <label class="text-xs text-gray-500"
                        >Filter by Platform Use:</label
                    >
                    <select
                        v-model="filter.platform"
                        class="form"
                        @change="fetch"
                    >
                        <option value="">All Platform</option>
                        <option value="1">Tele-Ordering</option>
                        <option value="2">Mobile-Application</option>
                        <option value="3">Web-Application</option>
                    </select>
                </div>
                <div class="w-1/4">
                    <label class="text-xs text-gray-500"
                        >Filter by Date From:</label
                    >

                    <input
                        type="date"
                        v-model="filter.dateFrom"
                        class="form"
                        @change="fetch"
                    />
                </div>
                <div class="w-1/4">
                    <label class="text-xs text-gray-500"
                        >Filter by Date To:</label
                    >
                    <input
                        type="date"
                        v-model="filter.dateTo"
                        class="form"
                        @change="fetch"
                    />
                </div>
            </div>
            <hr class="mt-4" />
            <div class="flex justify-end items-center mb-4 mt-2 gap-2">
                <button
                    class="px-2 py-1 bg-blue-500 focus:outline-none text-white hover:bg-blue-600 disabled:opacity-50"
                    @click="print()"
                >
                    <i class="fas fa-print"></i>
                    Print
                </button>
                <button
                    class="px-2 py-1 bg-green-500 focus:outline-none text-white hover:bg-green-600 disabled:opacity-50"
                    @click="exportToExcel('xlsx')"
                >
                    <i class="far fa-file-excel"></i>
                    Export Excel
                </button>
            </div>
            <div class="flex flex-col items-center" id="section-to-print2">
                <h2 class="font-semibold text-lg ">
                    ALTURUSH COMMISSION
                </h2>

                <p class="font-semibold text-gray-700">SUMMARY REPORT</p>
                <p class="text-xs">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </p>
                <div class="w-full mt-2">
                    <table
                        class="min-w-full divide-y divide-gray-300"
                        id="exportable_table"
                    >
                        <thead class="border bg-gray-100  tracking-normal">
                            <tr class="border">
                                <th class="border p-2 text-center">#</th>
                                <th class="border p-2 text-center">
                                    Date/Time
                                </th>
                                <th class="border p-2 text-center">
                                    Ticket Id
                                </th>
                                <th class="border p-2 text-left">
                                    Remarks
                                </th>
                                <th class="border p-2 text-left">
                                    Name
                                </th>
                                <th class="border p-2 text-right">
                                    Total Purchase Amount
                                </th>
                                <th class="border p-2 text-right">
                                    Alturush Percent(10%)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-if="!Commission.length">
                                <td class="text-center td " colspan="7">
                                    NO RESULT FOUND
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
                                    {{ data.total_purchase | toCurrency2 }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        (data.total_purchase * 0.1)
                                            | toCurrency2
                                    }}
                                </td>
                            </tr>
                            <tr v-if="Commission.length">
                                <td
                                    class="td text-center font-semibold"
                                    colspan="5"
                                >
                                    TOTAL
                                </td>
                                <td class="td text-right font-semibold">
                                    {{
                                        totalCommission.total_purchase
                                            | toCurrency2
                                    }}
                                </td>
                                <td class="td text-right font-semibold">
                                    {{
                                        totalCommission.total_percentage
                                            | toCurrency2
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
export default {
    name: "AlturushCommission",
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: "",
                category: "",
                platform: ""
            }
        };
    },
    computed: {
        ...mapState(["Commission"]),
        ...mapGetters(["totalCommission"])
    },
    methods: {
        ...mapActions(["getCommission"]),
        fetch() {
            if (this.filter.dateFrom <= this.filter.dateTo) {
                let filter = {
                    category: this.filter.category,
                    platform: this.filter.platform,
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo
                };
                this.getCommission({ filter });
            } else {
                swal.fire("Invalid Date!", "Please check.", "error");
            }
        },

        exportToExcel(type, fn, dl) {
            const xlsName =
                "ALTURUSH-COMMISSION" +
                this.filter.dateFrom +
                "to" +
                this.filter.dateTo +
                ".";
            const elt = document.getElementById("exportable_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "ALTURUSH COMMISSION"
            });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        print() {
            window.print();
        }
    },
    mounted() {
        this.fetch();
    },
    beforeMount() {
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
    }
};
</script>
