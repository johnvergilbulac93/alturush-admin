<template>
    <div class="space-y-2">
        <module-header icon="md-basket" title="Source Most Order" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-end items-center gap-2">
                <div class="w-auto">
                    <label class="block">Filter by Date From:</label>
                    <DatePicker
                        @on-change="fetch()"
                        v-model="filter.dateFrom"
                        type="date"
                        placeholder="Select Date"
                        style="width: 218px"
                    />
                </div>
                <div class="w-auto">
                    <label class=" block">Filter by Date To:</label>
                    <DatePicker
                        @on-change="fetch()"
                        v-model="filter.dateTo"
                        type="date"
                        placeholder="Select Date"
                        style="width: 218px"
                    />
                </div>
            </div>
            <hr />
            <div class="flex justify-end items-center gap-2">
                <Button
                    type="primary"
                    icon="ios-paper-outline"
                    :disabled="!SourceMostOrder.length"
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="!SourceMostOrder.length"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center">
                <span class="font-semibold text-lg block ">
                    LIST OF SOURCE MOST ORDER
                </span>
                <span class="font-semibold block">SUMMARY REPORT</span>
                <span class="text-xs block">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>
                <div class="w-1/2 mt-2 border rounded">
                    <table class="min-w-full " id="source_most_order_table">
                        <thead class="border-b  tracking-normal">
                            <tr>
                                <th class=" p-2 text-center">Source</th>
                                <th class=" p-2 text-center">
                                    Total Order(s)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-if="!SourceMostOrder.length">
                                <td
                                    class="td text-center font-semibold"
                                    colspan="2"
                                >
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr v-for="(data, i) in SourceMostOrder" :key="i">
                                <td class="td text-center">
                                    {{ data.source }}
                                </td>
                                <td class="td text-center">
                                    {{ data.count | toCurrency }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot v-if="SourceMostOrder.length">
                            <tr class=" font-semibold">
                                <td class=" p-2 text-center">
                                    TOTAL
                                </td>
                                <td class=" p-2 text-center">
                                    {{ compute_total_num() | toCurrency }}
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
import { mapState, mapActions } from "vuex";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "SourceMostOrder",
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: ""
            },
            dateNow: ""
        };
    },
    computed: {
        ...mapState("Report", ["SourceMostOrder"])
    },
    methods: {
        ...mapActions("Report", ["getSourceMostOrder"]),
        fetch() {
            if (this.filter.dateFrom > this.filter.dateTo) {
                this.$Message.error({
                    background: true,
                    content: "Invalid date!"
                });
                return;
            }
            let payload = {
                dateFrom: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                dateTo: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };
            this.getSourceMostOrder(payload);
        },
        compute_total_num() {
            var count = 0;
            this.SourceMostOrder.forEach(d => {
                count += d.count;
            });
            return count;
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
            doc.text("LIST OF SOURCE MOST ORDER", 14, finalY + 14);

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
                html: "#source_most_order_table",
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

            const xlsName = `SOURCE-MOST-ORDER-${_from}-${_to}.`;
            const elt = document.getElementById("source_most_order_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "SOURCE MOST ORDER"
            });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
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
        this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
};
</script>
