<template>
    <div class=" space-y-2 ">
        <module-header icon="md-cloud-download" title="Export Product List  " />
        <div class="border p-2 flex  justify-center">
            <div class="space-y-2 block w-[30%] ">
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
import Http from "../../../services/Report";
export default {
    name: "Export-Product-Store",
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

    methods: {
        changestore() {
            this.results = [];
        },
        async generate() {
            this.$Spin.show();
            this.results = [];
            let payload = {
                type: this.filter.type
            };
            try {
                const { status, data } = await Http.store_item_report(payload);
                if (status === 200) {
                    this.$Spin.hide();
                    this.results = data.items;
                    this.filename = data.filename;
                    this.$Notice.success({
                        title: "System Notification",
                        desc:
                            "Download your excel file now, by clicking the Download Excel button."
                    });
                }
            } catch (error) {
                this.$Spin.hide();
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            Message.error({
                                background: true,
                                content: `${obj[msg]}`
                            });
                        }
                        break;
                    case 500:
                        Vue.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        }
    }
};
</script>
