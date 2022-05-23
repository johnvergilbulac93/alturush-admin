<template>
    <div class="space-y-2">
        <module-header icon="md-basket" title="Tenant Order Detail(s)" />
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
            <div class="border rounded">
                <table class="min-w-full ">
                    <thead class="tracking-normal border-b ">
                        <tr>
                            <th class="p-2  text-left">Store</th>
                            <th class="p-2  text-left">Tenant</th>
                            <th class="p-2  text-right">
                                Order Total Amt.
                            </th>
                            <th class="p-2  text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr
                            v-for="(detail, i) in TenantOrderDetails"
                            :key="i"
                            class="tr "
                        >
                            <td class="td text-left">
                                {{ detail.tenant_data.business_unit }}
                            </td>
                            <td class="td text-left">
                                {{ detail.tenant_data.tenant }}
                            </td>
                            <td class="td text-right">
                                {{ detail.total_amt }}
                            </td>
                            <td class="td text-center">
                                <Tooltip content="Preview" placement="bottom">
                                    <Button
                                        @click="viewData(detail)"
                                        type="primary"
                                        shape="circle"
                                        size="small"
                                        icon="ios-menu"
                                        :disabled="detail.orders == 0"
                                    ></Button>
                                </Tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Modal
            :title="selected_tenant"
            v-model="flag"
            :styles="{ top: '40px' }"
            width="60%"
            footer-hide
            :mask-closable="false"
        >
            <SelectedTenantOrders
                :order_list="order_list"
                :tenant="selected_tenant"
            />
        </Modal>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import SelectedTenantOrders from "./ExtendedComponent/SelectedTenantOrders.vue";
export default {
    name: "TenantOrderDetails",
    components: { SelectedTenantOrders },
    data() {
        return {
            filter: {
                store: "all",
                dateNow: ""
            },
            order_list: null,
            selected_tenant: "",
            flag: false
        };
    },
    computed: {
        ...mapState(["Stores"]),
        ...mapState("Report", ["TenantOrderDetails"])
    },
    methods: {
        ...mapActions(["getStore"]),
        ...mapActions("Report", ["getTenantOrderDetails"]),

        fetch() {
            this.getTenantOrderDetails({
                store: this.filter.store,
                date: moment(this.filter.dateNow).format("YYYY-MM-DD")
            });
        },
        viewData(detail) {
            this.flag = true;
            this.selected_tenant = `${detail.tenant_data.tenant} - ${detail.tenant_data.acroname}`;
            this.order_list = detail.orders;
        }
    },
    mounted() {
        this.getStore();
        this.fetch();
    },
    beforeMount() {
        this.filter.dateNow = moment(this.$root.serverDateTime).format(
            "YYYY-MM-DD"
        );
    }
};
</script>
