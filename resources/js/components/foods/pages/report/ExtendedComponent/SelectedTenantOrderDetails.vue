<template>
    <div class="p-2 border rounded  w-full">
        <h4 class="font-semibold  ">Ticket Details</h4>
        <div class="mt-2 flex justify-between ">
            <div class="space-y-0.5  w-1/2 ">
                <label class="block font-semibold text-xs "
                    >Ticker ID.:
                    <span class="font-normal">{{ header.ticket_id }}</span>
                </label>
                <label class="block font-semibold text-xs "
                    >Customer:
                    <span class="font-normal">{{ header.customer }}</span>
                </label>
                <label class="block font-semibold  text-xs"
                    >Mode of Order:
                    <span class="font-normal">{{ header.mode }}</span>
                </label>
                <label class="block font-semibold text-xs "
                    >Order from:
                    <span class="font-normal">{{ header.order_from }}</span>
                </label>
            </div>
            <div class="space-y-0.5 w-1/2 ">
                <label class="block font-semibold text-xs "
                    >Delivery Address</label
                >
                <span class="text-xs break-normal">
                    {{ header.delivery_address }}</span
                >
                <label class="block font-semibold text-xs"
                    >Nearest Landmark</label
                >
                <span class="text-xs">{{ header.nearest_landmark }}</span>
            </div>
        </div>
        <hr class="my-2" />
        <div class="border rounded">
            <table class="min-w-full ">
                <thead class="tracking-normal border-b">
                    <tr>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2  text-center">Qty</th>
                        <th class="p-2  text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <tr
                        v-for="(data, i) in selected_order.items"
                        :key="i"
                        class="tr "
                    >
                        <td class="td text-left">
                            <span
                                class="flex justify-between items-center font-semibold "
                            >
                                <span> {{ data.product_name }}</span>
                                <span>
                                    ({{
                                        Number(data.product_price)
                                            .toLocaleString("en-US", {
                                                style: "currency",
                                                currency: "PHP"
                                            })
                                            .replace("PHP", "₱")
                                    }})</span
                                >
                            </span>
                            <span class="block">{{ data.variation }}</span>

                            <span
                                class=" flex justify-between items-center "
                                v-for="(item, index) in data.suggestions"
                                :key="'a' + index"
                            >
                                <span>{{ "+ " + item.description }} </span>
                                <span>{{
                                    parseFloat(item.addon_price) > 1
                                        ? Number(parseFloat(item.addon_price))
                                              .toLocaleString("en-US", {
                                                  style: "currency",
                                                  currency: "PHP"
                                              })
                                              .replace("PHP", "₱")
                                        : ""
                                }}</span>
                            </span>
                            <span
                                class=" flex justify-between items-center "
                                v-if="data.product_flavor"
                            >
                                <span>
                                    {{ "+ ".data.product_flavor.flavor }}</span
                                >
                                <span>
                                    {{
                                        parseFloat(
                                            data.product_flavor.addon_price
                                        ) > 1
                                            ? Number(
                                                  parseFloat(
                                                      data.product_flavor
                                                          .addon_price
                                                  )
                                              )
                                                  .toLocaleString("en-US", {
                                                      style: "currency",
                                                      currency: "PHP"
                                                  })
                                                  .replace("PHP", "₱")
                                            : ""
                                    }}
                                </span>
                            </span>
                            <span
                                class=" flex justify-between items-center"
                                v-for="(item, index) in data.product_choice"
                                :key="'b' + index"
                            >
                                <span>
                                    {{
                                        item.unit_measure
                                            ? "+ " +
                                              item.product_name +
                                              " - " +
                                              item.unit_measure
                                            : "+ " + item.product_name
                                    }}
                                </span>
                                <span>
                                    {{
                                        parseFloat(item.addon_price) > 1
                                            ? Number(
                                                  parseFloat(item.addon_price)
                                              )
                                                  .toLocaleString("en-US", {
                                                      style: "currency",
                                                      currency: "PHP"
                                                  })
                                                  .replace("PHP", "₱")
                                            : ""
                                    }}
                                </span>
                            </span>
                            <span
                                class=" flex justify-between items-center "
                                v-for="(item, index) in data.product_addon"
                                :key="'c' + index"
                            >
                                <span>
                                    {{
                                        item.unit_measure
                                            ? "+ " +
                                              item.product_name +
                                              " - " +
                                              item.unit_measure
                                            : "+ " + item.product_name
                                    }}
                                </span>

                                <span>
                                    {{
                                        parseFloat(item.addon_price) > 1
                                            ? Number(
                                                  parseFloat(item.addon_price)
                                              )
                                                  .toLocaleString("en-US", {
                                                      style: "currency",
                                                      currency: "PHP"
                                                  })
                                                  .replace("PHP", "₱")
                                            : ""
                                    }}
                                </span>
                            </span>
                        </td>
                        <td class="td text-center">
                            {{ data.quantity }}
                        </td>
                        <td class="td text-right">
                            {{ data.total_price | toCurrency2 }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="font-semibold">
                        <td class="td text-right font-semibold  ">
                            Total Summary:
                        </td>
                        <td class="text-center">
                            {{ total("qty") }}
                        </td>
                        <td class="text-right">
                            {{ total("price") | toCurrency2 }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "Selected-Tenant-Orders-Details",
    props: ["selected_order", "header"],
    methods: {
        total(data) {
            let tot = 0;
            let arrOrder = this.selected_order.items;
            if (arrOrder) {
                arrOrder.forEach(d => {
                    tot += parseFloat(
                        data == "qty" ? d.quantity : d.total_price
                    );
                });
            }
            return tot;
        }
    }
};
</script>
