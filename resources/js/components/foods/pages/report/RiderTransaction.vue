<template>
    <div class="space-y-2">
        <module-header icon="md-bicycle" title="Rider Transaction" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-end items-center gap-2">
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
            <div class="flex justify-end items-center mb-4 mt-2 gap-2">
                <Button
                    type="primary"
                    icon="ios-paper-outline"
                    :disabled="!RiderTransaction.length"
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="!RiderTransaction.length"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center" id="section-to-print2">
                <span class="font-semibold text-lg block">
                    LIST OF RIDER(S) TRANSACTION
                </span>
                <span class="font-semibold block">SUMMARY REPORT</span>
                <span class="text-xs block">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>
                <div class="w-3/4 mt-2 border rounded">
                    <table class="min-w-full " id="rider_transaction_table">
                        <thead class="border-b tracking-normal">
                            <tr>
                                <th class=" p-2 text-left">Rider</th>
                                <th class=" p-2 text-center">
                                    No. of Transaction
                                </th>
                                <th class=" p-2 text-right">Fuel</th>
                                <th class=" p-2 text-right">
                                    Rider's Fee
                                </th>
                                <th class=" p-2 text-right">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-if="!RiderTransaction.length">
                                <td
                                    class="td text-center font-semibold"
                                    colspan="5"
                                >
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr v-for="(data, i) in RiderTransaction" :key="i">
                                <td class="td text-left">
                                    {{ data.riders_name }}
                                </td>
                                <td class="td text-center">
                                    {{ data.trans_num }}
                                </td>
                                <td class="td text-right">
                                    {{ data.fuel | toCurrency }}
                                </td>
                                <td class="td text-right">
                                    {{ data.riders_fee | toCurrency }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        (data.fuel + data.riders_fee)
                                            | toCurrency
                                    }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr
                                class=" font-semibold  "
                                v-if="RiderTransaction.length"
                            >
                                <td class=" p-2 text-center">
                                    GRAND TOTAL
                                </td>
                                <td class=" p-2 text-center">
                                    {{ totalRiderTransaction.total_trans }}
                                </td>
                                <td class=" p-2 text-right">
                                    {{
                                        totalRiderTransaction.fuel_amt
                                            | toCurrency
                                    }}
                                </td>
                                <td class=" p-2 text-right">
                                    {{
                                        totalRiderTransaction.riders_fee
                                            | toCurrency
                                    }}
                                </td>
                                <td class=" p-2 text-right">
                                    {{
                                        totalRiderTransaction.total_amt
                                            | toCurrency
                                    }}
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
import { mapState, mapActions, mapGetters } from "vuex";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    name: "RiderTransaction",
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
        ...mapState("Report", ["RiderTransaction"]),
        ...mapGetters("Report", ["totalRiderTransaction"])
    },
    methods: {
        ...mapActions("Report", ["getRiderTransaction"]),
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
            this.getRiderTransaction(payload);
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
            doc.text("LIST OF RIDER(S) TRANSACTION", 14, finalY + 14);

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
                        if (
                            data.column.dataKey == 2 ||
                            data.column.dataKey == 3 ||
                            data.column.dataKey == 4
                        ) {
                            data.cell.styles.halign = "right";
                        }
                    }
                    if (data.section === "foot") {
                        if (data.column.dataKey == 1) {
                            data.cell.styles.halign = "center";
                        }
                        if (
                            data.column.dataKey == 2 ||
                            data.column.dataKey == 3 ||
                            data.column.dataKey == 4
                        ) {
                            data.cell.styles.halign = "right";
                        }
                    }
                },
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#rider_transaction_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                columnStyles: {
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
                },
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));
        },
        toExcel(type, fn, dl) {
            let _from = moment(this.filter.dateFrom).format("MMM DD, YYYY");
            let _to = moment(this.filter.dateTo).format("MMM DD, YYYY");

            const xlsName = `RIDER-TRANSACTION-${_from}-${_to}.`;
            const elt = document.getElementById("rider_transaction_table");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "RIDER-TRANSACTION"
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
