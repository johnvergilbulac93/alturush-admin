<template>
    <div class=" space-y-2 border">
        <div class=" text-gray-800 overflow-x-auto">
            <div class="mb-2 bg-gray-100 p-2">
                <label for="" class=" text-lg font-semibold"
                    >Item Masterfile</label
                >
            </div>
            <div class="p-2">
                <div class="flex items-center">
                    <div class="flex gap-2 items-center w-full">
                        <div class="w-auto flex items-center gap-0.5 ">
                            <div class="relative w-64  flex items-center ">
                                <input
                                    type="text"
                                    class="form-search "
                                    placeholder="Search...."
                                    v-model="tableData.search"
                                    @keyup.enter="search"
                                />
                                <button
                                    @click="clear"
                                    v-if="tableData.search.length"
                                    class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none "
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
                        </div>
                        <div class="w-72">
                            <select
                                class="form"
                                v-model="tableData.category"
                                @change="fetch()"
                            >
                                <option value="">Choose Category</option>
                                <option
                                    v-for="(category, index) in ItemCategory"
                                    :key="index"
                                    :value="category.category_name"
                                >
                                    {{ category.category_name }}
                                </option>
                            </select>
                        </div>
                        <div class="w-48">
                            <select
                                class="form "
                                v-model="tableData.type"
                                @change="fetch()"
                            >
                                <option value="">Item Availability</option>
                                <option value="1">Available Item</option>
                                <option value="2">Unavailable Item</option>
                            </select>
                        </div>
                    </div>
                    <div
                        class="flex gap-1 justify-end text-sm items-center w-40 "
                    >
                        <span>Show</span>
                        <select
                            class="form-sort  "
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

                <div class="flex space-x-2 mt-1">
                    <div class="mb-1">
                        <button
                            class="flex items-center bg-red-500 px-2 py-1 focus:outline-none text-white  hover:bg-red-600 transition duration-500 rounded"
                            v-if="form.itemIds.length != 0"
                            @click="disableAll"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-1"
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
                            Disable
                        </button>
                    </div>
                    <div class="mb-1">
                        <button
                            class="flex items-center bg-green-500 px-2 py-1 focus:outline-none text-white  hover:bg-green-600 transition duration-500 rounded"
                            v-if="form.itemIds.length != 0"
                            @click="enableAll"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            Enable
                        </button>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class=" bg-gray-100 tracking-normal">
                        <tr>
                            <th class="th border">
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
                                class="p-3 border"
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
                        <tr class="tr" v-if="!Items.length">
                            <td colspan="5" class="td ">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(item, i) in Items" :key="i" class="tr">
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
                                <button
                                    v-if="item.items !== null"
                                    @click="ItemEnable(item.itemcode)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Disable Item"
                                    class="focus:outline-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-red-500"
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
                                <button
                                    v-else
                                    @click="ItemDisable(item.itemcode)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Enable Item"
                                    class="focus:outline-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-green-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </button>
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
import Item from "../../../services/Item";
export default {
    data() {
        let sortOrders = {};

        let columns = [
            {
                width: "25%",
                label: "Code",
                name: "code",
                class: "text-left"
            },
            {
                width: "25%",
                label: "Description",
                name: "description",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Category Name",
                name: "catname",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Action",
                name: "action",
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
                type: ""
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
            "ItemCategory",
            "Items"
        ])
    },
    methods: {
        ...mapActions(["modal", "getItemCategory", "getStoreItem"]),
        select() {
            this.allSelected = false;
        },
        selectAll() {
            this.form.itemIds = [];
            let item;
            if (!this.allSelected) {
                for (item in this.Items) {
                    this.form.itemIds.push(
                        this.Items[item].itemcode.toString()
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
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                category: this.tableData.category,
                type: this.tableData.type
            };
            this.getStoreItem({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search() {
            this.fetch();
        },
        disableAll() {
            let itemcode = {
                ids: this.form.itemIds
            };
            swal.fire({
                title: "Confirmation",
                text: "Do you want to disable the selected item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, disable it."
            }).then(result => {
                if (result.isConfirmed) {
                    Item.store_item_disable_all(itemcode).then(() => {
                        this.fetch();
                        this.form.itemIds = [];
                        this.allSelected = false;
                        toast.fire({
                            icon: "success",
                            title: "Success",
                            text: "Successfully changed"
                        });
                    });
                }
            });
        },
        enableAll() {
            let itemcode = {
                ids: this.form.itemIds
            };
            swal.fire({
                title: "Confirmation",
                text: "Do you want to enable the selected item?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, enable it."
            }).then(result => {
                if (result.isConfirmed) {
                    Item.store_item_enable_all(itemcode).then(() => {
                        this.fetch();
                        this.form.itemIds = [];
                        this.allSelected = false;
                        toast.fire({
                            icon: "success",
                            title: "Success",
                            text: "Successfully changed"
                        });
                    });
                }
            });
        },
        ItemEnable(itemcode) {
            swal.fire({
                title: "Are you sure?",
                text: "you want to enable this Item",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Enable it!"
            }).then(result => {
                if (result.isConfirmed) {
                    Item.tag_store_item_enable(itemcode).then(() => {
                        this.fetch();
                        toast.fire({
                            icon: "success",
                            title: "Success",
                            text: "Successfully changed"
                        });
                    });
                }
            });
        },
        ItemDisable(itemcode) {
            swal.fire({
                title: "Are you sure?",
                text: "you want to disable this Item",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Disable it!"
            }).then(result => {
                if (result.isConfirmed) {
                    Item.tag_store_item_disable({ itemcode: itemcode }).then(
                        () => {
                            this.fetch();
                            toast.fire({
                                icon: "success",
                                title: "Success",
                                text: "Successfully changed"
                            });
                        }
                    );
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
        this.fetch();
        this.getItemCategory();
    }
};
</script>
