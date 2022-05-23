<template>
    <div class="space-y-2">
        <module-header icon="ios-cube" title="Business Unit(s) Group" />
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
                        <tr class="tr" v-if="!BuGroup.length">
                            <td colspan="3" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(group, i) in BuGroup" :key="i" class="tr">
                            <td class="td">{{ group.bunit_group }}</td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        group.status == 1
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatus(group)"
                                        size="small"
                                        :type="
                                            group.status == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            group.status == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>

                            <td class="td text-center">
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(group)"
                                        type="primary"
                                        shape="circle"
                                        size="small"
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
                :title="editMode ? 'Edit Group' : 'Add Group'"
                v-model="drawer"
                width="512"
                :closable="false"
            >
                <Form :model="form" label-position="left" :label-width="100">
                    <FormItem label="Group name">
                        <Input type="text" v-model="form.group" />
                        <Error :message="errors.group[0]" v-if="errors.group" />
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
                label: "Group Name",
                name: "gname",
                class: "text-left"
            },
            {
                label: "Status ",
                name: "stat",
                class: "text-center w-24"
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
                group: ""
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
        ...mapState(["errors", "perPage", "pagination", "isModal"]),
        ...mapState("B_Group", ["BuGroup"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions(["modal"]),
        ...mapActions("B_Group", [
            "getBuGroup",
            "createGroup",
            "updateGroup",
            "updateStatus"
        ]),
        changeStatus(group) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: group.id,
                        status: group.status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        editInfo(group) {
            this.reset();
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = group.id;
            this.form.group = group.bunit_group;
        },
        update() {
            this.updateGroup({
                id: this.form.id,
                group: this.form.group
            });
        },
        create() {
            this.createGroup({
                group: this.form.group
            });
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        reset() {
            this.editMode = false;
            (this.form.id = ""), (this.form.group = "");
            this.CLEAR_ERRORS();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getBuGroup({
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
        Fire.$on("reload_group", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
