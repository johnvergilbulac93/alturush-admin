<template>
    <div class="space-y-2">
        <module-header icon="ios-podium-outline" title="Alturush Commission" />
        <div class="border space-y-2 p-2">
            <div class="flex justify-between items-center gap-2">
                <div class="w-1/2 flex justify-start items-center gap-2  ">
                    <div class="w-1/2">
                        <label class="block">Filter by Category</label>
                        <Select
                            v-model="filter.category"
                            @on-change="fetch"
                            placeholder="Select category"
                        >
                            <Option value="0">Food, etc...</Option>
                            <Option value="1">Grocery</Option>
                        </Select>
                    </div>
                    <div class="w-1/2">
                        <label class="block">Filter by Platform Use</label>

                        <Select
                            v-model="filter.platform"
                            @on-change="fetch"
                            placeholder="Select platform"
                        >
                            <Option value="all">All Platform</Option>
                            <Option value="1">Tele-Ordering</Option>
                            <Option value="2">Mobile-Application</Option>
                            <Option value="3">Web-Application</Option>
                        </Select>
                    </div>
                </div>
                <div class="w-1/2 flex justify-end items-center gap-2">
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
                    :disabled="!Commission.length"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="!Commission.length"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center">
                <span class="font-semibold text-lg ">
                    ALTURUSH COMMISSION
                </span>
                <span class="font-semibold ">SUMMARY REPORT</span>
                <span class="text-xs">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>

                <tblAlturushCommission />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
import tblAlturushCommission from "./ExtendedComponent/TblAlturushCommission.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "AlturushCommission",
    components: { tblAlturushCommission },
    data() {
        return {
            filter: {
                dateFrom: "",
                dateTo: "",
                category: "0",
                platform: "all"
            },
            dateNow: ""
        };
    },
    computed: {
        ...mapState("Report", ["Commission"]),
        ...mapGetters("Report", ["totalCommission"])
    },
    methods: {
        ...mapActions("Report", ["getCommission"]),
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
                platform: this.filter.platform,
                dateFrom: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                dateTo: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };
            this.getCommission(payload);
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
            doc.text("ALTURUSH COMMISSION", 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("SUMMARY REPORT", 14, finalY + 18);
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
                            data.column.dataKey == 0 ||
                            data.column.dataKey == 1 ||
                            data.column.dataKey == 2 ||
                            data.column.dataKey == 3
                        ) {
                            data.cell.styles.halign = "center";
                        }
                        if (
                            data.column.dataKey == 5 ||
                            data.column.dataKey == 6
                        ) {
                            data.cell.styles.halign = "right";
                        }
                    }
                    if (data.section === "foot") {
                        if (data.column.dataKey == 0) {
                            data.cell.styles.halign = "center";
                        }
                        if (
                            data.column.dataKey == 5 ||
                            data.column.dataKey == 6
                        ) {
                            data.cell.styles.halign = "right";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#commission_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    0: {
                        halign: "center"
                    },
                    1: {
                        halign: "center"
                    },
                    2: {
                        halign: "center"
                    },
                    3: {
                        halign: "center"
                    },
                    5: {
                        halign: "right"
                    },
                    6: {
                        halign: "right"
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

            const xlsName = `ALTURUSH-COMMISSION"-${_from}-${_to}.`;
            const elt = document.getElementById("commission_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "ALTURUSH COMMISSION"
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
        this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
};
</script>
