<template>
    <div class="space-y-2">
        <module-header icon="ios-clock" title="Business Unit(s) Time " />
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
                        <tr class="tr" v-if="!BuTime.length">
                            <td colspan="5" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(time, i) in BuTime" :key="i" class="tr">
                            <td class="td">{{ time.business_unit }}</td>
                            <td class="td text-center">
                                {{ time.time_in | formatTime2 }}
                            </td>
                            <td class="td text-center">
                                {{ time.time_out | formatTime2 }}
                            </td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        time.status == 1 ? 'Active' : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatus(time)"
                                        size="small"
                                        :type="
                                            time.status == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            time.status == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip content="Edit " placement="bottom">
                                    <Button
                                        @click="editInfo(time)"
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
                :title="editMode ? 'Edit Business Time' : 'Add Business Time'"
                v-model="drawer"
                width="512"
                :closable="false"
            >
                <Form label-position="left" :label-width="150">
                    <FormItem label="Group">
                        <Select
                            placeholder="Please select a store"
                            v-model="form.store"
                        >
                            <Option value>Select a Store</Option>
                            <Option
                                :value="store.bunit_code"
                                v-for="store in Stores"
                                :key="store.bunit_code"
                                >{{ store.business_unit }}</Option
                            >
                        </Select>
                        <Error :message="errors.store[0]" v-if="errors.store" />
                    </FormItem>
                    <FormItem label="Opening Time">
                        <TimePicker
                            type="time"
                            v-model="form.opening"
                            style="width: 100%;"
                            placeholder="Select a time"
                            format="HH:mm "
                        />
                        <Error :message="errors.store[0]" v-if="errors.store" />
                    </FormItem>
                    <FormItem label="Closing Time">
                        <TimePicker
                            type="time"
                            v-model="form.closing"
                            placeholder="Select a time"
                            style="width: 100%;"
                            format="HH:mm "
                        />
                        <Error :message="errors.store[0]" v-if="errors.store" />
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
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
export default {
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Store",
                name: "store",
                class: "text-left"
            },
            {
                label: "Opening Time ",
                name: "opening",
                class: "text-center w-40 "
            },
            {
                label: "Closing Time ",
                name: "closing",
                class: "text-center w-40"
            },
            {
                label: "Status ",
                name: "status",
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
            form: {
                id: "",
                store: "",
                opening: "",
                closing: ""
            },
            currentPage: 1,
            image: null,
            preview: null,
            preview2: null,
            id: "",
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination", "isModal", "Stores"]),
        ...mapState("B_Time", ["BuTime"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions(["modal", "getStore"]),
        ...mapActions("B_Time", [
            "getBuTime",
            "addBuTime",
            "updateBuTime",
            "updateStatus"
        ]),
        changeStatus(time) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: time.id,
                        status: time.status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        update() {
            this.updateBuTime({
                id: this.form.id,
                store: this.form.store,
                opening: this.form.opening,
                closing: this.form.closing
            });
        },
        create() {
            this.addBuTime({
                store: this.form.store,
                opening: this.form.opening,
                closing: this.form.closing
            });
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        editInfo(time) {
            this.reset();
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = time.id;
            this.form.store = time.bunit_code;
            this.form.opening = time.time_in;
            this.form.closing = time.time_out;
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getBuTime({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        closeModal() {
            this.modal({
                flag: false
            });
            this.reset();
        },
        reset() {
            (this.form.id = ""),
                (this.form.store = ""),
                (this.form.opening = ""),
                (this.form.closing = "");
            this.editMode = false;
            this.CLEAR_ERRORS();
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
        Fire.$on("reload_bu_time", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
        this.getStore();
    }
};
</script>

<style></style>
