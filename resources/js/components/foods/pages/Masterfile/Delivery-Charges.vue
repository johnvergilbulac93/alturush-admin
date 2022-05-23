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
                    <tr class="tr" v-if="!ChargeFoods.length">
                        <td colspan="8" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(charge, i) in ChargeFoods" :key="i" class="tr">
                        <td class="td">{{ charge.prov_name }},</td>
                        <td class="td">{{ charge.town_name }}</td>
                        <td class="td">
                            {{
                                !charge.barangay
                                    ? ""
                                    : charge.barangay.brgy_name
                            }}
                        </td>
                        <td class="td">{{ charge.transpo_name }}</td>
                        <td class="td text-center">{{ charge.range_level }}</td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    charge.chrg_status == 1
                                        ? 'Active'
                                        : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(charge)"
                                    size="small"
                                    :type="
                                        charge.chrg_status == 1
                                            ? 'success'
                                            : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        charge.chrg_status == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td">
                            <div class="flex gap-1 items-center justify-center">
                                <Tooltip content="See more" placement="bottom">
                                    <Button
                                        @click="seeMore(charge)"
                                        size="small"
                                        type="primary"
                                        shape="circle"
                                        icon="ios-more"
                                    />
                                </Tooltip>
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(charge)"
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
                :pagination="pagination2"
                @prev="previousPage(pagination2.prevPageUrl)"
                @next="nextPage(pagination2.nextPageUrl)"
            />
        </div>
        <Modal
            title="Delivery Charge Information"
            v-model="modal"
            class-name="vertical-center-modal"
            width="500"
            footer-hide
        >
            <div class="flex justify-end items-center">
                <button
                    @click="gotoEdit(charge)"
                    class="text-blue-500 underline"
                >
                    Click here to edit
                </button>
            </div>
            <SeeMore :data="charge" />
        </Modal>

        <Drawer
            :title="editMode ? 'Edit Delivery Charges' : 'Add Delivery Charges'"
            v-model="drawer"
            width="512"
        >
            <Form label-position="left" :label-width="150">
                <FormItem label="Province">
                    <Select
                        @on-change="filteredTown"
                        placeholder="Please select a province"
                        v-model="form.province"
                        filterable
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
                            >{{ town.town_name }}</Option
                        >
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
                        v-model="form.delivery_charge"
                        style="width: 100%;"
                    />
                    <Error
                        :message="errors.customer_to_pay[0]"
                        v-if="errors.customer_to_pay"
                    />
                </FormItem>
                <FormItem label="Customer To Pay">
                    <InputNumber
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="form.customer_to_pay"
                        style="width: 100%;"
                    />
                    <Error
                        :message="errors.customer_to_pay[0]"
                        v-if="errors.customer_to_pay"
                    />
                </FormItem>
                <FormItem label="Fuel">
                    <InputNumber
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="form.fuel"
                        style="width: 100%;"
                    />
                    <Error :message="errors.fuel[0]" v-if="errors.fuel" />
                </FormItem>
                <FormItem label="Rider Share">
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
                        :message="errors.share_rider[0]"
                        v-if="errors.share_rider"
                    />
                </FormItem>
                <FormItem label="Admin Fee">
                    <InputNumber
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="form.admin_fee"
                        style="width: 100%;"
                    />
                    <Error
                        :message="errors.admin_fee[0]"
                        v-if="errors.admin_fee"
                    />
                </FormItem>
                <FormItem label="Expenses For Store">
                    <InputNumber
                        :formatter="
                            value =>
                                `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                        v-model="form.expense_for_store"
                        style="width: 100%;"
                    />
                    <Error
                        :message="errors.expense_for_store[0]"
                        v-if="errors.expense_for_store"
                    />
                </FormItem>
                <FormItem label="Range Level">
                    <Select
                        placeholder="Please select a range level"
                        v-model="form.range_level"
                        filterable
                    >
                        <Option value>Select a range level</Option>
                        <Option
                            :value="range.id"
                            v-for="(range, index) in RangeLevel"
                            :key="index"
                            >{{ range.range_level }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.range_level[0]"
                        v-if="errors.range_level"
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
import SeeMore from "./ExtendedComponent/Delivery-Charge-See-More.vue";
import { mapActions, mapState, mapMutations } from "vuex";
export default {
    name: "Delivery-Charge-Foods",
    components: { SeeMore },
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Province",
                name: "prov",
                class: "text-left"
            },
            {
                label: "Town",
                name: "town",
                class: "text-left"
            },
            {
                label: "Barangay",
                name: "brgy",
                class: "text-left"
            },

            {
                label: "Vehicle Type",
                name: "transpo_id",
                class: "text-left"
            },
            {
                label: "Range Level",
                name: "fuel",
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
                delivery_charge: 0,
                customer_to_pay: 0,
                fuel: 0,
                rider_share: 0,
                admin_fee: 0,
                expense_for_store: 0,
                range_level: "",
                transportation: ""
            },
            currentPage: 1,
            drawer: false,
            modal: false,
            charge: null
        };
    },
    computed: {
        ...mapState([
            "errors",
            "perPage",
            "pagination2",
            "Provinces",
            "filterTowns",
            "filterBarangays",
            "Transportations",
            "Towns",
            "Barangays",
            "RangeLevel"
        ]),
        ...mapState("Charges", ["ChargeFoods"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions("Charges", [
            "getChargeFoods",
            "saveChargeFoods",
            "updateChargeFoods",
            "changeStatusChargeGoods"
        ]),
        ...mapActions(["townFiltered", "brgyFiltered"]),
        changeStatus(charge) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeStatusChargeGoods({
                        id: charge.charg_id,
                        status: charge.chrg_status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        gotoEdit(charge) {
            this.modal = false;
            this.editInfo(charge);
        },
        seeMore(charge) {
            this.modal = true;
            this.charge = charge;
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        reset() {
            this.form.id = "";
            this.form.province = "";
            this.form.town = "";
            this.form.barangay = "";
            this.form.delivery_charge = 0;
            this.form.customer_to_pay = 0;
            this.form.fuel = 0;
            this.form.rider_share = 0;
            this.form.admin_fee = 0;
            this.form.expense_for_store = 0;
            this.form.range_level = "";
            this.form.transportation = "";
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
            this.form.id = charge.charg_id;
            this.form.province = charge.prov_id;
            this.form.town = charge.town_id;
            this.form.barangay = charge.brgy_id;
            this.form.delivery_charge = parseFloat(charge.charge_amt);
            this.form.customer_to_pay = parseFloat(charge.customer_to_pay);
            this.form.fuel = parseFloat(charge.fuel_amt);
            this.form.rider_share = parseFloat(charge.rider_share);
            this.form.admin_fee = parseFloat(charge.admin_fee);
            this.form.expense_for_store = parseFloat(charge.expenses_for_store);
            this.form.range_level = parseFloat(charge.range_id);
            this.form.transportation = charge.vtype_id;
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        update() {
            this.updateChargeFoods({
                id: this.form.id,
                province: this.form.province,
                town: this.form.town,
                barangay: this.form.barangay,
                delivery_charge: this.form.delivery_charge,
                customer_to_pay: this.form.customer_to_pay,
                fuel: this.form.fuel,
                rider_share: this.form.rider_share,
                admin_fee: this.form.admin_fee,
                expense_for_store: this.form.expense_for_store,
                range_level: this.form.range_level,
                transportation: this.form.transportation
            });
        },
        create() {
            this.saveChargeFoods({
                province: this.form.province,
                town: this.form.town,
                barangay: this.form.barangay,
                delivery_charge: this.form.delivery_charge,
                customer_to_pay: this.form.customer_to_pay,
                fuel: this.form.fuel,
                rider_share: this.form.rider_share,
                admin_fee: this.form.admin_fee,
                expense_for_store: this.form.expense_for_store,
                range_level: this.form.range_level,
                transportation: this.form.transportation
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
            this.getChargeFoods({
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
        Fire.$on("reload_charges_foods", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
