<template>
    <div class="border-x border-b p-2 space-y-2">
        <div class="flex justify-end">
            <Tooltip content="Add " placement="right">
                <Button
                    icon="md-add"
                    type="warning"
                    @click="addModal"
                    shape="circle"
                />
            </Tooltip>
        </div>
        <div class="flex justify-between items-center">
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
                <tbody class="tbody text-center">
                    <tr class="tr" v-if="!MinOrderGoods.length">
                        <td colspan="5" class="td text-center font-semibold">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr
                        class="tr"
                        v-for="(minorder, i) in MinOrderGoods"
                        :key="i"
                    >
                        <td class="td text-left">
                            {{ minorder.business_unit }}
                        </td>
                        <td class="td text-left">{{ minorder.name }}</td>
                        <td class="td text-right">
                            {{ minorder.amount | toCurrency2 }}
                        </td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    minorder.status == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(minorder)"
                                    size="small"
                                    :type="
                                        minorder.status == 1
                                            ? 'success'
                                            : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        minorder.status == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td">
                            <Tooltip content="Edit" placement="bottom">
                                <Button
                                    @click="editInfo(minorder)"
                                    size="small"
                                    type="primary"
                                    shape="circle"
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
        <Drawer
            :title="editMode ? 'Edit Minimum Order' : 'Add Minimum Order'"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Store" required>
                    <Select
                        placeholder="Please select a store"
                        v-model="form.store"
                    >
                        <Option
                            :value="store.bunit_code"
                            v-for="(store, i) in Stores"
                            :key="i"
                            >{{ store.business_unit }}
                        </Option>
                    </Select>
                    <Error :message="errors.store[0]" v-if="errors.store" />
                </FormItem>
                <FormItem label="Department" required>
                    <Select
                        placeholder="Please select a department"
                        v-model="form.department"
                    >
                        <Option
                            :value="dept.dept_id"
                            v-for="(dept, i) in Departments"
                            :key="i"
                            >{{ dept.name }}
                        </Option>
                    </Select>
                    <Error
                        :message="errors.department[0]"
                        v-if="errors.department"
                    />
                </FormItem>
                <FormItem label="Minimum Amt." required>
                    <InputNumber
                        v-model="form.amount"
                        placeholder="Enter Minimum Amt."
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        style="width: 100%;"
                    />
                    <Error :message="errors.amount[0]" v-if="errors.amount" />
                </FormItem>
                <div class="w-full absolute bottom-0 left-0 border-t text-left">
                    <div class="flex justify-end items-center">
                        <div class="p-2">
                            <Button
                                type="success"
                                @click="editMode ? update() : create()"
                                >SUBMIT</Button
                            >
                            <Button type="default" @click="drawer = false"
                                >CANCEL</Button
                            >
                        </div>
                    </div>
                </div>
            </Form>
        </Drawer>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    name: "Minimum-Order-Goods",
    data() {
        let sortOrders = {};
        let columns = [
            { width: "15%", label: "Store", name: "store", class: "text-left" },
            {
                label: "Department",
                name: "dept",
                class: "text-left"
            },
            {
                label: "Minimum Amt.",
                name: "amount",
                class: "text-right"
            },
            {
                label: "Status",
                name: "stat",
                class: "text-center"
            },
            {
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
                length: "10",
                search: "",
                column: 1,
                dir: "desc"
            },
            form: {
                id: "",
                store: "",
                department: "",
                amount: 0
            },
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState([
            "perPage",
            "pagination",
            "Stores",
            "Departments",
            "errors"
        ]),
        ...mapState("MinOrder", ["MinOrderGoods"])
    },
    methods: {
        ...mapActions("MinOrder", [
            "getMinOrderGoods",
            "saveMinOrderGoods",
            "updateMinOrderGoods",
            "updateStatusMinOrderGoods"
        ]),

        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        reset() {
            this.form.id = "";
            this.form.store = "";
            this.form.department = "";
            this.form.amount = 0;
        },
        create() {
            let payload = {
                store: this.form.store,
                department: this.form.department,
                amount: this.form.amount
            };
            this.saveMinOrderGoods(payload);
        },
        update() {
            let payload = {
                id: this.form.id,
                store: this.form.store,
                department: this.form.department,
                amount: this.form.amount
            };
            this.updateMinOrderGoods(payload);
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = true;
        },
        changeStatus(minorder) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    let payload = {
                        status: minorder.status,
                        id: minorder.min_id
                    };
                    this.updateStatusMinOrderGoods(payload);
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        editInfo(minorder) {
            this.reset();
            this.editMode = true;
            this.drawer = true;
            this.form.id = minorder.min_id;
            this.form.store = minorder.bunit_code;
            this.form.department = minorder.department_id;
            this.form.amount = parseFloat(minorder.amount);
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                province: this.tableData.province
            };
            this.getMinOrderGoods({
                currentPage: this.currentPage,
                filterData: filterData
            });
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
        Fire.$on("reload_min_order_goods", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
