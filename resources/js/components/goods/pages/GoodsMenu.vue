<template>
    <div class="h-screen bg-white w-64 border border-gray-300 overflow-y-auto">
        <MainMenuHeader text="Goods Menu" />
        <div class="mt-10">
            <MenuItem text="Dashboard" icon="fas fa-tachometer-alt">
            </MenuItem>
            <MenuItem text="Setup" icon="fas fa-cog">
                <template #sub-menu>
                    <SubItem
                        text="Business Rules"
                        :route="{ name: 'business_rule' }"
                    />
                    <SubItem text="Store Time" />
                    <SubItem text="Tenant" />
                    <SubItem text="Delivery Charges" />
                    <SubItem text="Min. Order Delivery" />
                    <SubItem text="Manage Users" />
                    <SubItem text="Price Group" />
                </template>
            </MenuItem>

            <MenuItem text="Item" icon="fas fa-shopping-cart">
                <template #sub-menu>
                    <SubItem text="Item Masterfile" />
                    <SubItem text="Disable Item Unit of Measure(UOM)" />
                    <SubItem text="Enable Item Unit of Measure(UOM)" />
                </template>
            </MenuItem>
            <MenuItem text="Uploading" icon="fas fa-file-upload">
                <template #sub-menu>
                    <SubItem text="Upload New Item and Price Update" />
                    <SubItem text="Upload Image Filename and Category" />
                    <SubItem text="Upload Multiple Images" />
                    <SubItem text="Upload Item Description" />
                </template>
            </MenuItem>
            <MenuItem text="Reports" icon="fas fa-chart-line">
                <template #sub-menu>
                    <SubItem text="Item Report" />
                    <SubItem text="Liquidation" />
                    <SubItem text="Accountability" />
                    <SubItem text="Total Order - REMITTED" />
                    <SubItem
                        text="Special Instruction, Comments & Suggestions"
                    />
                </template>
            </MenuItem>
        </div>
    </div>
    <!-- <div class="flex gap-4 sm:flex-col lg:flex-row ">
        <SubMenu />
        <div class="lg:w-3/4 md:w-1/2  bg-gray-50 shadow-lg p-5 rounded">
            <div class="sm:w-full lg:w-3/4 xl:w-1/4 ">
                <div
                    class="bg-gray-100 h-40 flex flex-col justify-between items-center w-full rounded border shadow-lg"
                >
                    <div class="mt-5 text-gray-800 ">
                        <span>Today's Price Changed.</span>
                        <h3 class="text-7xl text-center">
                            {{ priceCount }}
                        </h3>
                    </div>
                    <a
                        @click="showModalPrice"
                        class="bg-blue-500 text-center py-2 text-white w-full hover:text-white hover:bg-blue-600 transition duration-500    "
                    >
                        <span class="">More info</span>
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="border-t mt-5 w-full">
                <div class="w-1/2 flex items-center gap-2 ">
                    <div class="mt-2 w-20 ">
                        <label for="">Select Year</label>
                        <Datepicker
                            input-class="form w-full"
                            :initialView="'year'"
                            :minimumView="'year'"
                            :maximumView="'year'"
                            format="yyyy"
                            v-model="filter.year"
                            @selected="selected()"
                        />
                    </div>
                    <div class="mt-2 w-44">
                        <label for="">Select Month</label>
                        <Datepicker
                            input-class="form w-full"
                            :disabled="filter.flag ? true : false"
                            :initialView="'month'"
                            :minimumView="'month'"
                            :maximumView="'month'"
                            format="MMMM"
                            v-model="filter.month"
                            @selected="selected()"
                        />
                    </div>
                    <div class="mt-2">
                        <div class="mt-4">
                            <input
                                type="checkbox"
                                v-model="filter.flag"
                                @change="selected()"
                                class="w-5 h-5 text-yellow-500 focus:ring-yellow-500 border-gray-300 cursor-pointer "
                            />
                            <label for="">Year Only</label>
                        </div>
                    </div>
                </div>

                <div class="w-full flex justify-center items-center">
                    <h2 v-if="!arrayResult.length" class="text-lg">
                        NO DATA AVAILABLE
                    </h2>
                    <ChartTopItem
                        :data="TopItemData"
                        :labels="TopItemLabels"
                        :year="filter.year"
                        :month="filter.month"
                        :flag="filter.flag"
                        clear-button="true"
                        class="w-full"
                        v-else
                    >
                    </ChartTopItem>
                </div>
            </div>
            <div class="border-t mt-5 w-full">
                <div class="w-full">
                    <ChartData
                        refs="skills_chart"
                        :data="ItemNotAvailableData"
                        :labels="ItemNotAvailableLabels"
                    >
                    </ChartData>
                </div>
            </div>

            <transition
                enter-active-class=" ease-in-out transition duration-500"
                enter-class="transform -translate-y-11 opacity-0 "
                enter-to-class="opacity-100"
                leave-active-class="ease-in-out transition duration-500"
                leave-class=" opacity-100"
                leave-to-class="transform -translate-y-11 opacity-0"
            >
                <div
                    v-if="isModal"
                    class=" fixed top-0 left-0 z-50 flex justify-center items-center shadow-xl p-20 w-full min-h-screen"
                >
                    <div
                        class="bg-white md:w-full sm:max-w-full border border-gray-400 rounded text-gray-800 shadow-lg"
                    >
                        <div
                            class="border-b-2 p-3 flex justify-between items-center"
                        >
                            <span class="font-semibold text-lg"
                                >Today's Price Changed</span
                            >
                            <a @click="closeModal">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-gray-500 hover:text-red-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </a>
                        </div>
                        <InfoPrice></InfoPrice>
                    </div>
                </div>
            </transition>
        </div>
    </div> -->
