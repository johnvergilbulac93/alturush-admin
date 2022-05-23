<template>
    <div class="space-y-2">
        <module-header icon="md-pin" title="Town(s)" />
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
                        <tr class="tr" v-if="!Towns.length">
                            <td
                                colspan="3"
                                class="td text-center font-semibold"
                            >
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(data, i) in Towns" :key="i" class="tr">
                            <td class="td">{{ data.prov_name }}</td>
                            <td class="td">{{ data.town_name }}</td>

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
                                                data.town_id,
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
        </div>
        <Drawer
            :title="!editMode ? 'Add Town' : 'Edit Town'"
            v-model="drawer"
            width="512"
        >
            <Form label-position="left" :label-width="100">
                <FormItem label="Province">
                    <Select
                        placeholder="Please select a province"
                        v-model="form.province"
                    >
                        <Option
                            :value="data.prov_id"
                            v-for="(data, i) in Provinces"
                            :key="i"
                            >{{ data.prov_name }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.province[0]"
                        v-if="errors.province"
                    />
                </FormItem>
                <FormItem label="Town">
                    <Input v-model="form.town" placeholder="Town name" />
                    <Error :message="errors.town[0]" v-if="errors.town" />
                </FormItem>
                <FormItem label="Zipcode">
                    <Input v-model="form.zipcode" placeholder="Zipcode" />
                    <Error :message="errors.zipcode[0]" v-if="errors.town" />
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
                name: "prov",
                class: "text-left w-1/4"
            },
            {
                label: "Town",
                name: "town",
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
                town: "",
                province: "",
                zipcode: ""
            },
            editMode: false,
            currentPage: 1,
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination", "Provinces"]),
        ...mapState("Town", ["Towns"])
    },
    methods: {
        ...mapActions("Town", [
            "getTowns",
            "saveTown",
            "updateTown",
            "updateStatus"
        ]),
        ...mapActions(["getProvince"]),
        ...mapMutations(["CLEAR_ERRORS"]),
        reset() {
            this.form.id = "";
            this.form.province = "";
            this.form.town = "";
            this.form.zipcode = "";
            this.CLEAR_ERRORS();
        },
        update() {
            this.updateTown({
                id: this.form.id,
                province: this.form.province,
                town: this.form.town,
                zipcode: this.form.zipcode
            });
        },
        create() {
            this.saveTown({
                province: this.form.province,
                town: this.form.town,
                zipcode: this.form.zipcode
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
            this.form.id = data.town_id;
            this.form.province = data.prov_id;
            this.form.town = data.town_name;
            this.form.zipcode = data.zipcode;
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getTowns({
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
        Fire.$on("reload_town", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
        this.getProvince();
    }
};
</script>
