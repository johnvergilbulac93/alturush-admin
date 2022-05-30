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
        <div class="w-full">
            <fieldset class="border-gray-200 py-2 px-5">
                <legend class="font-semibold">Top 10 Product Sales</legend>
                <div class="flex justify-end items-center gap-2">
                    <DatePicker
                        type="year"
                        placeholder="Select year"
                        v-model="filter.year"
                        @on-change="fetch"
                    />
                    <DatePicker
                        type="month"
                        placeholder="Select month"
                        v-model="filter.month"
                        @on-change="fetch"
                    />
                    <Checkbox v-model="filter.flag">Year Only</Checkbox>
                </div>
                <div class="w-full">
                    <ChartTopItem
                        :data="TopItemData"
                        :labels="TopItemLabels"
                        :year="filter.year"
                        :month="filter.month"
                        :flag="filter.flag"
                        clear-button="true"
                        class="w-full"
                    >
                    </ChartTopItem>
                </div>
            </fieldset>
        </div>
    </div>
</template>

<script>
import ChartTopItem from "./../goods/pages/TopItemChart.vue";
export default {
    name: "Monitor-Data",
    components: { ChartTopItem },
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
    methods: {
        async getTopItems(url = "/api/chart/top_items") {
            let year = moment(this.filter.year).format("YYYY-MM-DD");
            let month = moment(this.filter.month).format("YYYY-M-DD");

            let filter = {
                year: year,
                month: month,
                flag: this.filter.flag
            };

            const { data } = await axios.get(url, { params: filter });
            let result = data;
            result.forEach(item => {
                this.TopItemLabels.push(
                    item.product_name + "(" + item.UOM + ")"
                );
                this.TopItemData.push(item.sales);
            });
        },
        fetch() {
            this.getTopItems();
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
        this.getTopItems();
    }
};
</script>
