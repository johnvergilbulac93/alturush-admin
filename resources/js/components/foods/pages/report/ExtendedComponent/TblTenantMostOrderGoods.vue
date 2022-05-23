<template>
    <table class="min-w-full " id="tenant_most_order_table">
        <thead class="border-b tracking-normal">
            <tr>
                <th class=" p-2 text-left">Ticket #</th>
                <th class=" p-2 text-left">Store</th>
                <th class=" p-2 text-center">
                    Total Order(s)
                </th>
                <th class=" p-2 text-right">
                    Picking Charge
                </th>
                <th class=" p-2 text-right">
                    Total Sales
                </th>
            </tr>
        </thead>
        <tbody class="tbody">
            <tr v-if="!TenantMostOrder.length">
                <td colspan="5" class=" p-2 text-center">
                    NO DATA AVAILABLE
                </td>
            </tr>
            <tr v-for="(data, i) in TenantMostOrder" :key="i">
                <td class="text-left td">{{ data.ticket }}</td>
                <td class="text-left td">{{ data.store }}</td>
                <td class="text-center td">
                    {{ data.total_order }}
                </td>
                <td class="text-right td">
                    {{ data.picking_charge | toCurrency }}
                </td>
                <td class="text-right td">
                    {{ data.total_sales | toCurrency }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr
                class=" font-semibold bg-gray-100 "
                v-if="TenantMostOrder.length"
            >
                <td colspan="2" class=" p-2 text-center">
                    TOTAL
                </td>
                <td class=" p-2 text-center">
                    {{ compute_total_num() | toCurrency }}
                </td>
                <td class=" p-2 text-right">
                    {{ compute_picking_charge() | toCurrency }}
                </td>
                <td class=" p-2 text-right">
                    {{ compute_total_sales() | toCurrency }}
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
import { mapState } from "vuex";
export default {
    name: "TblTenantMostOrderGoods",
    computed: {
        ...mapState("Report", ["TenantMostOrder"])
    },
    methods: {
        compute_total_sales() {
            var sales = 0;
            this.TenantMostOrder.forEach(d => {
                sales += d.total_sales;
            });
            return Number(sales);
        },
        compute_total_num() {
            var count = 0;
            this.TenantMostOrder.forEach(d => {
                count += d.total_order;
            });
            return Number(count);
        },
        compute_picking_charge() {
            var charge = 0;
            this.TenantMostOrder.forEach(d => {
                charge += parseFloat(d.picking_charge);
            });
            return Number(charge);
        }
    }
};
</script>
