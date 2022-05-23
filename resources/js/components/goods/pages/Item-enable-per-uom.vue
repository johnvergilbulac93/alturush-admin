<template>
    <div class="space-y-2 ">
        <module-header
            icon="md-checkmark-circle"
            title="Enable Product Unit of Measure"
        />
        <div class="border p-2 space-y-2">
            <div class="w-full flex justify-between items-center ">
                <div class="flex w-3/4 gap-2">
                    <Input
                        v-model="tableData.search"
                        @on-keyup="search"
                        placeholder="Search"
                        style="width: 50%"
                        suffix="ios-search"
                        clearable
                        @on-clear="search"
                    />
                    <Select
                        placeholder="Please select a category"
                        v-model="tableData.category"
                        @on-change="fetch()"
                        filterable
                        style="width: 50%"
                    >
                        <Option
                            v-for="(category, index) in ItemCategory"
                            :key="index"
                            :value="category.category_name"
                        >
                            {{ category.category_name }}
                        </Option>
                    </Select>
                </div>
                <div class=" items-center flex gap-1">
                    <span class="sm:hidden md:block">Show</span>
                    <Select
                        v-model="tableData.length"
                        @on-change="fetch()"
                        style="width: 80px"
                        placeholder="Select"
                    >
                        <Option
                            v-for="(records, index) in perPage"
                            :key="index"
                            :value="records"
                            >{{ records }}
                        </Option>
                    </Select>
                    <span class="sm:hidden md:block">Entries</span>
                </div>
            </div>
            <div class="mb-1 " v-if="form.itemIds.length != 0">
                <Tooltip content="Enable" placement="right">
                    <Button
                        @click="enabledAll"
                        type="success"
                        icon="md-checkmark"
                    />
                </Tooltip>
            </div>
            <div class="border rounded">
                <table class="min-w-full ">
                    <thead class="text-gray-600 border-b">
                        <tr>
                            <th class="p-3 font-semibold text-center">
                                <input
                                    type="checkbox"
                                    class="form-checkbox "
                                    @click="selectAll"
                                    v-model="allSelected"
                                />
                            </th>
                            <th
                                v-for="column in columns"
                                :key="column.name"
                                @click="sortBy(column.name)"
                                class="p-3 font-semibold"
                                :class="[
                                    sortKey === column.name
                                        ? sortOrders[column.name] > 0
                                            ? 'sorting_up'
                                            : 'sorting_down'
                                        : 'sorting_both',
                                    column.class
                                ]"
                                style="cursor:pointer;"
                            >
                                {{ column.label }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody text-center">
                        <tr class="tr" v-if="!EnableProducts.length">
                            <td colspan="6" class="td ">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(item, i) in EnableProducts"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">
                                <input
                                    type="checkbox"
                                    class="form-checkbox "
                                    :value="item.price_id"
                                    v-model="form.itemIds"
                                    @click="select"
                                />
                            </td>
                            <td class="td text-left">{{ item.itemcode }}</td>
                            <td class="td text-left">
                                {{ item.product_name }}
                            </td>
                            <td class="td text-left">
                                {{ item.category_name }}
                            </td>
                            <td class="td">{{ item.UOM }}</td>
                            <td class="td text-center ">
                                {{ item.price_with_vat | toCurrency2 }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination
                    :pagination="pagination"
                    @prev="previousPage(pagination.prevPageUrl)"
                    @next="nextPage(pagination.nextPageUrl)"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    name: "Tagging-Enable-UOM",
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Code",
                name: "code",
                class: "text-left"
            },
            {
                label: "Description",
                name: "description",
                class: "text-left"
            },
            {
                label: "Category Name",
                name: "catname",
                class: "text-left"
            },
            {
                label: "UOM",
                name: "uom",
                class: "text-center"
            },
            {
                label: "Price",
                name: "price",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            columns: columns,
            sortKey: "code",
            sortOrders: sortOrders,
            selected: [],
            allSelected: false,
            form: {
                itemIds: []
            },
            tableData: {
                draw: 0,
                length: "10",
                search: "",
                column: 1,
                dir: "asc",
                category: ""
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState(["perPage", "pagination", "ItemCategory"]),
        ...mapState("Product", ["EnableProducts"])
    },
    methods: {
        ...mapActions("Product", ["getEnabledProducts", "enableProduct"]),
        ...mapActions(["getItemCategory"]),
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                category: this.tableData.category
            };
            this.getEnabledProducts({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        enabledAll() {
            this.$Modal.confirm({
                title: "Enable",
                content: "<p>Do you want to  enable this product uom?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.enableProduct({ ids: this.form.itemIds });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        selectAll() {
            this.form.itemIds = [];
            let item;
            let products = this.EnableProducts;
            if (!this.allSelected) {
                for (item in products) {
                    this.form.itemIds.push(products[item].price_id.toString());
                }
            }
        },
        select() {
            this.allSelected = false;
        },
        reset() {
            this.form.itemIds = [];
            this.allSelected = false;
        },
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
        Fire.$on("reload_enable_product", () => {
            this.fetch();
            this.reset();
        });
        this.fetch();
        this.getItemCategory();
    }
};
</script>
