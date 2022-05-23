<template>
    <table class="min-w-full" id="tenant_most_order_table">
        <thead class=" border-b  tracking-normal">
            <tr>
                <th class=" p-2 text-left">Store</th>
                <th class=" p-2 text-left">Tenant(s)</th>
                <th class=" p-2 text-center">
                    Total Order(s)
                </th>
                <th class=" p-2 text-right">
                    Total Sale(s)
                </th>
            </tr>
        </thead>
        <tbody class="tbody">
            <tr v-for="(data, i) in TenantMostOrder" :key="i">
                <td class="td text-left">
                    {{ data.acroname }}
                </td>
                <td class="td text-left">{{ data.tenant }}</td>
                <td class="td text-center">
                    {{ data.total_order }}
                </td>
                <td class="td text-right">
                    {{ data.total_sales | toCurrency }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class=" font-semibold ">
                <td colspan="2" class=" p-2 text-center">
                    TOTAL
                </td>
                <td class=" p-2 text-center">
                    {{ compute_total_num() | toCurrency }}
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
    name: "TblTenantMostOrder",
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
        }
    }
};
</script>
