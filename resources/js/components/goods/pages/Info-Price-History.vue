<template>
    <div class=" text-gray-800">
        <div class="h-96 overflow-y-scroll mt-2 p-2">
            <div class="grid grid-cols-6 grid-flow-col gap-4 mb-2">
                <div class="col-span-5 flex items-center justify-between">
                    <div class="w-3/4  flex items-center gap-0.5">
                        <div class="relative w-1/2  flex items-center ">
                            <input
                                type="text"
                                class="relative form-search"
                                placeholder="Search...."
                                v-model="tableData.search"
                                @keyup.enter="search"
                            />
                            <button
                                @click="clear"
                                v-if="tableData.search.length"
                                class="absolute right-0 z-10   pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5  hover:text-red-500"
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
                            </button>
                        </div>
                        <button @click="search" class="button-search">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 "
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </button>
                        <div class="w-60 flex items-center ml-5">
                            <select
                                class="form"
                                v-model="tableData.price_group"
                                @change="fetch"
                            >
                                <option value="">Choose Price Group</option>
                                <option value="TAGB">TAGBILARAN</option>
                                <option value="TALB">TALIBON</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end items-center ">
                    <div class="text-sm ">
                        <span>Show</span>
                        <select
                            class="form-sort"
                            v-model="tableData.length"
                            @change="fetch()"
                        >
                            <option
                                v-for="(records, index) in perPage"
                                :key="index"
                                :value="records"
                            >
                                {{ records }}
                            </option>
                        </select>
                        <span>Entries</span>
                    </div>
                </div>
            </div>
            <Datatable
                :columns="columns"
                :sortKey="sortKey"
                :sortOrders="sortOrders"
                @sort="sortBy"
            >
                <tbody class="tbody text-center">
                    <tr class="tr" v-if="!PriceChangeInfo.length">
                        <td colspan="7" class="td ">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr
                        class="tr"
                        v-for="(data, i) in PriceChangeInfo"
                        :key="i"
                    >
                        <td class="td">{{ data.itemcode }}</td>
                        <td class="td">{{ data.product_name }}</td>
                        <td class="td">{{ data.UOM }}</td>
                        <td
                            class="td p-2 whitespace-nowrap text-sm text-red-600 text-center"
                        >
                            {{ data.prev_price }}
                        </td>
                        <td
                            class="td p-2 whitespace-nowrap text-sm text-blue-600 text-center"
                        >
                            {{ data.new_price }}
                        </td>
                    </tr>
                </tbody>
            </Datatable>
        </div>
        <hr class="mt-2" />
        <Pagination
            class="p-2"
            :pagination="pagination"
            @prev="previousPage(pagination.prevPageUrl)"
            @next="nextPage(pagination.nextPageUrl)"
        />
    </div>
</template>

<script>
import Datatable from "./../../../Usable/Datatable";
import { mapActions, mapState } from "vuex";

export default {
    name: "Price-Changed-Today",
    components: { Datatable },
    data() {
        let sortOrders = {};
        let columns = [
            { width: "70%", label: "Code", name: "description" },
            { width: "20%", label: "Description", name: "category" },
            { width: "20%", label: "UOM", name: "status" },
            { width: "10%", label: "Prev. Price", name: "idss" },
            { width: "10%", label: "New Price", name: "idsss" }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            columns: columns,
            sortKey: "deadline",
            sortOrders: sortOrders,
            tableData: {
                length: 10,
                search: "",
                column: 1,
                dir: "asc",
                price_group: "TAGB"
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState(["perPage", "PriceChangeInfo", "pagination"])
    },
    methods: {
        ...mapActions(["getPriceChangedInfo"]),
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        search() {
            this.fetch();
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                price_group: this.tableData.price_group
            };
            this.getPriceChangedInfo({
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
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        }
    },
    mounted() {
        this.fetch();
    }
};
</script>
