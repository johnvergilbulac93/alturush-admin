<template>
    <div class="space-y-2">
        <module-header icon="md-bicycle" title="Rider Daily Earning" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center">
                <div class="w-64">
                    <label class="block">Filter by Type:</label>
                    <Select class="form" v-model="filter.type" @on-change="fetch" placeholder="Select type">
                        <Option value="1">Detailed</Option>
                        <Option value="2">Summary</Option>
                    </Select>
                </div>

                <div class="flex justify-end gap-2 items-center">
                    <div class="w-auto">
                        <label class="block">Filter by Date From</label>
                        <DatePicker @on-change="fetch()" v-model="filter.dateFrom" type="date" placeholder="Select Date"
                            style="width: 218px" />
                    </div>
                    <div class="w-auto">
                        <label class="block">Filter by Date To</label>
                        <DatePicker @on-change="fetch()" v-model="filter.dateTo" type="date" placeholder="Select Date"
                            style="width: 218px" />
                    </div>
                </div>
            </div>
            <hr />
            <div class="flex justify-end items-center gap-2" v-if="filter.type == 2">
                <Button type="primary" icon="ios-paper-outline" :disabled="RiderDailyEarning.grandTotal == 0"
                    @click="toExcel('xlsx')">Excel</Button>
                <Button type="primary" icon="ios-print-outline" @click="toPDF()"
                    :disabled="RiderDailyEarning.grandTotal == 0">Print</Button>
            </div>
            <div class="flex flex-col items-center">
                <span class="font-semibold text-lg block">
                    LIST OF RIDER(S) DAILY EARNING
                </span>
                <span v-if="filter.type == 1" class="font-semibold block">DETAILED REPORT</span>
                <span v-if="filter.type == 2" class="font-semibold block">SUMMARY REPORT</span>
                <span class="text-xs block">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>

                <riderdetailed :data_rider_earning="RiderDailyEarning" v-if="filter.type == 1" />
                <ridersummary :data_rider_earning="RiderDailyEarning" v-if="filter.type == 2" />

            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import riderdetailed from "./ExtendedComponent/RiderDailyEarningDetailed.vue";
import ridersummary from "./ExtendedComponent/RiderDailyEarningSummary.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    name: "RiderDailyEarning",
    components: { riderdetailed, ridersummary },
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: "",
                type: "1"
            },
            dateNow: ""
        };
    },
    computed: {
        ...mapState('Report', ["RiderDailyEarning"])
    },
    methods: {
        ...mapActions('Report', ["getRiderDailyEarning"]),
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
            this.getRiderDailyEarning(payload);
        },
        toExcel(type, fn, dl) {

            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");

            const xlsName = `RIDER-DAILY-EARNING-${_from}-${_to}.`;
            const elt = document.getElementById("rider_daily_earning_table");
            console.log(elt)
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "RIDER DAILY EARNING"
            });
            return dl
                ? XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: "base64"
                })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
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
            doc.text("RIDER DAILY EARNING", 14, finalY + 14);

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
                            data.cell.styles.halign = "right";
                        }
                    }
                    if (data.section === "foot") {
                        if (data.column.dataKey == 1) {
                            data.cell.styles.halign = "right";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#rider_daily_earning_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    1: {
                        halign: "right"
                    }
                },
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));

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
