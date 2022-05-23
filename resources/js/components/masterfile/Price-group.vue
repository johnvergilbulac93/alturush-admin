<template>
    <div class="space-y-2">
        <module-header icon="ios-pricetags" title="Price Group" />

        <div class="border p-2">
            <div class="flex justify-between items-center my-2">
                <Input
                    v-model="tableData.search"
                    @on-keyup="search"
                    placeholder="Search"
                    style="width: 40%;"
                    suffix="ios-search"
                    clearable
                    @on-clear="search"
                />
                <div class="justify-end items-center flex gap-1">
                    <span class="sm:hidden md:block">Show</span>
                    <Select
                        v-model="tableData.length"
                        @on-change="fetch()"
                        style="width: 80px;"
                        placeholder="Select"
                    >
                        <Option
                            v-for="(records, index) in perPage"
                            :key="index"
                            :value="records"
                            >{{ records }}</Option
                        >
                    </Select>
                    <span class="sm:hidden md:block">Entries</span>
                </div>
            </div>
            <div class="border rounded">
                <Datatable
                    :columns="columns"
                    :sortKey="sortKey"
                    :sortOrders="sortOrders"
                    @sort="sortBy"
                >
                    <tbody class="tbody">
                        <tr class="tr" v-if="!PGroup.length">
                            <td colspan="3" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(price, i) in PGroup" :key="i" class="tr">
                            <td class="td">{{ price.business_unit }}</td>
                            <td class="td">{{ price.price_group_name }}</td>

                            <td class="td text-center">
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(price)"
                                        type="primary"
                                        shape="circle"
                                        size="small"
                                        icon="ios-open-outline"
                                    />
                                </Tooltip>
                            </td>
                        </tr>
                    </tbody>
                </Datatable>
                <Pagination
                    :pagination="pagination"
                    @prev="previousPage(pagination.prevPageUrl)"
                    @next="nextPage(pagination.nextPageUrl)"
                />
            </div>
        </div>
        <Drawer title="Edit Price Group" v-model="drawer" width="512">
            <Form label-position="left" :label-width="100">
                <FormItem label="Store">
                    <Select
                        v-model="form.store"
                        placeholder="Please select a store"
                    >
                        <Option value>Select a store</Option>
                        <Option
                            :value="store.bunit_code"
                            v-for="(store, i) in Stores"
                            :key="i"
                            >{{ store.business_unit }}</Option
                        >
                    </Select>
                </FormItem>
                <FormItem label="Price Group">
                    <Select
                        v-model="form.price_group"
                        placeholder="Please select a price group"
                    >
                        <Option value>Select price group</Option>
                        <Option
                            :value="price.price_group_code"
                            v-for="(price, i) in PriceGroup"
                            :key="i"
                            >{{ price.price_group_name }}</Option
                        >
                    </Select>
                </FormItem>
            </Form>
            <div class="w-full absolute bottom-0 left-0 border-t">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button type="success" @click="update()">SUBMIT</Button>
                        <Button type="default" @click="drawer = !drawer"
                            >CANCEL</Button
                        >
                    </div>
                </div>
            </div>
        </Drawer>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Store",
                name: "store",
                class: "text-left"
            },
            {
                label: "Price Group",
                name: "pgroup",
                class: "text-left w-60"
            },
            {
                label: "Action",
                name: "action",
                class: "text-center w-24"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            columns: columns,
            sortKey: "itemcode",
            sortOrders: sortOrders,
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "desc"
            },
            form: {
                id: "",
                store: "",
                price_group: ""
            },
            currentPage: 1,
            id: "",
            drawer: false
        };
    },
    computed: {
        ...mapState([
            "errors",
            "perPage",
            "pagination",
            "Stores",
            "PriceGroup"
        ]),
        ...mapState("PGroup", ["PGroup"])
    },
    methods: {
        ...mapActions(["getStore", "getPriceGroup"]),
        ...mapActions("PGroup", ["showPriceGroup", "updatePriceGroup"]),
        update() {
            this.updatePriceGroup({
                store: this.form.store,
                price_group: this.form.price_group
            });
        },
        editInfo(price) {
            this.reset();
            this.drawer = !this.drawer;
            this.form.store = price.bunit_code;
            this.form.price_group = price.price_group_code;
        },
        reset() {
            this.form.id = "";
            this.form.store = "";
            this.form.price_group = "";
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.showPriceGroup({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.fetch();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        }
    },
    mounted() {
        Fire.$on("reload_price_group", () => {
            this.fetch();
            this.drawer = false;
            this.reset();
        });
        this.fetch();
        this.getStore();
        this.getPriceGroup();
    }
};
</script>
