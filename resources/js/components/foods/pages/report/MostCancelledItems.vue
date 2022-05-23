<template>
    <div class="border text-gray-800 overflow-x-auto">
        <div class="mb-2 bg-gray-100 p-2">
            <label for="" class="text-lg font-semibold"
                >Most Cancelled Items</label
            >
        </div>
        <div class="p-2">
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
                    LIST OF MOST CANCELLED ITEMS
                </h2>
                <p class="font-semibold text-gray-700">
                    <span>SUMMARY REPORT</span>
                </p>
                <p class="text-xs">AS OF: &nbsp; {{ dateNow }}</p>
                <div class="w-3/4 mt-2">
                    <table
                        class="min-w-full divide-y divide-gray-300"
                        id="exportable_table"
                    >
                        <thead class="border bg-gray-100  tracking-normal">
                            <tr class="border">
                                <th class="border p-2 text-center">#</th>
                                <th class="border p-2 text-left">Category</th>
                                <th class="border p-2 text-left">
                                    Description
                                </th>
                                <th class="border p-2 text-right">
                                    Total Cancelled Item(s)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-if="!MostCancelledItems.length">
                                <td colspan="4" class="border p-2 text-center">
                                    NO RESULT FOUND
                                </td>
                            </tr>
                            <tr
                                v-for="(data, i) in MostCancelledItems"
                                :key="i"
                            >
                                <td class="td text-center">{{ i + 1 }}</td>
                                <td class="td text-left">
                                    {{ data.category_name }}
                                </td>
                                <td class="td text-left">
                                    {{ data.product_name }}
                                </td>
                                <td class="td text-center">{{ data.count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    name: "MostCancelledItems",
    data() {
        return {
            dateNow: ""
        };
    },
    computed: {
        ...mapState(["MostCancelledItems"])
    },
    methods: {
        ...mapActions(["getMostCancelledItem"]),
        fetch() {
            this.getMostCancelledItem();
        },
        exportToExcel(type, fn, dl) {

            const xlsName = "MOST-CANCELLED-ITEM" + this.dateNow + ".";
            const elt = document.getElementById("exportable_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "MOST CANCELLED ITEM"
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
        this.dateNow = moment(this.$root.serverDateTime).format("LL");
    }
};
</script>

<style></style>
