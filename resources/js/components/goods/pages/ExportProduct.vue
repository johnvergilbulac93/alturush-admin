<template>
    <div class="space-y-2 ">
        <module-header icon="md-cloud-download" title="Export Product(s)" />
        <div class="border p-2 flex  justify-center">
            <div class="space-y-2 block w-[30%] ">
                <Select
                    v-model="filter.store"
                    placeholder="Choose a store"
                    @on-change="generate()"
                >
                    <Option
                        :value="store.bunit_code"
                        v-for="(store, i) in Stores"
                        :key="i"
                    >
                        {{ store.business_unit }}
                    </Option>
                </Select>
                <Select
                    v-model="filter.type"
                    @on-change="generate()"
                    placeholder="Choose a filter"
                >
                    <Option value="all">All Items</Option>
                    <Option value="available">Available Items</Option>
                    <Option value="unavailable">Unavailable Items</Option>
                </Select>

                <export-excel
                    class="exportBtn"
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
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import Http from "../../../services/Item";

export default {
    name: "Export-Product",
    data() {
        return {
            results: [],
            filename: "",
            filter: {
                type: "",
                store: ""
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
        ...mapState(["Stores"])
    },
    methods: {
        ...mapActions(["getStore"]),
        generate: _.debounce(async function() {
            this.results = [];
            this.$Spin.show();
            try {
                const { status, data } = await Http.export_product({
                    store: this.filter.store,
                    type: this.filter.type
                });

                if (status == 200) {
                    this.results = data.items;
                    this.filename = data.filename;
                    this.$Message.success({
                        background: true,
                        duration: 3,
                        content:
                            "Download your excel file now, by clicking the Download Excel button."
                    });
                    this.$Spin.hide();
                }
            } catch (error) {
                this.$Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            this.$Message.info({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    default:
                        break;
                }
            }
        }, 500)
    },
    mounted() {
        this.getStore();
    }
};
</script>
