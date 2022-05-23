<template>
    <div>
        <div class="border rounded">
            <table class="min-w-full ">
                <thead class="tracking-normal border-b">
                    <tr>
                        <th class="p-2  text-left">Ticker ID.</th>
                        <th class="p-2  text-left">Customer Name</th>
                        <th class="p-2  text-right">Amount Order</th>
                        <th class="p-2  text-right">Discount</th>
                        <th class="p-2  text-right">Total Amount</th>
                        <th class="p-2  text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <tr v-for="(data, i) in order_list" :key="i" class="tr ">
                        <td class="td text-left">
                            {{ data.tdata.ticket }}
                        </td>
                        <td class="td text-left">
                            {{
                                data.tdata.lastname + " " + data.tdata.firstname
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
                        <td class="td text-center">
                            <Tooltip content="View Details" placement="bottom">
                                <Button
                                    @click="viewDetails(data)"
                                    type="primary"
                                    shape="circle"
                                    size="small"
                                    icon="ios-menu"
                                ></Button>
                            </Tooltip>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="text-black font-semibold">
                        <td
                            class="td text-right font-semibold text-3xl "
                            colspan="5"
                        >
                            Overall Total Amount:
                        </td>
                        <td class="td text-left text-3xl ">
                            {{ totalAmt() | toCurrency2 }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <Modal
            :title="tenant"
            v-model="flag"
            width="60%"
            footer-hide
            :styles="{ top: '40px' }"
        >
            <OrderDetails :selected_order="selected_order" :header="header" />
        </Modal>
    </div>
</template>

<script>
import OrderDetails from "./SelectedTenantOrderDetails.vue";
export default {
    name: "Selected-Tenant-Orders",
    props: ["order_list", "tenant"],
    components: { OrderDetails },
    data() {
        return {
            flag: false,
            selected_order: {},
            header: {
                ticket_id: "",
                customer: "",
                mode: "",
                order_from: "",
                delivery_address: "",
                nearest_landmark: ""
            }
        };
    },
    methods: {
        totalOrder(data) {
            let total = 0;
            data.forEach(d => {
                total += parseFloat(d.total_price);
            });
            return total;
        },
        totalAmt() {
            let total = 0;
            if (this.order_list) {
                Object.keys(this.order_list).forEach(d => {
                    total += this.totalOrder(this.order_list[d].items);
                });
            }
            return total;
        },
        viewDetails(detail) {
            document.body.style.overflow = "hidden";
            this.flag = true;
            this.selected_order = detail;
            this.header.ticket_id = detail.tdata.ticket;
            this.header.customer =
                detail.tdata.lastname + " " + detail.tdata.firstname;
            this.header.mode = detail.tdata.mop;
            this.header.order_from =
                detail.tdata.type == 3
                    ? "Web Application"
                    : detail.tdata.type == 2
                    ? "Mobile Application"
                    : "Tele Ordering";
            this.header.delivery_address =
                detail.tdata.gc_delivery_info.complete_address +
                ", " +
                detail.tdata.gc_delivery_info.street_purok +
                ", " +
                detail.tdata.gc_delivery_info.brgy_name +
                ", " +
                detail.tdata.gc_delivery_info.town_name +
                " " +
                detail.tdata.gc_delivery_info.zipcode +
                ", " +
                detail.tdata.gc_delivery_info.prov_name;
            this.header.nearest_landmark =
                detail.tdata.gc_delivery_info.land_mark;
        }
    }
};
</script>
