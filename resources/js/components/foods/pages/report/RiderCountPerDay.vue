<template>
    <div class="border text-gray-800 overflow-x-auto">
        <div class="mb-2 bg-gray-100 p-2">
            <label for="" class="text-lg font-semibold"
                >Rider Count Per Day</label
            >
        </div>
        <div class="p-2">
            <div class="flex justify-end items-center">
                <div class="items-center flex gap-5">
                    <div class="w-64">
                        <label class="text-xs text-gray-500"
                            >Filter by Date From:</label
                        >
                        <input
                            type="date"
                            class="form"
                            v-model="filter.dateFrom"
                            @change="fetch()"
                        />
                    </div>
                    <div class="w-64">
                        <label class="text-xs text-gray-500"
                            >Filter by Date To:</label
                        >
                        <input
                            type="date"
                            class="form"
                            v-model="filter.dateTo"
                            @change="fetch()"
                        />
                    </div>
                </div>
            </div>
            <hr class="mt-4" />
            <div class="flex justify-end items-center mb-4 mt-2 gap-2">
                <button
                    class="px-2 py-1 bg-blue-500 focus:outline-none text-white hover:bg-blue-600 disabled:opacity-50"
                    :disabled="!RiderCountPerDay.length"
                    :class="
                        !RiderCountPerDay.length ? 'cursor-not-allowed' : ''
                    "
                    @click="print()"
                >
                    <i class="fas fa-print"></i>
                    Print
                </button>
                <button
                    class="px-2 py-1 bg-green-500 focus:outline-none text-white hover:bg-green-600 disabled:opacity-50"
                    :disabled="!RiderCountPerDay.length"
                    :class="
                        !RiderCountPerDay.length ? 'cursor-not-allowed' : ''
                    "
                    @click="exportToExcel('xlsx')"
                >
                    <i class="far fa-file-excel"></i>
                    Export Excel
                </button>
            </div>
            <div class="flex flex-col items-center" id="section-to-print2">
                <h2 class="font-semibold text-lg ">
                    LIST OF ORDER DATA
                </h2>
                <p class="font-semibold text-gray-700">SUMMARY REPORT</p>
                <p class="text-xs">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </p>
                <div class="w-1/2 mt-2">
                    <table
                        class="min-w-full divide-y divide-gray-300"
                        id="exportable_table"
                    >
                        <thead class="border bg-gray-100  tracking-normal">
                            <tr class="border">
                                <th class="border p-2 text-left">Date</th>
                                <th class="border p-2 text-center">
                                    No. of Transaction
                                </th>
                                <th class="border p-2 text-center">
                                    No. of Riders
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-if="!RiderCountPerDay.length">
                                <td class="td text-center" colspan="3">
                                    NO RESULT FOUND
                                </td>
                            </tr>
                            <tr v-for="(data, i) in RiderCountPerDay" :key="i">
                                <td class="td text-left">
                                    {{ data.transaction_date }}
                                </td>
                                <td class="td text-center">
                                    {{ data.no_of_transaction }}
                                </td>
                                <td class="td text-center">
                                    {{ data.no_of_riders }}
                                </td>
                            </tr>
                            <tr class="border font-semibold bg-gray-100" v-if="RiderCountPerDay.length">
                                <td class="border p-2 text-center">
                                    GRAND TOTAL
                                </td>
                                <td class="border p-2 text-center">
                                    {{
                                        totalRiderCountPerDay.total_transaction
                                    }}
                                </td>
                                <td class="border p-2 text-center">
                                    {{ totalRiderCountPerDay.total_rider }}
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
    name: "RiderCountPerDay",
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: ""
            }
        };
    },
    computed: {
        ...mapState(["RiderCountPerDay"]),
        ...mapGetters(["totalRiderCountPerDay"])
    },
    methods: {
        ...mapActions(["getRiderCountPerDay"]),
        fetch() {
            if (this.filter.dateFrom <= this.filter.dateTo) {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo
                };
                this.getRiderCountPerDay({ filter });
            } else {
                swal.fire("Invalid Date!", "Please check.", "error");
            }
        },
        exportToExcel(type, fn, dl) {
            const xlsName =
                "RIDER-COUNT-PER-DAY" +
                this.filter.dateFrom +
                "to" +
                this.filter.dateTo +
                ".";
            const elt = document.getElementById("exportable_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "RIDER-COUNT-PER-DAY"
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
