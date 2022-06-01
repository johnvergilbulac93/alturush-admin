<template>
    <fieldset class="border-gray-200 p-2 space-y-2">
        <legend class="font-semibold">ITEM DISABLED</legend>
        <div class="flex justify-between items-center ">
            <Input
                v-model="tableData.search"
                @on-keyup="search"
                placeholder="Search"
                style="width: 40%"
                suffix="ios-search"
                clearable
                @on-clear="search"
            />
            <div class="justify-end items-center flex gap-1">
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
        <div class="border rounded">
            <Datatable
                :columns="columns"
                :sortKey="sortKey"
                :sortOrders="sortOrders"
                @sort="sortBy"
            >
                <tbody class="tbody text-center">
                    <tr class="tr" v-if="!ItemsNotAvailable.length">
                        <td colspan="7" class="td font-semibold">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr
                        class="tr"
                        v-for="(data, i) in ItemsNotAvailable"
                        :key="i"
                    >
                        <td class="td text-left">
                            {{ data.itemcode }}
                        </td>
                        <td class="td text-left">
                            {{ data.product_name }}
                        </td>
                        <td class="td text-left">
                            {{ data.category_name }}
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
    </fieldset>
</template>

<script>
import { mapState, mapActions } from "vuex";
import _ from "lodash";
export default {
    name: "",
    data() {
        let sortOrders = {};
        let columns = [
            { class: "text-left w-40", label: "Code", name: "itemcode" },
            { class: "text-left", label: "Description", name: "product_name" },
            {
                class: "text-left",
                label: "Category Name",
                name: "category_name"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            items: {},
            countItems: "",
            loading: true,
            priceCount: "",
            columns: columns,
            sortKey: "deadline",
            sortOrders: sortOrders,
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "asc"
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "TotalItemNotAvailable",
            "ItemsNotAvailable",
            "perPage",
            "pagination"
        ])
    },
    methods: {
        ...mapActions(["getItemNotAvailable"]),
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getItemNotAvailable({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.fetch();
        }
    },
    mounted() {
        this.fetch();
    }
};
</script>
