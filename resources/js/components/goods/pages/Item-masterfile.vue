<template>
    <div class=" space-y-2 ">
        <module-header icon="md-basket" title="Product List" />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center gap-2">
                <div class="w-3/4  flex gap-2 items-center">
                    <Input
                        v-model="tableData.search"
                        @on-keyup="search"
                        placeholder="Search"
                        style="width: 30%"
                        suffix="ios-search"
                        clearable
                        @on-clear="search"
                    />
                    <Select
                        placeholder="Select a category"
                        v-model="tableData.category"
                        @on-change="fetch()"
                        style="width: 35%"
                        clearable
                        filterable
                    >
                        <Option
                            v-for="(category, index) in ItemCategory"
                            :key="index"
                            :value="category.category_name"
                        >
                            {{ category.category_name }}
                        </Option>
                    </Select>

                    <Select
                        v-model="tableData.type"
                        @on-change="fetch()"
                        clearable
                        placeholder="Select product availability"
                        style="width: 35%"
                    >
                        <Option value="1">Active </Option>
                        <Option value="2">Inactive </Option>
                    </Select>
                </div>

                <div class="w-1/4  justify-end items-center flex gap-1">
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
            <div class="flex items-center" v-if="form.itemIds.length != 0">
                <Tooltip content="Disable Product" placement="bottom">
                    <Button
                        @click="disableAll"
                        type="error"
                        icon="ios-close"
                        v-if="tableData.type == 1"
                    />
                </Tooltip>
                <Tooltip content="Enable Product" placement="bottom">
                    <Button
                        @click="enableAll"
                        type="success"
                        icon="ios-checkmark"
                        v-if="tableData.type == 2"
                    />
                </Tooltip>
            </div>
            <div class="border rounded">
                <table class="min-w-full ">
                    <thead class="tracking-normal">
                        <tr>
                            <th>
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
                                class="p-3 "
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
                        <tr class="tr" v-if="!StoreProducts.length">
                            <td colspan="5" class="td font-semibold ">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(item, i) in StoreProducts"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">
                                <input
                                    type="checkbox"
                                    class="form-checkbox"
                                    :value="item.itemcode"
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
                            <td class="td ">
                                <Badge
                                    :color="
                                        item.items == null ? 'green' : 'red'
                                    "
                                    :text="
                                        item.items == null
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                />
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
import _ from "lodash";
import { mapActions, mapState } from "vuex";
export default {
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
                label: "Status",
                name: "stat",
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
            allSelected: false,
            tableData: {
                draw: 0,
                length: 10,
                search: "",
                column: 1,
                dir: "desc",
                category: "",
                type: "1"
            },
            form: {
                product_id: "",
                itemcode: "",
                quantity: "",
                product_name: "",
                image: "",
                status: "",
                previewImage: "",
                itemIds: []
            },
            index: -1,
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "perPage",
            "isModal",
            "errors",
            "pagination",
            "ItemCategory"
        ]),
        ...mapState("Product", ["StoreProducts"])
    },
    methods: {
        ...mapActions(["getItemCategory"]),
        ...mapActions("Product", [
            "getStoreProducts",
            "disabledAllStoreProduct",
            "enabledAllStoreProduct"
        ]),
        select() {
            this.allSelected = false;
        },
        selectAll() {
            this.form.itemIds = [];
            let item;
            if (!this.allSelected) {
                for (item in this.StoreProducts) {
                    this.form.itemIds.push(
                        this.StoreProducts[item].itemcode.toString()
                    );
                }
            }
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        fetch() {
            this.form.itemIds = [];
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                category: this.tableData.category,
                type: this.tableData.type
            };
            this.getStoreProducts({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        disableAll() {
            this.$Modal.confirm({
                title: "Confirmation",
                content: "<p>Do you want to disabled the selected item?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.disabledAllStoreProduct({
                        ids: this.form.itemIds
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        enableAll() {
            this.$Modal.confirm({
                title: "Confirmation",
                content: "<p>Do you want to enabled the selected item?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.enabledAllStoreProduct({
                        ids: this.form.itemIds
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
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
        Fire.$on("reload_store_product", () => {
            this.fetch();
        });
        this.fetch();
        this.getItemCategory();
    }
};
</script>
