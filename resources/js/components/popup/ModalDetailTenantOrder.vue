<template>
    <transition
        enter-active-class=" ease-in-out transition duration-500"
        enter-class=" transform -translate-y-96 opacity-0"
        enter-to-class="opacity-100 "
        leave-active-class="ease-in-out transition duration-500"
        leave-class=" opacity-100"
        leave-to-class="transform -translate-y-96 opacity-0"
    >
        <div
            class=" fixed top-0 left-0 z-50  flex justify-center items-center w-full h-screen overflow-y-auto"
        >
            <div
                class="w-3/4 bg-white border  border-gray-400 rounded shadow-lg  "
            >
                <div class="p-2 flex justify-between items-center ">
                    <h4 class="font-semibold text-lg ">
                        {{ selected_tenant }}
                    </h4>
                    <a @click="closeModal" class="transition duration-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="lg:h-6 lg:w-6 sm:h-5 sm:w-5 text-gray-700 hover:text-red-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </a>
                </div>
                <div class="p-2">
                    <div class="border w-full p-5">
                        <label class="block uppercase font-semibold  "
                            >Ticket Details</label
                        >
                        <div class="flex justify-between items-center mt-2">
                            <div class="w-1/2 ">
                                <p class="font-semibold">
                                    Ticket ID.: &nbsp;
                                    <span
                                        class="font-extralight text-gray-600 "
                                    >
                                        {{ data_selected.tdata.ticket }}</span
                                    >
                                </p>
                                <p class="font-semibold">
                                    Customer: &nbsp;
                                    <span
                                        class="font-extralight text-gray-600 "
                                        >{{
                                            data_selected.tdata.lastname +
                                                ", " +
                                                data_selected.tdata.firstname
                                        }}</span
                                    >
                                </p>
                                <p class="font-semibold">
                                    Mode of Order:&nbsp;
                                    <span
                                        class="font-extralight text-gray-600 "
                                        >{{ data_selected.tdata.mop }}</span
                                    >
                                </p>
                                <p class="font-semibold">
                                    Order From:&nbsp;<span
                                        class="font-extralight text-gray-600 "
                                        >{{
                                            data_selected.tdata.type == 3
                                                ? "Web Application"
                                                : data_selected.tdata.type == 2
                                                ? "Mobile Application"
                                                : "Tele Ordering"
                                        }}</span
                                    >
                                </p>
                            </div>
                            <div class="w-1/2">
                                <p class="font-semibold">Delivery Address</p>
                                <p class="font-extralight text-gray-600">
                                    {{
                                        data_selected.tdata.gc_delivery_info
                                            .complete_address +
                                            ", " +
                                            data_selected.tdata.gc_delivery_info
                                                .street_purok +
                                            ", " +
                                            data_selected.tdata.gc_delivery_info
                                                .brgy_name +
                                            ", " +
                                            data_selected.tdata.gc_delivery_info
                                                .town_name +
                                            " " +
                                            data_selected.tdata.gc_delivery_info
                                                .zipcode +
                                            ", " +
                                            data_selected.tdata.gc_delivery_info
                                                .prov_name
                                    }}
                                </p>
                                <p class="font-semibold">Nearest Landmark</p>
                                <p class="font-extralight text-gray-600">
                                    {{
                                        data_selected.tdata.gc_delivery_info
                                            .land_mark
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-200 tracking-normal border">
                            <tr class="border">
                                <th class="p-2 border text-left">
                                    Item Details
                                </th>
                                <th class="p-2 border text-center">Quantity</th>
                                <th class="p-2 border text-right">
                                    Total Price
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr
                                class="tr"
                                v-for="(data, i) in data_selected.items"
                                :key="i"
                            >
                                <td class="td">
                                    <ul>
                                        <li>
                                            <div
                                                class="flex justify-between items-center"
                                            >
                                                <span>{{
                                                    data.product_name
                                                }}</span>
                                                <span
                                                    >({{
                                                        Number(
                                                            data.product_price
                                                        )
                                                            .toLocaleString(
                                                                "en-US",
                                                                {
                                                                    style:
                                                                        "currency",
                                                                    currency:
                                                                        "PHP"
                                                                }
                                                            )
                                                            .replace(
                                                                "PHP",
                                                                "₱"
                                                            )
                                                    }})</span
                                                >
                                            </div>
                                            <p class="text-gray-500">
                                                {{ data.variation }}
                                            </p>
                                        </li>
                                        <li
                                            v-for="(item,
                                            index) in data.suggestions"
                                            :key="index"
                                            class="text-gray-500"
                                        >
                                            <div
                                                class="flex justify-between items-center"
                                            >
                                                <span>{{
                                                    "+ " + item.description
                                                }}</span>
                                                <span>
                                                    {{
                                                        parseFloat(
                                                            item.addon_price
                                                        ) > 1
                                                            ? Number(
                                                                  parseFloat(
                                                                      item.addon_price
                                                                  )
                                                              )
                                                                  .toLocaleString(
                                                                      "en-US",
                                                                      {
                                                                          style:
                                                                              "currency",
                                                                          currency:
                                                                              "PHP"
                                                                      }
                                                                  )
                                                                  .replace(
                                                                      "PHP",
                                                                      "₱"
                                                                  )
                                                            : ""
                                                    }}
                                                </span>
                                            </div>
                                        </li>
                                        <li
                                            v-if="data.product_flavor"
                                            class="text-gray-500"
                                        >
                                            <div
                                                class="flex justify-between items-center"
                                            >
                                                <span>
                                                    {{
                                                        "+ ".data.product_flavor
                                                            .flavor
                                                    }}</span
                                                >
                                                <span>
                                                    {{
                                                        parseFloat(
                                                            data.product_flavor
                                                                .addon_price
                                                        ) > 1
                                                            ? Number(
                                                                  parseFloat(
                                                                      data
                                                                          .product_flavor
                                                                          .addon_price
                                                                  )
                                                              )
                                                                  .toLocaleString(
                                                                      "en-US",
                                                                      {
                                                                          style:
                                                                              "currency",
                                                                          currency:
                                                                              "PHP"
                                                                      }
                                                                  )
                                                                  .replace(
                                                                      "PHP",
                                                                      "₱"
                                                                  )
                                                            : ""
                                                    }}
                                                </span>
                                            </div>
                                        </li>
                                        <li
                                            v-for="(item,
                                            index) in data.product_choice"
                                            :key="index"
                                            class="text-gray-500"
                                        >
                                            <div
                                                class="flex justify-between items-center"
                                            >
                                                <span>
                                                    {{
                                                        item.unit_measure
                                                            ? "+ " +
                                                              item.product_name +
                                                              " - " +
                                                              item.unit_measure
                                                            : "+ " +
                                                              item.product_name
                                                    }}
                                                </span>
                                                <span>
                                                    {{
                                                        parseFloat(
                                                            item.addon_price
                                                        ) > 1
                                                            ? Number(
                                                                  parseFloat(
                                                                      item.addon_price
                                                                  )
                                                              )
                                                                  .toLocaleString(
                                                                      "en-US",
                                                                      {
                                                                          style:
                                                                              "currency",
                                                                          currency:
                                                                              "PHP"
                                                                      }
                                                                  )
                                                                  .replace(
                                                                      "PHP",
                                                                      "₱"
                                                                  )
                                                            : ""
                                                    }}
                                                </span>
                                            </div>
                                        </li>
                                        <li
                                            v-for="(item,
                                            index) in data.product_addon"
                                            :key="index"
                                            class="text-gray-500"
                                        >
                                            <div
                                                class="flex justify-between items-center"
                                            >
                                                <span>
                                                    {{
                                                        item.unit_measure
                                                            ? "+ " +
                                                              item.product_name +
                                                              " - " +
                                                              item.unit_measure
                                                            : "+ " +
                                                              item.product_name
                                                    }}</span
                                                >
                                                <span>
                                                    {{
                                                        parseFloat(
                                                            item.addon_price
                                                        ) > 1
                                                            ? Number(
                                                                  parseFloat(
                                                                      item.addon_price
                                                                  )
                                                              )
                                                                  .toLocaleString(
                                                                      "en-US",
                                                                      {
                                                                          style:
                                                                              "currency",
                                                                          currency:
                                                                              "PHP"
                                                                      }
                                                                  )
                                                                  .replace(
                                                                      "PHP",
                                                                      "₱"
                                                                  )
                                                            : ""
                                                    }}
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                                <td class="td text-center">
                                    {{ data.quantity }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        Number(parseFloat(data.total_price))
                                            .toLocaleString("en-US", {
                                                style: "currency",
                                                currency: "PHP"
                                            })
                                            .replace("PHP", "₱")
                                    }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-200 border tracking-normal font-semibold">
                            <tr class="border">
                                <td class="p-2 border text-right">
                                    Total Summary
                                </td>
                                <td class="p-2 border text-center">
                                    {{ getTotalSummary("quantity") }}
                                </td>
                                <td class="p-2 border text-right">
                                    {{
                                        Number(getTotalSummary("total_price"))
                                            .toLocaleString("en-US", {
                                                style: "currency",
                                                currency: "PHP"
                                            })
                                            .replace("PHP", "₱")
                                    }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="p-2">
                     <button @click="closeModal" class="px-2 py-1 focus:outline-none text-white bg-blue-500 hover:bg-blue-600">BACK</button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
    name: "ModalTenantOrderDetails",
    props: ["data_selected", "selected_tenant"],
    computed: {
        ...mapState(["isModal2"])
    },
    methods: {
        ...mapActions(["modal2"]),
        closeModal() {
            this.modal2({ flag: false });
        },
        getTotalSummary(data) {
            var total = 0;
            this.data_selected.items.forEach(item => {
                total += parseFloat(
                    data == "quantity" ? item.quantity : item.total_price
                );
            });
            return total;
        }
    }
};
</script>
