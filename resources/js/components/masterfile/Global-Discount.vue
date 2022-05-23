<template>
    <div class="space-y-2">
        <module-header icon="md-trending-down" title="Global Discount" />
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
                        <tr class="tr" v-if="!GlobalDisc.length">
                            <td colspan="4" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>

                        <tr class="tr" v-for="(disc, i) in GlobalDisc" :key="i">
                            <td class="td">{{ disc.category }}</td>
                            <td class="td">{{ disc.discount_name }}</td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        disc.global_disc_stat == 1
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatus(disc)"
                                        size="small"
                                        :type="
                                            disc.global_disc_stat == 1
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            disc.global_disc_stat == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(disc)"
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
            :title="editMode ? 'Edit Global Discount' : 'Add Global Discount'"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Global Category ">
                    <Select
                        v-model="form.global_category"
                        placeholder="Please select a global category"
                    >
                        <Option value>Select here</Option>
                        <Option
                            :value="data.id"
                            v-for="(data, i) in GlobalCategory"
                            :key="i"
                            >{{ data.category }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.global_category[0]"
                        v-if="errors.global_category"
                    />
                </FormItem>
                <FormItem label="Discount name">
                    <Select
                        v-model="form.discount_name"
                        placeholder="Please select a discount name"
                    >
                        <Option value>Select here</Option>
                        <Option
                            :value="data.id"
                            v-for="(data, i) in Disc"
                            :key="i"
                            >{{ data.discount_name }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.discount_name[0]"
                        v-if="errors.discount_name"
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
                label: "Global Category ",
                name: "gcat",
                class: "text-left w-1/2"
            },
            {
                label: "Discount Name ",
                name: "disc",
                class: "text-left"
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
                dir: "asc"
            },
            editMode: false,
            form: {
                id: "",
                discount_name: "",
                global_category: ""
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
            "Disc",
            "GlobalCategory"
        ]),
        ...mapState("GlobalDisc", ["GlobalDisc"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions("GlobalDisc", [
            "getGlobalDisc",
            "saveGlobalDisc",
            "updateGlobalDisc",
            "updateStatus"
        ]),
        ...mapActions(["getDiscount", "getGlobalCategory"]),
        update() {
            this.updateGlobalDisc({
                id: this.form.id,
                discount: this.form.discount_name,
                global_category: this.form.global_category
            });
        },
        create() {
            this.saveGlobalDisc({
                global_category: this.form.global_category,
                discount: this.form.discount_name
            });
        },
        changeStatus(disc) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: disc.global_disc_id,
                        status: disc.global_disc_stat
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        editInfo(disc) {
            this.reset();
            this.editMode = true;
            this.form.id = disc.global_disc_id;
            this.form.discount_name = disc.discount_id;
            this.form.global_category = disc.global_cat_id;
            this.drawer = !this.drawer;
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getGlobalDisc({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        reset() {
            this.form.id = "";
            (this.form.discount_name = ""), (this.form.global_category = "");
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
        Fire.$on("reload_global_disc", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
        this.getDiscount();
        this.getGlobalCategory();
    }
};
</script>
