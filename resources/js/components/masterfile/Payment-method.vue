<template>
    <div class="space-y-2">
        <module-header icon="ios-calculator" title="Payment Method" />
        <div class="border p-2">
            <div class="flex justify-end">
                <Tooltip content="Add" placement="right">
                    <Button
                        icon="md-add"
                        type="warning"
                        @click="addModal"
                        shape="circle"
                    />
                </Tooltip>
            </div>
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
                    <tbody class="tbody">
                        <tr class="tr" v-if="!PaymentMethod.length">
                            <td colspan="4" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            class="tr"
                            v-for="(data, i) in PaymentMethod"
                            :key="i"
                        >
                            <td class="td">{{ data.payment_gateway }}</td>
                            <td class="td">{{ data.discription }}</td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        data.status == 1 ? 'Active' : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatus(data)"
                                        size="small"
                                        :type="
                                            data.status == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            data.status == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(data)"
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
        </div>
        <Drawer
            :title="editMode ? 'Edit Payment Method' : 'Add Payment Method'"
            v-model="drawer"
            width="512"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Payment Method">
                    <Input type="text" v-model="form.payment_method" />
                    <Error
                        :message="errors.payment_method[0]"
                        v-if="errors.payment_method"
                    />
                </FormItem>
                <FormItem label="Description">
                    <Input type="text" v-model="form.payment_description" />
                    <Error
                        :message="errors.payment_description[0]"
                        v-if="errors.payment_description"
                    />
                </FormItem>
            </Form>
            <div class="w-full absolute bottom-0 left-0 border-t">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button
                            type="success"
                            @click="editMode ? update() : create()"
                            >SUBMIT</Button
                        >
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
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Payment Method",
                name: "payment",
                class: "text-left w-1/4"
            },
            {
                label: "Description ",
                name: "desc",
                class: "text-left w-1/2"
            },
            {
                label: "Status",
                name: "stat",
                class: "text-center "
            },
            {
                label: "Action",
                name: "action",
                class: "text-center "
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            columns: columns,
            sortKey: "itemcode",
            sortOrders: sortOrders,
            editMode: false,
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "asc"
            },
            form: {
                id: "",
                payment_method: "",
                payment_description: ""
            },
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination", "Stores"]),
        ...mapState("PMethod", ["PaymentMethod"])
    },
    methods: {
        ...mapActions(["getStore", "getPriceGroup"]),
        ...mapActions("PMethod", [
            "showPaymentMethod",
            "savePaymentMethod",
            "updatePaymentMethod",
            "updateStatus"
        ]),
        ...mapMutations(["CLEAR_ERRORS"]),
        changeStatus(data) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: data.id,
                        status: data.status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        update() {
            this.updatePaymentMethod({
                id: this.form.id,
                payment_method: this.form.payment_method,
                payment_description: this.form.payment_description
            });
        },
        create() {
            this.savePaymentMethod({
                payment_method: this.form.payment_method,
                payment_description: this.form.payment_description
            });
        },
        editInfo(data) {
            this.reset();
            this.editMode = true;
            this.form.id = data.id;
            this.form.payment_method = data.payment_gateway;
            this.form.payment_description = data.discription;
            this.drawer = !this.drawer;
        },
        reset() {
            (this.form.id = ""),
                (this.form.payment_method = ""),
                (this.form.payment_description = ""),
                this.CLEAR_ERRORS();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.showPaymentMethod({
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
        Fire.$on("reload_payment_method", () => {
            this.fetch();
            this.drawer = false;
            this.reset();
        });
        this.fetch();
    }
};
</script>
