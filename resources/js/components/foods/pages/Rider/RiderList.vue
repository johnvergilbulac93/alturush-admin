<template>
    <div class="space-y-2">
        <module-header icon="ios-bicycle" title="Rider List(s)" />
        <div class="border p-2 space-y-2">
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
                    <tr class="tr" v-if="!Riders.length">
                        <td colspan="4" class="td text-center font-semibold">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(data, i) in Riders" :key="i" class="tr">
                        <td class="td">
                            {{ data.r_lastname + " " + data.r_firstname }}
                        </td>

                        <td class="td text-center">{{ data.r_gender }}</td>

                        <td class="td text-center">
                            <Badge
                                :status="data.status == 1 ? 'success' : 'error'"
                                :text="data.status == 1 ? 'Active' : 'Inactive'"
                            />
                        </td>

                        <td class="td text-center">
                            <Tooltip content="Edit" placement="right">
                                <Button
                                    @click="viewDetail(data)"
                                    type="primary"
                                    shape="circle"
                                    size="small"
                                    icon="ios-open-outline"
                                />
                            </Tooltip>
                        </td>
                    </tr>
                </Datatable>

                <Pagination
                    :pagination="pagination"
                    @prev="previousPage(pagination.prevPageUrl)"
                    @next="nextPage(pagination.nextPageUrl)"
                />
            </div>
        </div>
        <Modal
            title="Rider Details"
            v-model="modal"
            :styles="{ top: '40px' }"
            width="60%"
            footer-hide
        >
            <RiderInfo :infos="infos" />
        </Modal>
    </div>
</template>

<script>
import RiderInfo from "./ExtendedComponent/RiderInfo.vue";
import { mapActions, mapState } from "vuex";

export default {
    name: "Rider-Lists",
    components: { RiderInfo },
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Fullname",
                name: "name",
                class: "text-left w-1/2"
            },
            {
                label: "Gender",
                name: "gender",
                class: "text-center "
            },
            {
                label: "Status",
                name: "stat",
                class: "text-center  "
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
                barangay: ""
            },
            editMode: false,
            currentPage: 1,
            modal: false,
            infos: null
        };
    },
    computed: {
        ...mapState(["perPage", "pagination"]),
        ...mapState("Rider", ["Riders"])
    },
    methods: {
        ...mapActions("Rider", ["getRiderLists", "getLiabilities"]),
        viewDetail(data) {
            this.modal = true;
            this.infos = data;
            this.getLiabilities({ rider_id: data.id });
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getRiderLists({
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
        this.fetch();
    }
};
</script>
