<template>
    <div class="space-y-2">
        <module-header icon="ios-copy" title="Global Categories" />
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
                        <tr class="tr" v-if="!GCategories.length">
                            <td colspan="5" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            class="tr"
                            v-for="(category, i) in GCategories"
                            :key="i"
                        >
                            <td class="td">{{ category.category }}</td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        category.delivery == 1
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="
                                            changeStatus(
                                                category.id,
                                                category.delivery,
                                                'delivery'
                                            )
                                        "
                                        size="small"
                                        :type="
                                            category.delivery == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            category.delivery == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        category.pick_up == 1
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        size="small"
                                        @click="
                                            changeStatus(
                                                category.id,
                                                category.pick_up,
                                                'pickup'
                                            )
                                        "
                                        :type="
                                            category.pick_up == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            category.pick_up == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        category.status == 1
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        size="small"
                                        @click="
                                            changeStatus(
                                                category.id,
                                                category.status,
                                                'status'
                                            )
                                        "
                                        :type="
                                            category.status == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            category.status == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(category)"
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
            :title="
                editMode ? 'Edit Global Categories' : 'Add Global Categories'
            "
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Category name">
                    <Input type="text" v-model="form.category" />
                    <Error
                        :message="errors.category[0]"
                        v-if="errors.category"
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
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Category",
                name: "group",
                class: "text-left w-1/2"
            },
            {
                label: "Delivery Status  ",
                name: "d_stat",
                class: "text-center"
            },
            {
                label: "Pick-up Status ",
                name: "p_status",
                class: "text-center "
            },
            {
                label: "Status ",
                name: "stat",
                class: "text-center"
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
            editMode: false,
            form: {
                id: "",
                category: ""
            },
            currentPage: 1,
            image: null,
            preview: null,
            drawer: false,
            url: ""
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination"]),
        ...mapState("GCat", ["GCategories"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions("GCat", [
            "getGlobalCat",
            "saveGlobalCat",
            "updateGlobalCat",
            "updateStatus"
        ]),
        update() {
            this.updateGlobalCat({
                id: this.form.id,
                category: this.form.category
            });
        },
        create() {
            this.saveGlobalCat({
                category: this.form.category
            });
        },
        editInfo(category) {
            this.reset();
            this.editMode = true;
            this.form.id = category.id;
            this.form.category = category.category;
            this.drawer = !this.drawer;
        },
        changeStatus(id, status, type) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: id,
                        status: status,
                        type: type
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
        reset() {
            this.form.id = "";
            this.form.category = "";
            this.CLEAR_ERRORS();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getGlobalCat({
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
        Fire.$on("reload_global_cat", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
