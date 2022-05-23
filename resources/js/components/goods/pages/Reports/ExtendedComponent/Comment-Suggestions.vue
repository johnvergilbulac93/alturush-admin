<template>
    <div class="border p-2 space-y-2 ">
        <div class="flex justify-between items-center  ">
            <div class="w-1/4">
                <label class="block">Filter By Store</label>
                <Select
                    class="form"
                    v-model="filter.store"
                    placeholder="Choose a store"
                    @on-change="generate()"
                >
                    <Option
                        :value="store.bunit_code"
                        v-for="(store, i) in stores"
                        :key="i"
                        >{{ store.business_unit }}</Option
                    >
                </Select>
            </div>
            <div class="w-3/4 flex justify-end items-center gap-2">
                <div class="w-auto">
                    <label class="block">Filter By Date From</label>
                    <DatePicker
                        @on-change="generate()"
                        v-model="filter.dateFrom"
                        type="date"
                        placeholder="Date from"
                    ></DatePicker>
                </div>
                <div class="w-auto">
                    <label class="block">Filter By Date To</label>
                    <DatePicker
                        @on-change="generate()"
                        v-model="filter.dateTo"
                        type="date"
                        placeholder="Date from"
                    ></DatePicker>
                </div>
            </div>
        </div>
        <hr />
        <div class="w-full flex justify-end items-center gap-2  ">
            <Button
                type="success"
                icon="ios-paper-outline"
                @click="toExcel('xlsx')"
                :disabled="!Unfounds.data"
                >Excel</Button
            >
            <Button
                type="success"
                icon="ios-print-outline"
                @click="toPDF()"
                :disabled="!Unfounds.data"
                >Print</Button
            >
        </div>
        <section v-if="Unfounds.b_unit != null">
            <div class="flex justify-center items-center mb-2">
                <center>
                    <h2 class="text-lg">
                        {{
                            Unfounds.hasOwnProperty("b_unit") &&
                                Unfounds.b_unit.business_unit
                        }}
                    </h2>
                    <p>ALTURUSH GOODS ORDERING</p>
                    <p>Comments & Suggestions</p>
                    <p>
                        {{ filter.dateFrom | formatDateNoTime }} to
                        {{ filter.dateTo | formatDateNoTime }}
                    </p>
                </center>
            </div>
            <div class="border rounded">
                <table class="min-w-full " id="unfound_items">
                    <thead class="border-b tracking-normal">
                        <tr class="tracking-wide">
                            <th class="p-3 text-left w-44">
                                Ticket No.
                            </th>
                            <th class="p-3 boder text-left w-64">
                                Customer Name
                            </th>
                            <th class="p-3 text-left w-44">
                                Order From
                            </th>
                            <th class="p-3 text-left w-44">
                                Mode of Order
                            </th>
                            <th class="p-3 text-left">
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr class="tr" v-if="!Unfounds.data.length">
                            <td
                                class="td text-center font-semibold"
                                colspan="5"
                            >
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(unfound, i) in Unfounds.data"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">{{ unfound.ticket }}</td>
                            <td class="td">{{ unfound.customer }}</td>
                            <td class="td">{{ unfound.source }}</td>
                            <td class="td">
                                {{
                                    unfound.mode_of_order == 1
                                        ? "Pick-up"
                                        : "Delivery"
                                }}
                            </td>
                            <td class="td">
                                <li class="list-disc">
                                    {{ unfound.remarks }}
                                </li>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState, mapGetters } from "vuex";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    props: ["stores"],
    data() {
        return {
            filter: {
                store: "",
                dateFrom: "",
                dateTo: "",
                dateNow: ""
            }
        };
    },
    computed: {
        ...mapState("Report", ["Unfounds"]),
        ...mapGetters("Report", ["checkUnfounds"])
    },
    methods: {
        ...mapActions("Report", ["getUnfound"]),
        ...mapMutations("Report", ["CLEAR_UNFOUNDS"]),

        toPDF() {
            if (!this.Unfounds.data.length) {
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
            doc.text(this.Unfounds.b_unit.business_unit, 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("ALTURUSH GOODS ORDERING", 14, finalY + 18);
            doc.text("Comments & Suggestions", 14, finalY + 22);
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
                startY: finalY + 28,
                styles: { overflow: "linebreak" },
                html: "#unfound_items",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));
        },
        toExcel(type, fn, dl) {
            if (!this.Unfounds.data.length) {
                this.$Message.error({
                    background: true,
                    content: "No records found."
                });
                return;
            }
            const xlsName =
                "COMMENTS-AND-SUGGESTIONS-" +
                this.Unfounds.b_unit.business_unit +
                ".";
            const elt = document.getElementById("unfound_items");
            const wb = XLSX.utils.table_to_book(elt, {
                sheet: "COMMENTS & SUGGESTIONS"
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
                store: this.filter.store,
                start: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                end: moment(this.filter.dateTo).format("YYYY-MM-DD")
            };

            if (this.filter.dateFrom > this.filter.dateTo) {
                this.$Message.error({
                    background: true,
                    content: "Invalid date!"
                });
                return;
            } else {
                this.getUnfound(payload);
            }
        }, 500)
    },
    mounted() {
        this.filter.dateFrom = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateTo = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
    // destroyed() {
    //     this.CLEAR_UNFOUNDS();
    // }
};
</script>
