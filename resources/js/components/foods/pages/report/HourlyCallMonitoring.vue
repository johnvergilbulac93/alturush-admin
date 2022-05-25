<template>
    <div class="space-y-2">
        <module-header
            icon="ios-clock-outline"
            title="Hourly Call Monitoring"
        />
        <div class="border p-2 space-y-2">
            <div class="flex justify-end items-center gap-2">
                <div class="w-64">
                    <label class="block">Filter by Store:</label>
                    <Select
                        v-model="filter.store"
                        @on-change="fetch"
                        placeholder="Select type"
                    >
                        <Option value="all">ALL STORES</Option>
                        <Option
                            v-for="(store, i) in Stores"
                            :value="store.bunit_code"
                            :key="i"
                        >
                            {{ store.business_unit }}
                        </Option>
                    </Select>
                </div>
                <div class="w-auto">
                    <label class="block">Filter by Date</label>
                    <DatePicker
                        @on-change="fetch"
                        v-model="filter.dateNow"
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
                    :disabled="totalHourlyCallMonitoring.total == 0"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="totalHourlyCallMonitoring.total == 0"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center">
                <span class="font-semibold text-lg ">
                    HOURLY CALL MONITORING
                </span>
                <span class="font-semibold ">
                    SUMMARY REPORT
                </span>
                <span class="text-xs">
                    AS OF: &nbsp; {{ filter.dateNow | formatDateNoTime }}
                </span>
                <TblHourlyCallMonitoring />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
import TblHourlyCallMonitoring from "./ExtendedComponent/TblHourlyCallMonitoring.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "HourlyCallMonitoring",
    components: { TblHourlyCallMonitoring },
    data() {
        return {
            filter: {
                dateNow: "",
                store: "all"
            }
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
                date: moment(this.filter.dateNow).format("YYYY-MM-DD"),
                store: this.filter.store
            };
            this.getHourlyCallMonitoring({ filter });
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
            doc.text("HOURLY CALL MONITORING", 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("SUMMARY REPORT", 14, finalY + 18);
            doc.text(`${_from} to ${_to}`, 14, finalY + 22);
            doc.autoTable({
                didDrawPage: data => {
                    console.log(data);
                    var str = "Page " + doc.internal.getNumberOfPages();
                    var runtime = "Run Time: " + moment(this.$root.serverDateTime).format("LLLL");

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
                html: "#hourly_call_monitoring_table",
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
            let _now = moment(this.filter.dateNow).format("MMM DD, YYYY");
            const xlsName = `HOURLY-CALL-MONITORING-${_now}.`;
            const elt = document.getElementById("hourly_call_monitoring_table");
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
