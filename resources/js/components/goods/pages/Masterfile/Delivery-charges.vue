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
                    <tr class="tr" v-if="!ChargeGoods.length">
                        <td colspan="8" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(charge, i) in ChargeGoods" :key="i" class="tr">
                        <td class="td">{{ charge.prov_name }}</td>
                        <td class="td">{{ charge.town_name }}</td>
                        <td class="td">
                            {{ !charge.brgy ? "" : charge.brgy.brgy_name }}
                        </td>
                        <td class="td">{{ charge.transpo_name }}</td>
                        <td class="td text-center">
                            {{ charge.charge_amt | toCurrency2 }}
                        </td>
                        <td class="td text-center">
                            {{ charge.rider_shared | toCurrency2 }}
                        </td>

                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    charge.status == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(charge)"
                                    size="small"
                                    :type="
                                        charge.status == 1 ? 'success' : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        charge.status == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td text-center">
                            <Tooltip content="Edit" placement="bottom">
                                <Button
                                    @click="editInfo(charge)"
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
            :title="editMode ? 'Edit Delivery Charges' : 'Add Delivery Charges'"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Province">
                    <Select
                        @on-change="filteredTown"
                        placeholder="Please select a province"
                        v-model="form.province"
                    >
                        <Option value>Select a province</Option>
                        <Option
                            :value="prov.prov_id"
                            v-for="(prov, i) in Provinces"
                            :key="i"
                            >{{ prov.prov_name }}
                        </Option>
                    </Select>
                    <Error
                        :message="errors.province[0]"
                        v-if="errors.province"
                    />
                </FormItem>
                <FormItem label="Town">
                    <Select
                        placeholder="Please select a town"
                        v-model="form.town"
                        v-if="editMode"
                        filterable
                    >
                        <Option value>Select a town</Option>
                        <Option
                            :value="town.town_id"
                            v-for="(town, index) in Towns"
                            :key="index"
                            >{{ town.town_name }}
                        </Option>
                    </Select>
                    <Select
                        @on-change="filteredBrgy"
                        placeholder="Please select a town"
                        v-model="form.town"
                        v-if="!editMode"
                        filterable
                        :disabled="!filterTowns.length"
                    >
                        <Option value>Select a town</Option>
                        <Option
                            :value="town.town_id"
                            v-for="(town, index) in filterTowns"
                            :key="index"
                            >{{ town.town_name }}</Option
                        >
                    </Select>
                    <Error :message="errors.town[0]" v-if="errors.town" />
                </FormItem>
                <FormItem label="Barangay">
                    <Select
                        placeholder="Please select a barangay"
                        v-if="editMode"
                        v-model="form.barangay"
                        filterable
                    >
                        <Option value>Select Barangay</Option>
                        <Option
                            :value="brgy.brgy_id"
                            v-for="(brgy, index) in Barangays"
                            :key="index"
                            >{{ brgy.brgy_name }}</Option
                        >
                    </Select>
                    <Select
                        placeholder="Please select a barangay"
                        v-if="!editMode"
                        v-model="form.barangay"
                        filterable
                        :disabled="!filterBarangays.length"
                    >
                        <Option value>Select Barangay</Option>
                        <Option
                            :value="brgy.brgy_id"
                            v-for="(brgy, index) in filterBarangays"
                            :key="index"
                            >{{ brgy.brgy_name }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.barangay[0]"
                        v-if="errors.barangay"
                    />
                </FormItem>
                <FormItem label="Delivery Charge">
                    <InputNumber
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="form.charge_amount"
                        style="width: 100%;"
                    />
                    <Error
                        :message="errors.charge_amount[0]"
                        v-if="errors.charge_amount"
                    />
                </FormItem>
                <FormItem label="Convenience Fee">
                    <InputNumber
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="form.rider_share"
                        style="width: 100%;"
                    />
                    <Error
                        :message="errors.rider_share[0]"
                        v-if="errors.rider_share"
                    />
                </FormItem>
                <FormItem label="Vehicle Type">
                    <Select
                        placeholder="Please select a vehicle type"
                        v-model="form.transportation"
                        filterable
                    >
                        <Option value>Select a vehicle</Option>
                        <Option
                            :value="transpo.id"
                            v-for="(transpo, index) in Transportations"
                            :key="index"
                            >{{ transpo.transpo_name }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.transportation[0]"
                        v-if="errors.transportation"
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
    name: "Delivery-Charge-Goods",
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Province",
                name: "prov_id",
                class: "text-left"
            },
            {
                label: "Town",
                name: "town_id",
                class: "text-left"
            },
            {
                label: "Barangay",
                name: "brgy_id",
                class: "text-left"
            },
            {
                label: "Vehicle Type",
                name: "transpo_id",
                class: "text-left"
            },
            {
                label: "Delivery Charge",
                name: "charge_amt",
                class: "text-center"
            },
            {
                label: "Convenience Fee",
                name: "c_fee",
                class: "text-center"
            },
            {
                label: "Status",
                name: "statuss",
                class: "text-center"
            },
            {
                label: "Action",
                name: "asd",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            editMode: false,
            columns: columns,
            sortKey: "id",
            sortOrders: sortOrders,
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "desc"
            },
            form: {
                id: "",
                province: "",
                town: "",
                barangay: "",
                transportation: "",
                charge_amount: 0,
                rider_share: 0,
                status: ""
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
            "Provinces",
            "filterTowns",
            "filterBarangays",
            "Transportations",
            "Towns",
            "Barangays"
        ]),
        ...mapState("Charges", ["ChargeGoods"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions(["townFiltered", "brgyFiltered"]),
        ...mapActions("Charges", [
            "getChargeGoods",
            "saveChargeGoods",
            "updateChargeGoods",
            "changeStatusChargeGoods"
        ]),
        changeStatus(data) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeStatusChargeGoods({
                        status: data.status,
                        id: data.chrg_id
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        reset() {
            this.form.id = "";
            this.form.province = "";
            this.form.town = "";
            this.form.barangay = "";
            this.form.transportation = "";
            this.form.rider_share = 0;
            this.form.charge_amount = 0;
            this.CLEAR_ERRORS();
        },
        filteredTown() {
            this.townFiltered({ prov_id: this.form.province });
        },
        filteredBrgy() {
            this.brgyFiltered({ town_id: this.form.town });
        },
        editInfo(charge) {
            this.reset();
            this.editMode = true;
            this.drawer = true;
            this.form.id = charge.chrg_id;
            this.form.province = charge.prov_id;
            this.form.town = charge.town_id;
            this.form.barangay = charge.brgy_id;
            this.form.transportation = charge.transpo_id;
            this.form.charge_amount = parseFloat(charge.charge_amt);
            this.form.rider_share = parseFloat(charge.rider_shared);
            this.form.status = charge.status;
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        update() {
            this.updateChargeGoods({
                id: this.form.id,
                province: this.form.province,
                town: this.form.town,
                barangay: this.form.barangay,
                transportation: this.form.transportation,
                charge_amount: this.form.charge_amount,
                rider_share: this.form.rider_share
            });
        },
        create() {
            this.saveChargeGoods({
                province: this.form.province,
                town: this.form.town,
                barangay: this.form.barangay,
                transportation: this.form.transportation,
                charge_amount: this.form.charge_amount,
                rider_share: this.form.rider_share
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
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getChargeGoods({
                currentPage: this.currentPage,
                filterData: filterData
            });
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
        Fire.$on("reload_charges_goods", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
