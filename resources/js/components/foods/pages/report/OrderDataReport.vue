<template>
    <div class="border text-gray-800 overflow-x-auto">
        <div class="mb-2 bg-gray-100 p-2">
            <label for="" class="text-lg font-semibold"
                >Order Data Report</label
            >
        </div>
        <div class="p-2">
            <div class="flex justify-end items-center">
                <div class="items-center flex gap-5">
                    <div class="w-64">
                        <label class="text-xs text-gray-500"
                            >Filter by Platform Use:</label
                        >
                        <select class="form" v-model="filter.platform"  @change="fetch()">
                            <option value="">All Platform</option>
                            <option value="1">Tele-Ordering</option>
                            <option value="2">Mobile-Application</option>
                            <option value="3">Web-Application</option>
                        </select>
                    </div>
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
                    LIST OF RIDER(S) TRANSACTION COUNT PER DAY
                </h2>
                <p class="font-semibold text-gray-700">
                    SUMMARY REPORT
                </p>
                <p class="text-xs">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </p>

                <!-- extends component here... -->
                <orderDataDetails :order_data_details="OrderDataReport" />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import orderDataDetails from "../ExtendComponent/OrderDataReportDetails.vue";
export default {
    name: "OrderDataReport",
    components: { orderDataDetails },
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: "",
                platform: ""
            }
        };
    },
    computed:{
        ...mapState(['OrderDataReport'])
    },
    methods: {
        ...mapActions(['getOrderDataReport']),
        fetch() {
            if (this.filter.dateFrom <= this.filter.dateTo) {
                let filter = {
                    dateFrom: this.filter.dateFrom,
                    dateTo: this.filter.dateTo,
                    platform: this.filter.platform
                };
                this.getOrderDataReport({ filter });
            } else {
                swal.fire("Invalid Date!", "Please check.", "error");
            }
        },
        exportToExcel(type, fn, dl) {
            const xlsName =
                "ORDER-DATA-REPORT" +
                this.filter.dateFrom +
                "to" +
                this.filter.dateTo +
                ".";
            const elt = document.getElementById("exportable_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "ORDER DATA REPORT"
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
    mounted(){
        this.fetch()
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
