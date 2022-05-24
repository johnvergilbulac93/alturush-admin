<template>
    <div class="space-y-2">
        <module-header icon="md-bicycle" title="Rider Count Per Day" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-end gap-2 items-center">
                <div class="w-auto">
                    <label class="block">Filter by Date From</label>
                    <DatePicker
                        @on-change="fetch()"
                        v-model="filter.dateFrom"
                        type="date"
                        placeholder="Select Date"
                        style="width: 218px"
                    />
                </div>
                <div class="w-auto">
                    <label class="block">Filter by Date To</label>
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
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button type="primary" icon="ios-print-outline" @click="toPDF()"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center" id="section-to-print2">
                <span class="font-semibold text-lg ">
                    LIST OF ORDER DATA
                </span>
                <span class="font-semibold text-gray-600">SUMMARY REPORT</span>
                <span class="text-xs">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>
                <div class="w-1/2 mt-2 border rounded">
                    <tblRiderCountPerDay />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
import tblRiderCountPerDay from "./ExtendedComponent/TblRiderCountPerDay.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "RiderCountPerDay",
    components: { tblRiderCountPerDay },
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
        ...mapState("Report", ["RiderCountPerDay"]),
        ...mapGetters("Report", ["totalRiderCountPerDay"])
    },
    methods: {
        ...mapActions("Report", ["getRiderCountPerDay"]),
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
            this.getRiderCountPerDay(payload);
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
            doc.text("RIDER COUNT PER DAY", 14, finalY + 14);

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
                        if (
                            data.column.dataKey == 1 ||
                            data.column.dataKey == 2
                        ) {
                            data.cell.styles.halign = "center";
                        }
                    }
                    if (data.section === "foot") {
                        if (
                            data.column.dataKey == 1 ||
                            data.column.dataKey == 2
                        ) {
                            data.cell.styles.halign = "center";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#rider_count_per_day_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    1: {
                        halign: "center"
                    },
                    2: {
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
            const xlsName = `RIDER-COUNT-PER-DAY-${_from}-${_to}.`;
            const elt = document.getElementById("rider_count_per_day_table");
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
