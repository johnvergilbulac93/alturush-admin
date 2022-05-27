<template>
    <div class="space-y-2">
        <module-header icon="ios-basket-outline" title="Tenant(s) Order " />
        <div class="border p-2 space-y-2">
            <div class="flex justify-between items-center">
                <Select
                    v-model="filter.store"
                    @on-change="fetch"
                    placeholder="Choose a store"
                    style="width: 256px"
                >
                    <Option value="all">ALL STORE</Option>
                    <Option
                        v-for="(store, i) in Stores"
                        :value="store.bunit_code"
                        :key="i"
                    >
                        {{ store.business_unit }}
                    </Option>
                </Select>
                <DatePicker
                    @on-change="fetch()"
                    v-model="filter.dateNow"
                    type="date"
                    placeholder="Select Date"
                    style="width: 218px"
                ></DatePicker>
            </div>
            <div class="border rounded  ">
                <table class="min-w-full ">
                    <thead class="tracking-normal border-b   ">
                        <tr>
                            <th class="text-left">Store</th>
                            <th class="text-left">Tenant</th>
                            <th class="">
                                Total Orders
                            </th>
                            <th class=" text-right">
                                Total Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr
                            v-for="(detail, i) in TenantOrders"
                            :key="i"
                            class="tr "
                        >
                            <td class="td text-left">
                                {{ detail.tenant_data.acroname }}
                            </td>
                            <td class="td text-left">
                                {{ detail.tenant_data.tenant }}
                            </td>
                            <td class="td text-center">
                                <Badge
                                    :count="totalOrders(detail.orders)"
                                    type="success"
                                >
                                    <Tooltip content="Orders" placement="left">
                                        <Button
                                            type="success"
                                            :disabled="
                                                !totalOrders(detail.orders)
                                            "
                                            @click="viewDetail(detail)"
                                            size="small"
                                            icon="ios-basket-outline"
                                        />
                                    </Tooltip>
                                </Badge>
                            </td>
                            <td class="td text-right">
                                {{ detail.total_amt }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Modal
            :title="selected_tenant"
            v-model="modal"
            :styles="{ top: '40px' }"
            width="60%"
            footer-hide
            :mask-closable="false"
        >
            <div class="border rounded  ">
                <table class="min-w-full ">
                    <thead class="tracking-normal border-b   ">
                        <tr>
                            <th class="text-left">Ticket ID.</th>
                            <th class="text-left">Customer Name</th>
                            <th class="text-right">Amount Order</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr
                            v-for="(data, i) in order_list"
                            :key="i"
                            class="tr "
                        >
                            <td class="td text-left">
                                {{ data.tdata.ticket }}
                            </td>
                            <td class="td text-left">
                                {{
                                    data.tdata.lastname +
                                        ", " +
                                        data.tdata.firstname
                                }}
                            </td>
                            <td class="td text-right">
                                {{ totalOrder(data.items) | toCurrency2 }}
                            </td>
                            <td class="td text-right">
                                {{ data.discount | toCurrency2 }}
                            </td>
                            <td class="td text-right">
                                {{
                                    (totalOrder(data.items) - data.discount)
                                        | toCurrency2
                                }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot v-if="order_list.length">
                        <tr class="font-semibold">
                            <td colspan="2" class="text-center td">
                                Grand Total
                            </td>
                            <td class="text-right td">
                                {{ netTotalOrder() | toCurrency2 }}
                            </td>
                            <td class="text-right td">
                                {{ totalDiscount() | toCurrency2 }}
                            </td>
                            <td class="text-right td">
                                {{ netTotalOrder() - totalDiscount() | toCurrency2 }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </Modal>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    name: "Tenants-Order",
    data() {
        return {
            filter: {
                store: "all",
                dateNow: ""
            },
            modal: false,
            selected_tenant: "",
            order_list: []
        };
    },
    computed: {
        ...mapState(["Stores"]),
        ...mapState("Order", ["TenantOrders"])
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapActions("Order", ["getTenantOrders"]),
        totalOrder(data) {
            var total = 0;
            data.forEach(d => {
                total += parseFloat(d.total_price);
            });
            return total;
        },
        netTotalOrder() {
            var tot_amt = 0;
            this.order_list.forEach(t_data => {
                t_data.items.forEach(d => {
                    tot_amt += parseFloat(d.total_price);
                });
            });
            return tot_amt;
        },
        totalDiscount() {
            var tot_disc = 0;
            this.order_list.forEach(d => {
                tot_disc += parseFloat(d.discount);
            });
            return tot_disc;
        },
        viewDetail(detail) {
            this.modal = true;
            this.selected_tenant =
                detail.tenant_data.acroname + " - " + detail.tenant_data.tenant;
            this.order_list = Object.values(detail.orders);
        },
        totalOrders(orders) {
            return Object.keys(orders).length;
        },
        fetch() {
            let payload = {
                store: this.filter.store,
                date: moment(this.filter.dateNow).format("YYYY-MM-DD")
            };
            this.getTenantOrders(payload);
        }
    },
    mounted() {
        this.fetch();
        this.getStore();
    },
    beforeMount() {
        this.filter.dateNow = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
    }
};
</script>
