<template>
    <div class="border text-gray-800 overflow-x-auto">
        <div class="mb-2 bg-gray-100 p-2">
            <label for="" class="text-lg font-semibold"
                >Hourly Call Monitoring</label
            >
        </div>
        <div class="p-2">
            <div class="flex justify-end items-center">
                <div class="w-1/2 flex items-center gap-4">
                    <div class="w-1/2">
                        <label class="text-xs text-gray-500"
                            >Filter by Store:</label
                        >
                        <select
                            v-model="filter.store"
                            class="form"
                            @change="fetch"
                        >
                            <option value="">ALL STORES</option>
                            <option
                                v-for="(store, i) in Stores"
                                :value="store.bunit_code"
                                :key="i"
                            >
                                {{ store.business_unit }}
                            </option>
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="text-xs text-gray-500"
                            >Filter by Date
                        </label>
                        <input
                            type="date"
                            v-model="filter.dateNow"
                            class="form"
                            @change="fetch"
                        />
                    </div>
                </div>
            </div>
            <hr class="mt-4" />
            <div class="flex justify-end items-center mb-4 mt-2 gap-2">
                <button
                    class="px-2 py-1 bg-blue-500 focus:outline-none text-white hover:bg-blue-600 disabled:opacity-50"
                    :disabled="totalHourlyCallMonitoring.total == 0"
                    :class="
                        totalHourlyCallMonitoring.total == 0
                            ? 'cursor-not-allowed'
                            : ''
                    "
                    @click="print()"
                >
                    <i class="fas fa-print"></i>
                    Print
                </button>
                <button
                    class="px-2 py-1 bg-green-500 focus:outline-none text-white hover:bg-green-600 disabled:opacity-50"
                    :disabled="totalHourlyCallMonitoring.total == 0"
                    :class="
                        totalHourlyCallMonitoring.total == 0
                            ? 'cursor-not-allowed'
                            : ''
                    "
                    @click="exportToExcel('xlsx')"
                >
                    <i class="far fa-file-excel"></i>
                    Export Excel
                </button>
            </div>
            <div class="flex flex-col items-center" id="section-to-print2">
                <h2 class="font-semibold text-lg ">
                    HOURLY CALL MONITORING
                </h2>
                <p class="font-semibold text-gray-700">
                    <span>SUMMARY REPORT</span>
                </p>
                <p class="text-xs">
                    AS OF: &nbsp; {{ filter.dateNow | formatDateNoTime }}
                </p>
                <div class="w-full mt-2">
                    <table
                        class="min-w-full divide-y divide-gray-300 "
                        id="exportable_table"
                    >
                        <thead
                            class="border bg-gray-100  tracking-normal text-xs "
                        >
                            <tr>
                                <th class="border p-2 text-left">TENANT(S)</th>
                                <th
                                    class="border p-2 text-center"
                                    v-for="(data,
                                    i) in HourlyCallMonitoring.result"
                                    :key="i"
                                >
                                    {{ data.trans_time }}
                                </th>
                                <td
                                    class="border p-2 text-center font-semibold"
                                >
                                    TOTAL
                                </td>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr
                                v-for="(result2,
                                i) in HourlyCallMonitoring.result2"
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
                            <tr>
                                <td class="td text-left font-semibold">
                                    TOTAL ORDER PER HOUR
                                </td>
                                <td
                                    class="td text-center font-semibold"
                                    v-for="(result,
                                    i) in totalHourlyCallMonitoring.total_x"
                                    :key="i"
                                >
                                    {{ result }}
                                </td>
                                <td class="td text-center font-semibold">
                                    {{ totalHourlyCallMonitoring.total }}
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
    name: "HourlyCallMonitoring",
    data() {
        return {
            filter: {
                dateNow: "",
                store: ""
            },
            total_trans_data: ""
        };
    },
    computed: {
        ...mapState(["HourlyCallMonitoring", "Stores"]),
        ...mapGetters(["totalHourlyCallMonitoring"])
    },
    methods: {
        ...mapActions(["getHourlyCallMonitoring", "getStore"]),
        fetch() {
            let filter = {
                date: this.filter.dateNow,
                store: this.filter.store
            };
            this.getHourlyCallMonitoring({ filter });
        },
        exportToExcel(type, fn, dl) {
            const xlsName =
                "HOURLY-CALL-MONITORING" + this.filter.dateNow + ".";
            const elt = document.getElementById("exportable_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "HOURLY CALL MONITORING"
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
        this.getStore();
    },
    beforeMount() {
        this.filter.dateNow = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
    }
};
</script>
