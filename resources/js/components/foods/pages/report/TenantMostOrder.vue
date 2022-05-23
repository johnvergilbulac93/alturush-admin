<template>
    <div class="space-y-2">
        <module-header icon="md-basket" title="Tenant Most Order" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center gap-2">
                <div class="w-1/2 flex gap-2">
                    <div class="w-1/2">
                        <label class="block">Filter by Global Category:</label>
                        <Select v-model="filter.category" @on-change="fetch">
                            <Option
                                v-for="(data, i) in GlobalCategory"
                                :key="i"
                                :value="data.id"
                                >{{ data.category }}</Option
                            >
                        </Select>
                    </div>
                    <div class="w-1/2">
                        <label class="block">Filter by Store:</label>
                        <Select v-model="filter.store" @on-change="fetch">
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
                </div>
                <div class="w-1/2 flex justify-end gap-2">
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
                    :disabled="checkOrder == 0"
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="checkOrder == 0"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center">
                <span
                    class="font-semibold text-lg block "
                    v-if="filter.category != 2"
                >
                    LIST OF TENANT MOST ORDER
                </span>
                <span class="font-semibold text-lg block" v-else>
                    STORE ORDER LIST
                </span>
                <span class="font-semibold block">SUMMARY REPORT</span>
                <span class="text-xs block">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>
                <div class="w-3/4 mt-2 border rounded">
                    <tblTenantMostOrder v-if="filter.category != 2" />
                    <tblTenantMostOrderGoods v-if="filter.category == 2" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import tblTenantMostOrder from "./ExtendedComponent/TblTenantMostOrder.vue";
import tblTenantMostOrderGoods from "./ExtendedComponent/TblTenantMostOrderGoods.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "TenantMostOrder",
    components: { tblTenantMostOrder, tblTenantMostOrderGoods },
    data() {
        return {
            filter: {
                category: 1,
                store: "all",
                dateFrom: "",
                dateTo: ""
            },
            dateNow: ""
        };
    },
    computed: {
        ...mapState(["Stores", "GlobalCategory"]),
        ...mapState('Report',["TenantMostOrder"]),

        checkOrder() {
            let charge = 0;
            this.TenantMostOrder.forEach(d => {
                charge += parseFloat(d.total_sales);
            });
            return charge;
        }
    },
    methods: {
        ...mapActions(["getStore", "getGlobalCategory"]),
        ...mapActions("Report", ["getTenantMostOrder"]),

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
                store: this.filter.store,
                dateFrom: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                dateTo: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };
            this.getTenantMostOrder(payload);
        },
        toExcel(type, fn, dl) {
            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");
            const xlsName = `TENANT-MOST-ORDER-${_from}-${_to}.`;
            const elt = document.getElementById("tenant_most_order_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "TENANT MOST ORDER"
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
            doc.text(
                this.filter.category != 2
                    ? "LIST OF TOWN MOST ORDER"
                    : "STORE ORDER LIST",
                14,
                finalY + 14
            );

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
                        if (data.column.dataKey == 2) {
                            data.cell.styles.halign = "center";
                        }
                        if (data.column.dataKey == 3) {
                            data.cell.styles.halign = "right";
                        }
                        if (data.column.dataKey == 4) {
                            data.cell.styles.halign = "right";
                        }
                    }
                    if (data.section === "foot") {
                        if (data.column.dataKey == 2) {
                            data.cell.styles.halign = "center";
                        }
                        if (data.column.dataKey == 3) {
                            data.cell.styles.halign = "right";
                        }
                        if (data.column.dataKey == 4) {
                            data.cell.styles.halign = "right";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#tenant_most_order_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
                    2: {
                        halign: "center"
                    },
                    3: {
                        halign: "right"
                    },
                    4: {
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
        this.getStore();
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
