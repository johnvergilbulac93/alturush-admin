<template>
    <div class="space-y-2 ">
        <module-header icon="md-analytics" title="Liquidation Report" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between  gap-2">
                <div class="w-1/4">
                    <label class="block">Filter By Store</label>
                    <Select
                        placeholder="Choose a store"
                        v-model="filter.store"
                        clearable
                        @on-change="generate()"
                    >
                        <Option
                            :value="store.bunit_code"
                            v-for="store in Stores"
                            :key="store.bunit_code"
                            >{{ store.business_unit }}</Option
                        >
                    </Select>
                </div>
                <div class="w-3/4">
                    <div class="flex justify-end gap-2 items-center">
                        <div class="w-auto">
                            <label class="block">Filter By Date From</label>
                            <DatePicker
                                @on-change="generate()"
                                v-model="filter.dateFrom"
                                type="date"
                                placeholder="Date from"
                            />
                        </div>
                        <div class="w-auto">
                            <label class="block">Filter by Date To:</label>
                            <DatePicker
                                @on-change="generate()"
                                v-model="filter.dateTo"
                                type="date"
                                placeholder="Date to"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="w-full flex justify-end items-center gap-2 ">
                <Button
                    type="success"
                    icon="ios-paper-outline"
                    :disabled="!Liquidation.cashier_details"
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button
                    type="success"
                    icon="ios-print-outline"
                    :disabled="!Liquidation.cashier_details"
                    @click="toPDF()"
                >
                    Print
                </Button>
            </div>
            <view-liquidation
                v-if="Liquidation.b_unit != null"
                :Liquidation="Liquidation"
                :dateFrom="filter.dateFrom"
                :dateTo="filter.dateTo"
                :dateNow="dateNow"
            />
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from "vuex";
import ViewLiquidation from "./ExtendedComponent/ViewLiquidation.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    name: "Liquidation-Report",
    components: { ViewLiquidation },
    data() {
        return {
            dateNow: null,
            filter: {
                dateFrom: "",
                dateTo: "",
                store: ""
            },
            loading: true
        };
    },
    computed: {
        ...mapState(["errors", "Stores"]),
        ...mapState("Report", ["Liquidation"]),
        ...mapGetters("Report", ["totalOrderAmount"])
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapActions("Report", ["getLiquidation"]),
        ...mapMutations("Report", ["CLEAR_LIQUIDATION"]),

        toPDF() {
            if (!this.Liquidation.cashier_details.length) {
                this.$Message.error({
                    background: true,
                    content: "No records found."
                });
                return;
            }
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
            doc.text(this.Liquidation.b_unit.business_unit, 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("ALTURUSH GOODS ORDERING", 14, finalY + 18);
            doc.text("LIQUIDATION REPORT", 14, finalY + 22);
            doc.text(`${_from} to ${_to}`, 14, finalY + 26);
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
                            data.column.dataKey == 2 ||
                            data.column.dataKey == 4
                        ) {
                            data.cell.styles.halign = "center";
                        }
                        if (
                            data.column.dataKey == 5 ||
                            data.column.dataKey == 6 ||
                            data.column.dataKey == 7 ||
                            data.column.dataKey == 8 ||
                            data.column.dataKey == 9
                        ) {
                            data.cell.styles.halign = "right";
                        }
                    }
                    if (data.section === "foot") {
                        if (data.column.dataKey == 4) {
                            data.cell.styles.halign = "center";
                        }
                        if (
                            data.column.dataKey == 5 ||
                            data.column.dataKey == 6 ||
                            data.column.dataKey == 7 ||
                            data.column.dataKey == 8 ||
                            data.column.dataKey == 9
                        ) {
                            data.cell.styles.halign = "right";
                        }
                    }
                },
                startY: finalY + 28,
                styles: { overflow: "linebreak" },
                html: "#liquidation_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    1: {
                        halign: "center"
                    },
                    2: {
                        halign: "center"
                    },
                    4: {
                        halign: "center"
                    },
                    5: {
                        halign: "right"
                    },
                    6: {
                        halign: "right"
                    },
                    7: {
                        halign: "right"
                    },
                    8: {
                        halign: "right"
                    },
                    9: {
                        halign: "right"
                    }
                },
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));
        },
        toExcel(type, fn, dl) {
            let _from = moment(this.filter.dateFrom).format("YYYY-MM-DD");
            let _to = moment(this.filter.dateTo).format("YYYY-MM-DD");

            if (!this.Liquidation.cashier_details.length) {
                this.$Message.error({
                    background: true,
                    content: "No records found."
                });
                return;
            }
            const xlsName = `${this.Liquidation.b_unit.acroname}-liquidation-${_from}-${_to}.`;
            console.log(xlsName);
            const elt = document.getElementById("liquidation_table");
            const wb = XLSX.utils.table_to_book(elt, { sheet: "LIQUIDATION" });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        generate: _.debounce(function() {
            let payload = {
                store: this.filter.store,
                startDate: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                endDate: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };
            if (this.filter.dateFrom > this.filter.dateTo) {
                this.$Message.error({
                    background: true,
                    content: "Invalid date!"
                });
                return;
            } else {
                this.getLiquidation(payload);
            }
        }, 500)
    },
    mounted() {
        this.getStore();
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    },
    destroyed() {
        this.CLEAR_LIQUIDATION();
    }
};
</script>
