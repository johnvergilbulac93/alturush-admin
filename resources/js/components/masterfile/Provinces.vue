<template>
    <div class="space-y-2">
        <module-header icon="md-pin" title="Province(s)" />
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
                        <tr class="tr" v-if="!Provinces.length">
                            <td
                                colspan="3"
                                class="td text-center font-semibold"
                            >
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(data, i) in Provinces" :key="i" class="tr">
                            <td class="td">{{ data.prov_name }}</td>
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
                                                data.prov_id,
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
            :title="!editMode ? 'Add Province' : 'Edit Province'"
            v-model="drawer"
            width="512"
        >
            <Form label-position="left" :label-width="100">
                <FormItem label="Province" :required="!editMode">
                    <Input v-model="form.province" />
                    <Error
                        :message="errors.province[0]"
                        v-if="errors.province"
                    />
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
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Province",
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
                province: ""
            },
            editMode: false,
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination"]),
        ...mapState("Province", ["Provinces"])
    },
    methods: {
        ...mapActions("Province", [
            "getProvince",
            "saveProvince",
            "updateProvince",
            "updateStatus"
        ]),
        ...mapMutations(["CLEAR_ERRORS"]),
        reset() {
            this.form.id = "";
            this.form.province = "";
            this.CLEAR_ERRORS();
        },
        update() {
            this.updateProvince({
                id: this.form.id,
                province: this.form.province
            });
        },
        create() {
            this.saveProvince({
                province: this.form.province
            });
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
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
            this.drawer = !this.drawer;
            this.form.id = data.prov_id;
            this.form.province = data.prov_name;
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getProvince({
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
        Fire.$on("reload_province", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
