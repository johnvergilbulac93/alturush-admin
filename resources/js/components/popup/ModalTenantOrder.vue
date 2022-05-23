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
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-200 tracking-normal border">
                            <tr class="border">
                                <th class="p-2 border text-left">Ticket ID.</th>
                                <th class="p-2 border text-left">
                                    Customer Name
                                </th>
                                <th class="p-2 border text-right">
                                    Amount Order
                                </th>
                                <th class="p-2 border text-right">Discount</th>
                                <th class="p-2 border text-right">
                                    Total Amount
                                </th>
                                <th class="p-2 border text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr
                                v-for="(detail, i) in order_list"
                                :key="i"
                                class="tr "
                            >
                                <td class="td text-left">
                                    {{ i }}
                                </td>
                                <td class="td text-left">
                                    {{
                                        detail.tdata.lastname +
                                            ", " +
                                            detail.tdata.firstname
                                    }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        Number(
                                            computeTotalOrderAmt(detail.items)
                                        )
                                            .toLocaleString("en-US", {
                                                style: "currency",
                                                currency: "PHP"
                                            })
                                            .replace("PHP", "₱")
                                    }}
                                </td>
                                <td class="td text-right">
                                    {{
                                        Number(detail.discount)
                                            .toLocaleString("en-US", {
                                                style: "currency",
                                                currency: "PHP"
                                            })
                                            .replace("PHP", "₱")
                                    }}
                                </td>

                                <td class="td text-right">
                                    {{
                                        Number(
                                            computeTotalOrderAmt(detail.items) -
                                                detail.discount
                                        )
                                            .toLocaleString("en-US", {
                                                style: "currency",
                                                currency: "PHP"
                                            })
                                            .replace("PHP", "₱")
                                    }}
                                </td>
                                <td class="td text-center">
                                    <button
                                        @click="viewOrderDetails(detail)"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="View Details"
                                        class="focus:outline-none px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs"
                                    >
                                        Details
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        class="flex gap-2 justify-end items-center mt-2 text-lg font-semibold"
                    >
                        <h2>Overall Total Amount:</h2>
                        <h2>
                            {{
                                Number(overAllTotalAmt())
                                    .toLocaleString("en-US", {
                                        style: "currency",
                                        currency: "PHP"
                                    })
                                    .replace("PHP", "₱")
                            }}
                        </h2>
                    </div>
                </div>
            </div>

            <modal-tenant-order-details v-if="isModal2" :data_selected="data_selected" :selected_tenant="selected_tenant" />
        </div>
    </transition>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
    name: "ModalTenantOrder",
    props: ["order_list", "selected_tenant"],
    data() {
        return {
            data_selected: null
        };
    },
    computed: {
        ...mapState(["isModal", "isModal2"])
    },
    methods: {
        ...mapActions(["modal", "modal2"]),
        closeModal() {
            this.modal({ flag: false });
        },
        computeTotalOrderAmt(items) {
            var total = 0;
            items.forEach(item => {
                total += parseFloat(item.total_price);
            });
            return total;
        },
        viewOrderDetails(data) {
            this.data_selected = data;
            this.modal2({ flag: true })
            console.log(data)
        },
        overAllTotalAmt() {
            var total = 0;
            Object.keys(this.order_list).forEach(d => {
                total += this.computeTotalOrderAmt(this.order_list[d].items);
            });
            return total;
        }
    }
};
</script>