</template>

<script>
import Datepicker from "vuejs-datepicker";
import SubMenu from "./Sub-Menu.vue";
import InfoPrice from "./Info-Price-History.vue";
import { mapActions, mapState } from "vuex";
import ChartData from "./ChartData.vue";
import ChartTopItem from "./TopItemChart.vue";
export default {
    components: {
        InfoPrice,
        ChartData,
        SubMenu,
        ChartTopItem,
        Datepicker
    },
    data() {
        return {
            arrayResult: [],
            ItemNotAvailableData: [],
            ItemNotAvailableLabels: [],
            TopItemData: [],
            TopItemLabels: [],
            filter: {
                year: null,
                month: null,
                flag: false
            }
        };
    },
    computed: {
        ...mapState(["isModal", "priceCount"])
    },
    methods: {
        ...mapActions(["modal", "getPriceChanged"]),
        selected() {
            this.$nextTick(() => {
                this.getTopItems();
            });
        },
        showModalPrice() {
            this.modal({
                flag: true
            });
        },
        closeModal() {
            this.modal({
                flag: false
            });
        },
        async getItems(url = "/api/chart/not_available_item") {
            let self = this;

            const { data } = await axios.get(url);

            let result = data;
            result.forEach(bu => {
                self.ItemNotAvailableLabels.push(bu.business_unit);
                self.ItemNotAvailableData.push(bu.store);
            });
        },
        async getTopItems(url = "/api/chart/top_items") {
            let year = moment(this.filter.year).format("YYYY-MM-DD");
            let month = moment(this.filter.month).format("YYYY-M-DD");

            let filter = {
                year: year,
                month: month,
                flag: this.filter.flag
            };

            const { data } = await axios.get(url, { params: filter });
            this.arrayResult = data;
            let result = data;
            this.TopItemData = [];
            this.TopItemLabels = [];
            result.forEach(item => {
                this.TopItemLabels.push(
                    item.product_name + "(" + item.UOM + ")"
                );
                this.TopItemData.push(item.sales);
            });
        }
    },
    beforeMount() {
        this.filter.year = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
        this.filter.month = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
    },
    mounted() {
        this.getPriceChanged();
        this.getItems();
        this.getTopItems();
    }
};
</script>
