<template>
    <div class="space-y-2">
        <module-header icon="ios-bookmark-outline" title="Voucher Category" />
        <div class="border p-2 space-y-2">
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
                    <tbody class="tbody">
                        <tr class="tr" v-if="!Vouchers.length">
                            <td
                                colspan="3"
                                class="td text-center font-semibold"
                            >
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(data, i) in Vouchers" :key="i" class="tr">
                            <td class="td">{{ data.voucher_category }}</td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        data.status == 1 ? 'Active' : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="
                                            changeStatus(
                                                data.id,
                                                data.status,
                                                'status'
                                            )
                                        "
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
                                        type="primary"
                                        size="small"
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
            :title="!editMode ? 'Add Voucher' : 'Edit Voucher'"
            v-model="drawer"
            width="512"
        >
            <Form label-position="left" :label-width="120">
                <FormItem label="Voucher name" :required="!editMode">
                    <Input v-model="form.voucher" placeholder="Voucher name" />
                    <Error :message="errors.voucher[0]" v-if="errors.voucher" />
                </FormItem>
            </Form>
            <div class="w-full absolute bottom-0 left-0 border-t">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button
                            type="success"
                            @click="!editMode ? create() : update()"
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
import { mapActions, mapState, mapMutations } from "vuex";

export default {
    name: "Voucher-Categories",
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Voucher Category",
                name: "province",
                class: "text-left w-3/4"
            },
            {
                label: "Status",
                name: "stat",
                class: "text-center "
            },
            {
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
                voucher: ""
            },
            editMode: false,
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination"]),
        ...mapState("Voucher", ["Vouchers"])
    },
    methods: {
        ...mapActions("Voucher", [
            "getVouchers",
            "saveVoucher",
            "updateVoucher",
            "updateStatus"
        ]),
        reset() {
            (this.form.id = ""), (this.form.voucher = "");
        },
        create() {
            this.saveVoucher({ voucher: this.form.voucher });
        },
        update() {
            this.updateVoucher({
                id: this.form.id,
                voucher: this.form.voucher
            });
        },
        changeStatus(id, status) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: id,
                        status: status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        editInfo(data) {
            this.reset();
            this.editMode = true;
            this.drawer = true;
            this.form.id = data.id;
            this.form.voucher = data.voucher_category;
        },
        addModal() {
            this.reset();
            this.drawer = true;
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getVouchers({
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
        Fire.$on("reload_voucher", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
