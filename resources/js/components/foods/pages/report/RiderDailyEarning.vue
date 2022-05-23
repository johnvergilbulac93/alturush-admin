<template>
    <div class="space-y-2">
        <module-header icon="md-bicycle" title="Rider Daily Earning" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center">
                <div class="w-64">
                    <label class="block">Filter by Type:</label>
                    <Select
                        class="form"
                        v-model="filter.type"
                        @on-change="fetch"
                        placeholder="Select type"
                    >
                        <Option value="1">Detailed</Option>
                        <Option value="2">Summary</Option>
                    </Select>
                </div>

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
            </div>
            <hr />
            <div class="flex justify-end items-center gap-2">
                <Button
                    type="primary"
                    icon="ios-paper-outline"
                    :disabled="RiderDailyEarning.grandTotal == 0"
                    @click="toExcel('xlsx')"
                    >Excel</Button
                >
                <Button
                    type="primary"
                    icon="ios-print-outline"
                    @click="toPDF()"
                    :disabled="RiderDailyEarning.grandTotal == 0"
                    >Print</Button
                >
            </div>
            <div class="flex flex-col items-center">
                <span class="font-semibold text-lg block">
                    LIST OF RIDER(S) DAILY EARNING
                </span>
                <span v-if="filter.type == 1" class="font-semibold block"
                    >DETAILED REPORT</span
                >
                <span v-if="filter.type == 2" class="font-semibold block"
                    >SUMMARY REPORT</span
                >
                <span class="text-xs block">
                    AS OF: &nbsp; {{ filter.dateFrom | formatDateNoTime }} To
                    {{ filter.dateTo | formatDateNoTime }}.
                </span>

                <riderdetailed
                    :data_rider_earning="RiderDailyEarning"
                    v-if="filter.type == 1"
                />
                <ridersummary
                    :data_rider_earning="RiderDailyEarning"
                    v-if="filter.type == 2"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import riderdetailed from "./ExtendedComponent/RiderDailyEarningDetailed.vue";
import ridersummary from "./ExtendedComponent/RiderDailyEarningSummary.vue";

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
        ...mapState(["RiderDailyEarning"])
    },
    methods: {
        ...mapActions(["getRiderDailyEarning"]),
        fetch() {
            if (this.filter.dateFrom <= this.filter.dateTo) {
                let filter = {
                    dateFrom: moment(this.filter.dateFrom).format("YYYY-MM-DD"),
                    dateTo: moment(this.filter.dateTo).format("YYYY-MM-DD")
                };
                this.getRiderDailyEarning({ filter });
            } else {
                swal.fire("Invalid Date!", "Please check.", "error");
            }
        },
        toExcel(type, fn, dl) {
            const xlsName =
                "RIDER-DAILY-EARNING" +
                this.filter.dateFrom +
                "to" +
                this.filter.dateTo +
                ".";
            const elt = document.getElementById("rider_daily_earning_table");
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

<style></style>
