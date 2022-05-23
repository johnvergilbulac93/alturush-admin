<template>
    <div class="space-y-2 border">
        <div class="text-gray-800 overflow-x-auto">
            <div class="mb-2 bg-gray-100 p-2">
                <label class="text-lg font-semibold"
                    >Minimum Order Delivery</label
                >
            </div>

            <div class="p-2">
                <div
                    class="flex sm:flex-wrap sm:space-y-2 justify-between items-center pb-2"
                >
                    <div class="md:w-1/2 sm:w-full flex items-center gap-0.5">
                        <div class="relative w-full flex items-center">
                            <input
                                type="text"
                                class="form-search"
                                placeholder="Search...."
                                v-model="tableData.search"
                                @keyup.enter="search"
                            />
                            <button
                                @click="clear"
                                v-if="tableData.search.length"
                                class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded text-sm flex items-center justify-center focus:outline-none "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 hover:text-red-500"
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
                    <div
                        class="justify-end items-center sm:hidden md:flex gap-1"
                    >
                        <span class="sm:hidden md:block">Show</span>
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
                        <span class="sm:hidden md:block">Entries</span>
                    </div>
                </div>
                <Datatable
                    :columns="columns"
                    :sortKey="sortKey"
                    :sortOrders="sortOrders"
                    @sort="sortBy"
                >
                    <tbody class="tbody text-center">
                        <tr class="tr" v-if="!MinOrders.length">
                            <td colspan="4" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            class="tr"
                            v-for="(minorder, i) in MinOrders"
                            :key="i"
                        >
                            <td class="td text-left">
                                {{ minorder.business_unit }}
                            </td>
                            <td class="td text-left">{{ minorder.name }}</td>
                            <td class="td">
                                {{ minorder.amount | toCurrency2 }}
                            </td>
                            <td class="td">
                                <button
                                    class="p-1 focus:outline-none"
                                    @click="remove(minorder.min_id)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Delete"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-700 hover:text-red-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
                                </button>
                                <button
                                    class="focus:outline-none p-1"
                                    @click="editInfo(minorder)"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Edit"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-700 hover:text-green-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                        />
                                    </svg>
                                </button>
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

            <transition
                enter-active-class=" ease-in-out transition duration-500"
                enter-class="transform -translate-y-11 opacity-0 "
                enter-to-class="opacity-100"
                leave-active-class="ease-in-out transition duration-500"
                leave-class=" opacity-100"
                leave-to-class="transform -translate-y-11 opacity-0"
            >
                <div
                    v-if="isModal"
                    class="fixed top-0 left-0 flex z-50 justify-center p-2 items-center w-full min-h-screen"
                >
                    <div
                        class="sm:w-3/4 xl:w-1/2 bg-white border border-gray-400 rounded text-gray-800 shadow-lg"
                    >
                        <div
                            class="p-2 flex justify-between items-center sm:text-sm lg:text-lg "
                        >
                            <label class="font-semibold" v-if="!editMode"
                                >Setup new minimum order</label
                            >
                            <label v-if="editMode" class="font-semibold "
                                >Update this minimum order</label
                            >
                            <button
                                class="focus:outline-none   "
                                @click="closeModal"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="lg:h-6 lg:w-6 sm:h-5 sm:w-5 text-gray-500 hover:text-red-500"
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
                        <hr />
                        <transition
                            enter-active-class="ease-in duration-500"
                            enter-class="opacity-0 "
                            enter-to-class="opacity-100"
                            leave-active-class="ease-out duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <ErrorMessage
                                :message="errors.message[0]"
                                v-if="errors.message"
                                @clear="clearError"
                            />
                        </transition>
                        <div class="w-full px-5 my-2 space-y-4">
                            <div class="flex flex-col w-full">
                                <label for="store" class="font-semibold"
                                    >Store</label
                                >
                                <select class="form" v-model="form.store">
                                    <option value="">Select Store</option>
                                    <option
                                        :value="store.bunit_code"
                                        v-for="(store, index) in Stores"
                                        :key="index"
                                    >
                                        {{ store.business_unit }}
                                    </option>
                                </select>
                                <transition
                                    enter-active-class="ease-in duration-500"
                                    enter-class="opacity-0 "
                                    enter-to-class="opacity-100"
                                    leave-active-class="ease-out duration-500"
                                    leave-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <Error
                                        :message="errors.store[0]"
                                        v-if="errors.store"
                                    />
                                </transition>
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="department" class="font-semibold"
                                    >Department</label
                                >
                                <select class=" form" v-model="form.department">
                                    <option value="">Select Department</option>
                                    <option
                                        :value="dept.dept_id"
                                        v-for="(dept, index) in Departments"
                                        :key="index"
                                    >
                                        {{ dept.name }}
                                    </option>
                                </select>
                                <transition
                                    enter-active-class="ease-in duration-500"
                                    enter-class="opacity-0 "
                                    enter-to-class="opacity-100"
                                    leave-active-class="ease-out duration-500"
                                    leave-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <Error
                                        :message="errors.department[0]"
                                        v-if="errors.department"
                                    />
                                </transition>
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="amount" class="font-semibold"
                                    >Amount</label
                                >
                                <input
                                    v-model="form.amount"
                                    type="number"
                                    class="form"
                                />
                                <transition
                                    enter-active-class="ease-in duration-500"
                                    enter-class="opacity-0 "
                                    enter-to-class="opacity-100"
                                    leave-active-class="ease-out duration-500"
                                    leave-class="opacity-100"
                                    leave-to-class="opacity-0"
                                >
                                    <Error
                                        :message="errors.amount[0]"
                                        v-if="errors.amount"
                                    />
                                </transition>
                            </div>
                        </div>
                        <hr />
                        <div
                            class="p-2 flex justify-end items-center space-x-1"
                        >
                            <button
                                v-if="!editMode"
                                @click="create"
                                class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Save
                            </button>
                            <button
                                v-if="editMode"
                                @click="update"
                                class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                            >
                                Update
                            </button>
                            <button
                                @click="closeModal"
                                class="px-4 py-2 bg-red-500 text-white  hover:bg-red-600 rounded transition duration-500 focus:outline-none"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
            <button
                @click="addModal"
                v-if="!isModal"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Add"
                class="fixed z-30 bottom-0 right-0 sm:mb-5 lg:mb-16 mr-3 focus:outline-none bg-blue-400 hover:bg-blue-500 w-12 h-12 rounded-full shadow-xl transition duration-700 ease-in-out transform hover:scale-105 "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-white mx-auto"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    name: "Minimum-Order",
    data() {
        let sortOrders = {};
        let columns = [
            { width: "15%", label: "Store", name: "store", class: "text-left" },
            {
                width: "15%",
                label: "Department",
                name: "dept",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Amount",
                name: "amount",
                class: "text-center"
            },
            {
                width: "10%",
                label: "Action",
                name: "idss",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            editMode: false,
            selectMin: false,
            columns: columns,
            sortKey: "id",
            sortOrders: sortOrders,
            tableData: {
                length: 10,
                search: "",
                column: 1,
                dir: "desc"
            },
            form: {
                id: "",
                store: "",
                department: "",
                amount: ""
            },
            currentPage: 1
        };
    },
    computed: {
        ...mapState([
            "perPage",
            "pagination",
            "MinOrders",
            "isModal",
            "Stores",
            "Departments",
            "errors",
            "SetupMenu"
        ])
    },
    methods: {
        ...mapActions([
            "getStore",
            "getDepartment",
            "modal",
            "saveMinOrder",
            "getMinOrder",
            "updateMinOrder",
            "deleteMinOrder"
        ]),
        clearError() {
            this.errors.message = "";
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
        reset() {
            this.form.id = "";
            this.form.store = "";
            this.form.department = "";
            this.form.amount = "";
            this.errors.store = "";
            this.errors.department = "";
            this.errors.amount = "";
        },
        create() {
            let minorder = {
                store: this.form.store,
                department: this.form.department,
                amount: this.form.amount
            };
            this.saveMinOrder({ minorder });
        },
        update() {
            let minorder = {
                id: this.form.id,
                store: this.form.store,
                department: this.form.department,
                amount: this.form.amount
            };
            this.updateMinOrder({ minorder });
        },
        closeModal() {
            this.reset();
            this.editMode = false;
            this.modal({
                flag: false
            });
        },
        addModal() {
            this.editMode = false;
            this.modal({
                flag: true
            });
        },
        remove(id) {
            this.deleteMinOrder({
                id: id
            });
        },
        editInfo(minorder) {
            this.reset();
            this.editMode = true;
            (this.form.id = minorder.min_id),
                (this.form.store = minorder.bunit_code),
                (this.form.department = minorder.department_id);
            this.form.amount = minorder.amount;
            this.modal({
                flag: true
            });
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                province: this.tableData.province
            };
            this.getMinOrder({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search() {
            this.fetch();
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
        Fire.$on("reload_min_order", () => {
            this.fetch();
        });
        this.fetch();
        this.getStore();
        this.getDepartment();
    }
};
</script>
