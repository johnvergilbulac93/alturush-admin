<template>
    <div class="border rounded p-2">
        <div class="flex justify-end">
            <Tooltip content="Add User" placement="right">
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
                    <tr class="tr" v-if="!GoodUser.length">
                        <td colspan="7" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(user, i) in GoodUser" :key="i" class="tr">
                        <td class="td uppercase">{{ user.name }}</td>
                        <td class="td">{{ user.username }}</td>
                        <td class="td">{{ user.business_unit }}</td>
                        <td class="td text-center">
                            {{ user.created_at | formatDateNoTime }}
                        </td>
                        <td
                            class="td text-center"
                            v-if="user.inactivity_date != null"
                        >
                            {{ user.inactivity_date | formatDateNoTime }}
                        </td>
                        <td class="td text-center" v-else></td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    user.status == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(user)"
                                    size="small"
                                    :type="
                                        user.status == 1 ? 'success' : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        user.status == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td text-center">
                            <div class="flex gap-1 items-center justify-center">
                                <Tooltip
                                    content="Reset Password"
                                    placement="bottom"
                                >
                                    <Button
                                        @click="resetPassword(user.id)"
                                        type="primary"
                                        size="small"
                                        shape="circle"
                                        icon="md-key"
                                    />
                                </Tooltip>

                                <Tooltip content="Edit User" placement="bottom">
                                    <Button
                                        @click="editInfo(user)"
                                        type="primary"
                                        size="small"
                                        shape="circle"
                                        icon="ios-open-outline"
                                    />
                                </Tooltip>
                            </div>
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
            :title="!editMode ? 'Add User' : 'Update User'"
            v-model="drawer"
            width="512"
        >
            <Form :model="form" label-position="left" :label-width="100">
                <FormItem label="Name">
                    <div class="w-full relative">
                        <Input
                            search
                            @on-change="autoComplete"
                            v-model="form.name"
                            clearable
                            type="text"
                        />
                        <Error :message="errors.name[0]" v-if="errors.name" />

                        <div
                            class="w-full h-auto mt-1 bg-gray-50 absolute shadow-lg rounded z-50"
                            v-if="Employees.length"
                        >
                            <span
                                class="hover:bg-gray-200 block cursor-pointer p-1 overflow-hidden"
                                @click="selectEmp(employee)"
                                v-for="employee in Employees"
                                :key="employee.id"
                                >{{ employee.name }}</span
                            >
                        </div>
                    </div>
                </FormItem>
                <FormItem label="Employee ID">
                    <Input type="text" v-model="form.employee_id" disabled />
                </FormItem>
                <FormItem label="Username">
                    <Input type="text" v-model="form.username" />
                    <Error
                        :message="errors.username[0]"
                        v-if="errors.username"
                    />
                </FormItem>
                <FormItem label="Usertype">
                    <Select
                        v-model="form.usertype"
                        placeholder="Please select a usertype"
                    >
                        <Option
                            :value="type.id"
                            v-for="(type, i) in UserTypes"
                            :key="i"
                            >{{ type.usertype }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.usertype[0]"
                        v-if="errors.usertype"
                    />
                </FormItem>
                <FormItem label="Store">
                    <Select
                        v-model="form.store"
                        placeholder="Please select a store"
                    >
                        <Option value>Select Store</Option>
                        <Option
                            :value="store.bunit_code"
                            v-for="(store, i) in Stores"
                            :key="i"
                            >{{ store.business_unit }}</Option
                        >
                    </Select>
                    <Error :message="errors.store[0]" v-if="errors.store" />
                </FormItem>
                <FormItem label="Password">
                    <Input type="text" v-model="form.password" />
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
import _ from "lodash";

export default {
    data() {
        let sortOrders = {};
        let columns = [
            {
                width: "25%",
                label: "Full Name",
                name: "name",
                class: "text-left"
            },
            {
                width: "25%",
                label: "User Name",
                name: "uname",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Location",
                name: "loc",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Registered Date",
                name: "reg_date",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Date of Inactivity",
                name: "inactive_date",
                class: "text-center"
            },
            {
                width: "20%",
                label: "Status",
                name: "stat",
                class: "text-center"
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
            // start pagination
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
            searchEmployee: "",
            selectedData: false,
            form: {
                id: "",
                name: "",
                username: "",
                usertype: "",
                password: "",
                store: "",
                employee_id: ""
            },
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState([
            "errors",
            "perPage",
            "pagination",
            "isModal",
            "UserTypes",
            "Employees",
            "Stores",
            "isSuccess"
        ]),
        ...mapState("User", ["GoodUser"])
    },
    methods: {
        ...mapActions([
            "userType",
            "getStore",
            "modal",
            "getEmployee",
            "deleteUser"
        ]),
        ...mapActions("User", [
            "getGoodUser",
            "saveGoodsUser",
            "updateGoodsUser",
            "changeGoodUserStatus",
            "goodsResetPass"
        ]),
        ...mapMutations(["CLEAR_EMPLOYEE", "MODAL_FLAG"]),
        resetPassword(id) {
            swal.fire({
                title: "Are you sure",
                text: "you want to reset the password of this user?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Continue!"
            }).then(result => {
                if (result.isConfirmed) {
                    this.goodsResetPass({ id: id });
                }
            });
        },
        changeStatus(data) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeGoodUserStatus({
                        id: data.id,
                        status: data.status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        reset() {
            this.form.name = "";
            this.form.employee_id = "";
            this.form.store = "";
            this.form.username = "";
            this.form.usertype = "";
            this.errors.name = "";
            this.errors.store = "";
            this.errors.usertype = "";
            this.errors.username = "";
            this.errors.password = "";
            this.errors.employee_id = "";
            this.form.password = "";
            document.querySelector("body").style.overflow = "visible";
            this.editMode = false;
        },
        update() {
            let payload = {
                id: this.form.id,
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype,
                emp_id: this.form.employee_id,
                store: this.form.store,
                password: this.form.password
            };
            this.updateGoodsUser(payload);
        },
        create() {
            let payload = {
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype,
                emp_id: this.form.employee_id,
                store: this.form.store,
                password: this.form.password
            };
            this.saveGoodsUser(payload);
        },
        clearSearchEmployee() {
            this.CLEAR_EMPLOYEE();
        },
        addModal() {
            this.editMode = false;
            this.reset();
            this.drawer = !this.drawer;
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        editInfo(user) {
            this.reset();
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = user.id;
            this.form.name = user.name;
            this.form.username = user.username;
            this.form.store = user.bunit_code;
            this.form.employee_id = user.emp_id;
            this.form.usertype = user.usertype_id;
        },
        remove(id) {
            this.deleteUser({ id: id });
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
                column: this.tableData.column
            };
            this.getGoodUser({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        selectEmp(employee) {
            this.form.name = employee.name;
            this.form.employee_id = employee.emp_id;
            this.form.username = employee.emp_id;
            this.CLEAR_EMPLOYEE();
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        autoComplete() {
            setTimeout(() => {
                this.getEmployee({
                    employee: this.form.name
                });
            }, 500);
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
        Fire.$on("reload_good_user", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
        this.userType();
        this.getStore();
    }
};
</script>
