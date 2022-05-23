<template>
    <div class=" space-y-2 border">
        <div class="text-gray-800 overflow-x-auto">
            <div class="mb-2 bg-gray-100 p-2">
                <label for="" class="font-semibold text-lg ">Item Report</label>
            </div>
            <div class="p-2">
                <div class="flex justify-center item ">
                    <div class="w-1/4 p-5 space-y-5 border">
                        <div class="w-full">
                            <select
                                class="form"
                                v-model="filter.type"
                                @change="changestore"
                            >
                                <option value="">Choose Filter</option>
                                <option value="all">All Items</option>
                                <option value="available"
                                    >Available Items</option
                                >
                                <option value="unavailable"
                                    >Unavailable Items</option
                                >
                            </select>
                            <p
                                class="text-red-500 text-center text-sm block"
                                v-if="errors.type"
                            >
                                <small>{{ errors.type[0] }}</small>
                            </p>
                        </div>
                        <div class="w-full">
                            <button
                                class="w-full px-4 py-2 h-10 bg-blue-500 focus:outline-none hover:bg-blue-600 text-white  transition duration-500 rounded"
                                @click="generate"
                            >
                                {{ loading ? "Loading..." : "Generate" }}
                            </button>
                        </div>
                        <div class="w-full">
                            <export-excel
                                class="w-full  px-4 py-2 h-10 text-center cursor-pointer bg-green-500 focus:outline-none hover:bg-green-600 text-white  transition duration-500 rounded"
                                :data="results"
                                :fields="json_fields"
                                type="xls"
                                :worksheet="filter.type"
                                :name="filename"
                                v-if="results.length"
                            >
                                Download Excel
                            </export-excel>
                        </div>
                    </div>
                </div>
                <div
                    class="fixed top-0 left-0 flex justify-center items-center w-full min-h-screen bg-white"
                    v-if="loading"
                >
                    <HalfCircleSpinner
                        :animation-duration="1000"
                        :size="60"
                        color="#ff1d5e"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations, mapState } from "vuex";
import { HalfCircleSpinner } from "epic-spinners";
import Report from "../../../services/Report";
export default {
    components: { HalfCircleSpinner },
    name: "Reports",
    data() {
        return {
            loading: false,
            results: [],
            filename: "",
            filter: {
                type: ""
            },
            json_fields: {
                CODE: "itemcode",
                DESCRIPTION: "product_name",
                "CATEGORY NO": "category_no",
                "CATEGORY NAME": "category_name",
                UOM: "UOM",
                "RETAIL PRICE": "price_with_vat"
            },
            json_meta: [
                [
                    {
                        key: "charset",
                        value: "utf-8"
                    }
                ]
            ]
        };
    },
    computed: {
        ...mapState(["Stores", "errors"])
    },
    methods: {
        ...mapMutations(["SET_ERRORS"]),
        changestore() {
            this.results = [];
        },
        generate() {
            this.loading = true;
            let filter = {
                type: this.filter.type
            };
            Report.store_item_report(filter)
                .then(res => {
                    this.loading = false;
                    this.results = res.data.items;
                    this.filename = res.data.filename;
                    this.errors.type = "";
                    swal.fire(
                        "Success",
                        "Download your excel file now, by clicking the Download Excel button.",
                        "info"
                    );
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                    }
                });
        }
    }
};
</script>
