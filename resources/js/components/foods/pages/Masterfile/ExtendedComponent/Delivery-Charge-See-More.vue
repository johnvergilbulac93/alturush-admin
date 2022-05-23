<template>
     <table class="min-w-full" v-if="data != null">
          <tbody class="border">
               <tr>
                    <td class="border p-2 font-semibold w-44">Province</td>
                    <td class="border p-2">{{ data.prov_name }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Town</td>
                    <td class="border p-2">{{ data.town_name }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Barangay</td>
                    <td class="border p-2">{{ !data.barangay ? "" : data.barangay.brgy_name }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Delivery Charge</td>
                    <td class="border p-2">{{ data.charge_amt | toCurrency2 }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Customer To Pay</td>
                    <td class="border p-2">{{ data.customer_to_pay | toCurrency2 }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Fuel</td>
                    <td class="border p-2">{{ data.fuel_amt | toCurrency2 }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Rider Share</td>
                    <td class="border p-2">{{ data.rider_share | toCurrency2 }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Admin Fee</td>
                    <td class="border p-2">{{ data.admin_fee | toCurrency2 }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Expenses For Store</td>
                    <td class="border p-2">{{ data.expenses_for_store | toCurrency2 }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Range Level</td>
                    <td class="border p-2">{{ data.range_level }}</td>
               </tr>
               <tr>
                    <td class="border p-2 font-semibold">Vehicle Type</td>
                    <td class="border p-2">{{ data.transpo_name }}</td>
               </tr>
          </tbody>
     </table>
</template>

<script>
export default {
     props: ['data']

}
</script>
