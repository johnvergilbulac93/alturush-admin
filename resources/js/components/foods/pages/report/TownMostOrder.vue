<template>
    <div class="space-y-2">
        <module-header icon="md-basket" title="Town Most Order" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center gap-2">
                <div class="w-1/4 ">
                    <label class="block">Filter by Global Category:</label>
                    <Select v-model="filter.category" @on-change="fetch()">
                        <Option
                            v-for="(data, i) in GlobalCategory"
                            :key="i"
                            :value="data.id"
                            >{{ data.category }}</Option
                        >
                    </Select>
                </div>

                <div class="w-3/4 flex justify-end items-center gap-4 ">
                    <div class="w-auto">
                        <label class="block">Filter by Date From:</label>
                        <DatePicker
                            @on-change="fetch()"
                            v-model="filter.dateFrom"
                            type="date"
                            placeholder="Select Date"
                            style="width: 218px"
                        ></DatePicker>
                    </div>
                    <div class="w-auto">
                        <label class=" block">Filter by Date To:</label>
                        <DatePicker
                            @on-change="fetch()"
                            v-model="filter.dateTo"
                            type="date"
                            placeholder="Select Date"
                            style="width: 218px"
                        ></DatePicker>
                    </div>
                </div>
            </div>
            <hr />
            <div class="flex justify-end items-center gap-2">
                <Button
                    type="primary"
                    icon="ios-paper-outline"
                    :disabled="!TownMostOrder.length"
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="!TownMostOrder.length"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center ">
                <span class=" block font-semibold text-lg  text-gray-600"
                    >LIST OF TOWN MOST ORDER</span
                >
                <span class="block font-semibold  text-gray-600"
                    >DAILY SUMMARY REPORT</span
                >
                <span class=" block text-xs text-gray-600">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>
                <div class="w-1/2 mt-2 border rounded">
                    <table class="min-w-full" id="town_most_order_table">
                        <thead class="border-b tracking-normal">
                            <tr>
                                <th class=" p-2 text-center">Town(s)</th>
                                <th class=" p-2 text-center">
                                    Total Order(s)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-if="!TownMostOrder.length">
                                <td
                                    colspan="2"
                                    class="text-center td text-gray-500 font-semibold"
                                >
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr v-for="(detail, i) in TownMostOrder" :key="i">
                                <td class="td text-center">
                                    {{ detail.town }}
                                </td>
                                <td class="td text-center">
                                    {{ detail.total_order }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot v-if="TownMostOrder.length">
                            <tr>
                                <td class="td text-center font-semibold">
                                    TOTAL
                                </td>
                                <td class="td text-center font-semibold">
                                    {{ compute_total_num() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    name: "TownMostOrder",
    data() {
        return {
            filter: {
                category: 1,
                dateFrom: "",
                dateTo: ""
            },
            dateNow: ""
        };
    },
    computed: {
        ...mapState(["GlobalCategory"]),
        ...mapState("Report", ["TownMostOrder"])
    },
    methods: {
        ...mapActions(["getGlobalCategory", "getTownMostOrder"]),
        ...mapActions("Report", ["getTownMostOrder"]),

        fetch() {
            if (this.filter.dateFrom > this.filter.dateTo) {
                this.$Message.error({
                    background: true,
                    content: "Invalid date!"
                });
                return;
            }
            let payload = {
                category: this.filter.category,
                dateFrom: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                dateTo: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };
            this.getTownMostOrder(payload);
        },
        toPDF() {
            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");

            const doc = new jsPDF({
                orientation: "p",
                unit: "mm",
                format: "letter",
                putOnlyUsedFonts: true
            });
            var finalY = doc.lastAutoTable.finalY || 0;

            doc.setFontSize(10);
            doc.setTextColor("#4b5563");
            doc.text("LIST OF TOWN MOST ORDER", 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("DAILY SUMMARY REPORT", 14, finalY + 18);
            doc.text(`${_from} to ${_to}`, 14, finalY + 22);
            doc.autoTable({
                didDrawPage: data => {
                    var str = "Page " + doc.internal.getNumberOfPages();
                    var runtime = "Run Time: " + this.dateNow;

                    doc.setFontSize(8);
                    var pageSize = doc.internal.pageSize;
                    var pageHeight = pageSize.height
                        ? pageSize.height
                        : pageSize.getHeight();
                    doc.text(
                        str,
                        206 - data.settings.margin.left,
                        pageHeight - 10
                    );
                    doc.setFontSize(5);
                    doc.text(
                        runtime,
                        data.settings.margin.left,
                        pageHeight - 10
                    );
                },
                didParseCell: data => {
                    if (data.section === "head") {
                        if (data.column.dataKey == 1) {
                            data.cell.styles.halign = "center";
                        }
                    }
                    if (data.section === "foot") {
                        if (data.column.dataKey == 1) {
                            data.cell.styles.halign = "center";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#town_most_order_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    1: {
                        halign: "center"
                    }
                },
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));
        },
        toExcel(type, fn, dl) {
            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");

            const xlsName = `TOWN-MOST-ORDER-${_from}-${_to}.`;
            const elt = document.getElementById("town_most_order_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "TOWN MOST ORDER"
            });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        compute_total_num() {
            let count = 0;
            this.TownMostOrder.forEach(item => {
                count += item.total_order;
            });
            return Number(count);
        }
    },
    mounted() {
        this.getGlobalCategory();
        this.fetch();
    },
    beforeMount() {
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
};
</script>
