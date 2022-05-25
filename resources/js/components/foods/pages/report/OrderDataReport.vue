<template>
    <div class="space-y-2">
        <module-header icon="md-basket" title="Order Data Report" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center">
                <div class="w-64">
                    <label class="block">Filter by Type:</label>
                    <Select
                        v-model="filter.platform"
                        @on-change="fetch"
                        placeholder="Select type"
                    >
                        <Option value="all">All Platform</Option>
                        <Option value="1">Tele-Ordering</Option>
                        <Option value="2">Mobile-Application</Option>
                        <Option value="3">Web-Application</Option>
                    </Select>
                </div>

                <div class="flex justify-end gap-2 items-center">
                    <div class="w-auto">
                        <label class="block">Filter by Date From</label>
                        <DatePicker
                            @on-change="fetch"
                            v-model="filter.dateFrom"
                            type="date"
                            placeholder="Select Date"
                            style="width: 218px"
                        />
                    </div>
                    <div class="w-auto">
                        <label class="block">Filter by Date To</label>
                        <DatePicker
                            @on-change="fetch"
                            v-model="filter.dateTo"
                            type="date"
                            placeholder="Select Date"
                            style="width: 218px"
                        />
                    </div>
                </div>
            </div>
            <hr />
            <div class="flex justify-end items-center gap-2">
                <Button
                    type="primary"
                    icon="ios-paper-outline"
                    @click="toExcel('xlsx')"
                    :disabled="!OrderDataReport.length"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="!OrderDataReport.length"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center">
                <span class="font-semibold text-lg ">
                    LIST OF RIDER(S) TRANSACTION COUNT PER DAY
                </span>
                <span class="font-semibold ">
                    SUMMARY REPORT
                </span>
                <span class="text-xs">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>
                <tblOrderDataDetails />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import tblOrderDataDetails from "./ExtendedComponent/TblOrderDataReportDetails.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "OrderDataReport",
    components: { tblOrderDataDetails },
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: "",
                platform: "all"
            },
            dateNow: ""
        };
    },
    computed: {
        ...mapState("Report", ["OrderDataReport"])
    },
    methods: {
        ...mapActions("Report", ["getOrderDataReport"]),
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
                dateTo: moment(this.filter.dateTo).format("YYYY-MM-DD"),
                platform: this.filter.platform
            };
            this.getOrderDataReport(payload);
        },
        toPDF() {
            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");

            const doc = new jsPDF({
                orientation: "l",
                unit: "mm",
                format: "letter",
                putOnlyUsedFonts: true
            });
            var finalY = doc.lastAutoTable.finalY || 0;

            doc.setFontSize(10);
            doc.setTextColor("#4b5563");
            doc.text(
                "LIST OF RIDER(S) TRANSACTION COUNT PER DAY",
                14,
                finalY + 14
            );

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("SUMMARY REPORT", 14, finalY + 18);
            doc.text(`${_from} to ${_to}`, 14, finalY + 22);
            doc.autoTable({
                didDrawPage: data => {
                    console.log(data);
                    var str = "Page " + doc.internal.getNumberOfPages();
                    var runtime = "Run Time: " + this.dateNow;

                    doc.setFontSize(8);
                    var pageSize = doc.internal.pageSize;
                    var pageHeight = pageSize.height
                        ? pageSize.height
                        : pageSize.getHeight();
                    doc.text(
                        str,
                        271 - data.settings.margin.left,
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
                        if (data.column.dataKey == 0) {
                            data.cell.styles.halign = "center";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#order_data_report_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    0: {
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

            const xlsName = `ORDER-DATA-REPORT-${_from}-${_to}.`;
            const elt = document.getElementById("order_data_report_table");
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
