<template>
    <div class="border-x border-b p-2">
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
                    <tr class="tr" v-if="!TenantGoods.length">
                        <td colspan="4" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(tenant, i) in TenantGoods" :key="i" class="tr">
                        <td class="td">{{ tenant.business_unit }}</td>
                        <td class="td">{{ tenant.name }}</td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    tenant.status == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(tenant)"
                                    size="small"
                                    :type="
                                        tenant.status == 1 ? 'success' : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        tenant.status == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td text-center">
                            <Tooltip content="Edit" placement="bottom">
                                <Button
                                    @click="editInfo(tenant)"
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
            :title="editMode ? 'Edit Tenant' : 'Add Tenant'"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Store">
                    <Select
                        placeholder="Please select a store"
                        v-model="form.store"
                    >
                        <Option value>Select a store</Option>
                        <Option
                            :value="store.bunit_code"
                            v-for="(store, index) in Stores"
                            :key="index"
                            >{{ store.business_unit }}</Option
                        >
                    </Select>
                    <Error :message="errors.store[0]" v-if="errors.store" />
                </FormItem>
                <FormItem label="Department">
                    <Select
                        placeholder="Please select a department"
                        v-model="form.department"
                    >
                        <Option value>Select a department</Option>
                        <Option
                            :value="dept.dept_id"
                            v-for="(dept, index) in Departments"
                            :key="index"
                            >{{ dept.name }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.department[0]"
                        v-if="errors.department"
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
import { mapActions, mapState, mapMutations } from "vuex";

export default {
    name: "GoodsTenant",
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Store",
                name: "description",
                class: "text-left w-1/3"
            },
            {
                label: "Department",
                name: "category",
                class: "text-left w-1/3"
            },
            {
                label: "Status",
                name: "status",
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
            columns: columns,
            sortKey: "deadline",
            sortOrders: sortOrders,
            form: {
                id: "",
                store: "",
                department: ""
            },
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "desc"
            },
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState([
            "Stores",
            "Departments",
            "pagination",
            "perPage",
            "errors"
        ]),
        ...mapState("Tenant", ["TenantGoods"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions("Tenant", [
            "getTenantGoods",
            "saveGoodsTenant",
            "updateGoodsTenant",
            "changeStatusTenantGoods"
        ]),
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        changeStatus(data) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeStatusTenantGoods({
                        status: data.status,
                        id: data.tenant_id
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
            this.drawer = !this.drawer;
            this.form.id = data.tenant_id;
            this.form.store = data.bunit_code;
            this.form.department = data.dept_id;
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getTenantGoods({
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
        reset() {
            this.form.id = "";
            this.form.store = "";
            this.form.department = "";
            this.form.status = "";
            this.editMode = false;
            this.CLEAR_ERRORS();
        },
        update() {
            this.updateGoodsTenant({
                id: this.form.id,
                store: this.form.store,
                department: this.form.department
            });
        },
        create() {
            this.saveGoodsTenant({
                store: this.form.store,
                department: this.form.department
            });
        },
        clear() {
            this.tableData.search = "";
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
        Fire.$on("reload_goods_tenant", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
