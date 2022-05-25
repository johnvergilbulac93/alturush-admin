<template>
    <div class="space-y-2">
        <module-header icon="md-analytics" title="Total Order - Remitted" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center gap-2">
                <div class="w-1/2  flex justify-start item-center gap-2">
                    <div class="w-1/2">
                        <label class="block">Filter By Report Type</label>
                        <Select
                            placeholder="Choose Report Type"
                            v-model="filter.type"
                            clearable
                            @on-change="generate()"
                        >
                            <Option value="DETAILED">DETAILED</Option>
                            <Option value="SUMMARY">SUMMARY</Option>
                        </Select>
                    </div>
                    <div class="w-1/2">
                        <label class="block">Filter By Store</label>
                        <Select
                            placeholder="Choose a store"
                            v-model="filter.store"
                            clearable
                            @on-change="generate()"
                        >
                            <Option value="all">ALL STORE</Option>
                            <Option
                                :value="store.bunit_code"
                                v-for="store in Stores"
                                :key="store.bunit_code"
                                >{{ store.business_unit }}</Option
                            >
                        </Select>
                    </div>
                </div>
                <div class="w-1/2 flex justify-end items-center gap-2 ">
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
                        <label class="block">Filter By Date To</label>
                        <DatePicker
                            @on-change="generate()"
                            v-model="filter.dateTo"
                            type="date"
                            placeholder="Date to"
                        />
                    </div>
                </div>
            </div>
            <hr />
            <div class="w-full flex justify-end items-center gap-2">
                <Button
                    type="primary"
                    icon="ios-paper-outline"
                    @click="toExcel('xlsx')"
                    :disabled="!Transactions.data"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="!Transactions.data"
                >
                    Print
                </Button>
            </div>
            <DetailedTransactions
                v-if="filter.type === 'DETAILED'"
                :filter="filter"
            />
            <SummaryTransactions
                v-if="filter.type === 'SUMMARY'"
                :filter="filter"
            />
        </div>
    </div>
</template>

<script>
import DetailedTransactions from "./ExtendedComponent/DetailedTransaction.vue";
import SummaryTransactions from "./ExtendedComponent/SummaryTransaction.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "DETAILED-REPORT",
    components: { DetailedTransactions, SummaryTransactions },
    data() {
        return {
            ArrDataStore: [],
            stores: [],
            loading: false,
            filter: {
                dateFrom: null,
                dateNow: null,
                dateTo: null,
                store: "",
                type: ""
            }
        };
    },
    computed: {
        ...mapState(["Stores"]),
        ...mapState("Report", ["Transactions"])
    },
    methods: {
        ...mapActions("Report", ["getTransactions"]),
        ...mapActions(["getStore"]),
        ...mapMutations("Report", ["CLEAR_TRANSACTIONS"]),
        toPDF() {
            if (!this.Transactions.data.length) {
                this.$Message.error({
                    background: true,
                    content: "No records found"
                });
                return;
            }
            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");
            let store = "";
            let column = null;

            if (this.filter.type === "SUMMARY") {
                column = {
                    1: {
                        halign: "center"
                    },
                    2: {
                        halign: "right"
                    },
                    3: {
                        halign: "right"
                    },
                    4: {
                        halign: "right"
                    }
                };
            } else {
                column = {
                    2: {
                        halign: "center"
                    },
                    3: {
                        halign: "right"
                    },
                    4: {
                        halign: "right"
                    },
                    5: {
                        halign: "right"
                    }
                };
            }

            if (this.filter.store === "all") {
                store = "ALL STORES";
            } else {
                store = this.Transactions.b_unit.business_unit;
            }
            const doc = new jsPDF({
                orientation: "p",
                unit: "mm",
                format: "letter",
                putOnlyUsedFonts: true
            });
            var finalY = doc.lastAutoTable.finalY || 0;
            doc.setFontSize(10);
            doc.setTextColor("#4b5563");
            doc.text(store, 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("ALTURUSH GOODS ORDERING", 14, finalY + 18);
            doc.text("TOTAL ORDER -REMITTED REPORT", 14, finalY + 22);
            doc.text(`${_from} to ${_to}`, 14, finalY + 26);
            doc.autoTable({
                didDrawPage: data => {
                    var str = "Page " + doc.internal.getNumberOfPages();
                    var runtime = "Run Time: " + this.filter.dateNow;

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
                    if (data.row.raw[0]._element.id === "idHeader") {
                        data.cell.styles.fontStyle = "bold";
                        data.cell.styles.fillColor = "#f5f6f8";
                    }
                    if (data.row.raw._element.id === "idSubTotal") {
                        data.cell.styles.fontStyle = "bold";
                    }
                    if (this.filter.type === "SUMMARY") {
                        if (data.section === "head") {
                            if (
                                data.column.dataKey == 2 ||
                                data.column.dataKey == 3 ||
                                data.column.dataKey == 4
                            ) {
                                data.cell.styles.halign = "right";
                            }
                            if (data.column.dataKey == 1) {
                                data.cell.styles.halign = "center";
                            }
                        }
                        if (data.section === "foot") {
                            if (
                                data.column.dataKey == 2 ||
                                data.column.dataKey == 3 ||
                                data.column.dataKey == 4
                            ) {
                                data.cell.styles.halign = "right";
                            }
                            if (data.column.dataKey == 1) {
                                data.cell.styles.halign = "center";
                            }
                        }
                    } else {
                        if (data.section === "head") {
                            if (
                                data.column.dataKey == 3 ||
                                data.column.dataKey == 4 ||
                                data.column.dataKey == 5
                            ) {
                                data.cell.styles.halign = "right";
                            }
                            if (data.column.dataKey == 2) {
                                data.cell.styles.halign = "center";
                            }
                        }
                        if (data.section === "foot") {
                            if (
                                data.column.dataKey == 3 ||
                                data.column.dataKey == 4 ||
                                data.column.dataKey == 5
                            ) {
                                data.cell.styles.halign = "right";
                            }
                            if (data.column.dataKey == 2) {
                                data.cell.styles.halign = "center";
                            }
                        }
                    }
                },
                startY: finalY + 28,
                styles: { overflow: "linebreak" },
                html: "#transactions_table",
                theme: "grid",
                styles: { fontSize: 6 },
                columnStyles: column,
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));
        },
        toExcel(type, fn, dl) {
            if (!this.Transactions.data.length) {
                this.$Message.error({
                    background: true,
                    content: "No records found"
                });
                return;
            }
            let _from = moment(this.filter.dateFrom).format("YYYY-MM-DD");
            let _to = moment(this.filter.dateTo).format("YYYY-MM-DD");
            let xlsName = "";
            if (this.filter.store === "all") {
                xlsName = `TRANSACTIONS-ALL-STORES from ${_from} to ${_to}.`;
            } else {
                xlsName = `TRANSACTIONS - ${this.Transactions.b_unit.business_unit} from ${_from} to ${_to}.`;
            }

            const elt = document.getElementById("transactions_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: this.filter.type
            });
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
                type: this.filter.type,
                store: this.filter.store,
                startDate: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                endDate: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };
            this.getTransactions(payload);
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
        this.filter.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    },
    destroyed() {
        this.CLEAR_TRANSACTIONS();
    }
};
</script>
