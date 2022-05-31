<template>
    <div class="space-y-2">
        <div class="flex justify-between item-center gap-2">
            <Button
                type="success"
                size="large"
                style="width: 25%;"
                icon="ios-folder-open"
                to="/masterfile/business-unit"
                >Business Unit</Button
            >
            <Button
                type="success"
                size="large"
                style="width: 25%;"
                icon="ios-home"
                to="/masterfile/tenant"
                >Tenants</Button
            >
            <Button
                type="success"
                size="large"
                style="width: 25%;"
                icon="ios-contacts"
                to="/masterfile/user"
                >Users</Button
            >
            <Button
                type="success"
                size="large"
                style="width: 25%;"
                icon="ios-pin"
                to="/masterfile/delivery-charges"
                >Delivery Locations</Button
            >
        </div>
        <hr />
        <div class="w-full ">
            <fieldset class="border-gray-200 py-2 px-5 space-y-2">
                <legend class="font-semibold">Top 10 Product Sales</legend>
                <div class="flex justify-end items-center gap-2">
                    <Checkbox v-model="filter" @on-change="fetch"
                        >Filter</Checkbox
                    >
                    <DatePicker
                        type="month"
                        placeholder="Select month and year"
                        v-model="date"
                        @on-change="fetch"
                        v-if="!checkbox"
                        :disabled="!filter"
                    />
                    <DatePicker
                        type="year"
                        placeholder="Select year"
                        v-model="date"
                        @on-change="fetch"
                        :disabled="!filter"
                        v-else
                    />
                    <Checkbox
                        v-model="checkbox"
                        @on-change="fetch"
                        :disabled="!filter"
                        >Year Only</Checkbox
                    >
                </div>
                <div class="w-full">
                    <span
                        v-if="!products.length"
                        class="font-semibold flex justify-center"
                        >NO DATA AVAILABLE</span
                    >
                    <TopProduct
                        v-else
                        :qty="product.qty"
                        :labels="product.labels"
                        :colors="product.colors"
                    />
                </div>
            </fieldset>
        </div>
        <div class="w-full ">
            <fieldset class="border-gray-200 py-2 px-5 space-y-2">
                <legend class="font-semibold">Disable Product Per Store</legend>
                <div class="w-full">
                    <span
                        v-if="!products.length"
                        class="font-semibold flex justify-center"
                        >NO DATA AVAILABLE</span
                    >
                    <DisableProductStore
                        v-else
                        :disable_product="disable_product"
                    />
                </div>
            </fieldset>
        </div>
    </div>
</template>

<script>
import TopProduct from "../chart/TopProduct.vue";
import DisableProductStore from "../chart/Disable-Product-Store.vue";
export default {
    name: "Monitor-Data",
    components: { TopProduct, DisableProductStore },
    data() {
        return {
            checkbox: false,
            date: "",
            product: {
                labels: [],
                qty: []
            },
            disable_product: {
                labels: [],
                qty: []
            },
            products: [],
            disable_products: [],
            filter: false
        };
    },
    watch: {
        filter() {
            this.checkbox = false;
        }
    },
    methods: {
        async getItems(url = "/api/chart/not_available_item") {
            try {
                const { data } = await axios.get(url);
                let result = data;
                this.disable_products = result;
                result.forEach(bu => {
                    this.disable_product.labels.push(bu.business_unit);
                    this.disable_product.qty.push(bu.count);
                });
            } catch (error) {
                const { status } = error.response;
                switch (status) {
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
        },
        async getTopItems(url = "/api/chart/top_items") {
            let filter = {
                date: moment(this.date).format("YYYY-MM-DD"),
                flag: this.checkbox,
                flag2: this.filter
            };

            try {
                const { status, data } = await axios.get(url, {
                    params: filter
                });
                if (status == 200) {
                    let result = data;
                    this.products = result;
                    this.product.labels = [];
                    this.product.qty = [];
                    result.forEach(item => {
                        this.product.labels.push(
                            `${item.product_name}(${item.UOM})`
                        );
                        this.product.qty.push(Math.round(item.sales));
                    });
                }
            } catch (error) {
                const { status } = error.response;
                switch (status) {
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
        },
        fetch() {
            this.getTopItems();
            this.getItems();
        }
    },
    beforeMount() {
        this.date = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
    },
    mounted() {
        this.fetch();
    }
};
</script>
