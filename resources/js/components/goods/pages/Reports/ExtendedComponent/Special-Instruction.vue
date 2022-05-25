<template>
    <div class="border p-2 space-y-2">
        <div class="flex justify-between items-center gap-2">
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
        </div>
        <hr />
        <div class="flex items-center gap-2 justify-end">
            <Button
                type="primary"
                icon="ios-paper-outline"
                @click="toExcel('xlsx')"
                :disabled="!Instructions.data"
                >Excel</Button
            >
            <Button
                type="primary"
                icon="ios-print-outline"
                @click="toPDF()"
                :disabled="!Instructions.data"
                >Print</Button
            >
        </div>
        <section v-if="Instructions.b_unit != null">
            <div class="flex justify-center items-center mb-2">
                <center>
                    <h6 class="text-lg ">
                        {{
                            Instructions.hasOwnProperty("b_unit") &&
                                Instructions.b_unit.business_unit
                        }}
                    </h6>
                    <p>ALTURUSH GOODS ORDERING</p>
                    <p>SPECIAL INSTRUCTION REPORT</p>
                </center>
            </div>
            <table
                class="min-w-full divide-y divide-gray-300"
                id="instruction_table"
            >
                <thead class="border bg-gray-100 tracking-normal">
                    <tr class="tracking-wide">
                        <th class="p-3 border text-left text-lg bg-gray-200">
                            Remarks
                        </th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <tr class="tr" v-if="!Instructions.data.length">
                        <td class="td">NO AVAILABLE DATA</td>
                    </tr>
                    <tr
                        v-for="(instruction, i) in Instructions.data"
                        :key="i"
                        class="tr"
                    >
                        <td class="td">
                            <li class="list-disc">
                                {{ instruction.remarks }}
                            </li>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import jsPDF from "jspdf";
import "jspdf-autotable";
export default {
    props: ["stores"],
    data() {
        return {
            filter: {
                store: "",
                dateNow: ""
            }
        };
    },
    computed: {
        ...mapState("Report", ["Instructions"])
    },
    methods: {
        ...mapActions("Report", ["getInstruction"]),
        ...mapMutations("Report", ["CLEAR_INSTRUCTIONS"]),
        toPDF() {
            if (this.filter.store === "") {
                this.$Message.error({
                    background: true,
                    content: "Please select a store."
                });
                return;
            }
            if (!this.Instructions.data.length) {
                this.$Message.error({
                    background: true,
                    content: "No records found."
                });
                return;
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
            doc.text(this.Instructions.b_unit.business_unit, 14, finalY + 14);

            doc.setFontSize(8);
            doc.setTextColor("#4b5563");
            doc.text("ALTURUSH GOODS ORDERING", 14, finalY + 18);
            doc.text("SPECIAL INSTRUCTION REPORT", 14, finalY + 22);
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
                startY: finalY + 24,
                styles: { overflow: "linebreak" },
                html: "#instruction_table",
                theme: "grid",
                styles: { fontSize: 6 },
                headStyles: { font: "helvetica" },
                showHead: "everyPage",
                showFoot: "lastPage"
            });
            window.open(doc.output("bloburl"));
        },
        toExcel(type, fn, dl) {
            if (this.filter.store === "") {
                this.$Message.error({
                    background: true,
                    content: "Please select a store."
                });
                return;
            }
            const xlsName =
                "SPECIAL-INSTRUCTION-" +
                this.Instructions.b_unit.business_unit +
                ".";
            const elt = document.getElementById("instruction_table");
            const wb = XLSX.utils.table_to_book(elt, { sheet: "REMARKS" });
            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64"
                  })
                : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
        },
        generate: _.debounce(function() {
            this.getInstruction({ store: this.filter.store });
        }, 500)
    },
    mounted() {
        this.filter.dateNow = moment(this.$root.serverDateTime).format("LLLL");
    }
    // destroyed() {
    //     this.CLEAR_INSTRUCTIONS();
    // }
};
</script>
