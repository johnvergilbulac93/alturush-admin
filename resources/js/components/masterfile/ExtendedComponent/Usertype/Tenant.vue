<template>
    <div class="border-x border-b p-2">
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
                    <tr class="tr" v-if="!tenantUsertype.length">
                        <td colspan="3" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(type, i) in tenantUsertype" :key="i" class="tr">
                        <td class="td uppercase">{{ type.usertype }}</td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    type.status == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(type)"
                                    size="small"
                                    :type="
                                        type.status == 1 ? 'success' : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        type.status == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td text-center">
                            <Tooltip content="Edit " placement="bottom">
                                <Button
                                    @click="editInfo(type)"
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
            :title="editMode ? 'Edit Usertype' : 'Add Usertype'"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="100">
                <FormItem label="Usertype">
                    <Input type="text" v-model="form.usertype" />
                    <Error
                        :message="errors.usertype[0]"
                        v-if="errors.usertype"
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
import { mapActions, mapState } from "vuex";
export default {
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Usertype",
                name: "bu",
                class: "text-left"
            },
            {
                label: "Status",
                name: "stat",
                class: "text-center w-40"
            },
            {
                label: "Action",
                name: "action",
                class: "text-center w-24"
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
            editMode: false,
            loading: true,
            form: {
                id: "",
                usertype: "",
                type: "Tenant"
            },
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination"]),
        ...mapState("Usertype", ["tenantUsertype"])
    },
    methods: {
        ...mapActions("Usertype", [
            "getUserType",
            "addTenantUsertype",
            "updateTenantUsertype",
            "updateStatus"
        ]),
        changeStatus(type) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: type.id,
                        status: type.status,
                        type: "Tenant"
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        editInfo(type) {
            this.reset();
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = type.id;
            this.form.usertype = type.usertype;
        },
        update() {
            this.updateTenantUsertype({
                id: this.form.id,
                usertype: this.form.usertype
            });
        },
        create() {
            this.addTenantUsertype({
                usertype: this.form.usertype,
                type: "Tenant"
            });
        },

        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        reset() {
            this.editMode = false;
            this.form.usertype = "";
            this.form.type = "";
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                type: "Tenant"
            };
            this.getUserType({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
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
        Fire.$on("reload_tenant_usertype", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>

<style></style>
