<template>
    <Tabs type="card">
        <TabPane label="Rider Informations">
            <div class="border-x border-b p-2">
                <table class="min-w-full" v-if="infos != null">
                    <tbody class="tbody">
                        <tr>
                            <td class="border td w-1/4 font-semibold">
                                Id No.
                            </td>
                            <td class="border td">{{ infos.r_id_num }}</td>
                        </tr>
                        <tr>
                            <td class="td border font-semibold">Fullname</td>
                            <td class="td border">
                                {{ infos.r_lastname + " " + infos.r_firstname }}
                            </td>
                        </tr>
                        <tr>
                            <td class="td border font-semibold">Birth Date</td>
                            <td class="td border">
                                {{ infos.r_birth_date }}
                            </td>
                        </tr>
                        <tr>
                            <td class="td border font-semibold">Gender</td>
                            <td class="td border">{{ infos.r_gender }}</td>
                        </tr>
                        <tr>
                            <td class="td border font-semibold">Address</td>
                            <td class="td border">{{ infos.r_address }}</td>
                        </tr>
                        <tr>
                            <td class="td border font-semibold">Mobile No.</td>
                            <td class="td border">{{ infos.r_mobile }}</td>
                        </tr>
                        <tr>
                            <td class="td border font-semibold">
                                License Type
                            </td>
                            <td class="td border">{{ infos.r_license }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </TabPane>
        <TabPane label="Motorcycle Information">
            <div class="border-x border-b p-2 h-">
                <table class="min-w-full" v-if="infos != null">
                    <tbody class="tbody">
                        <tr>
                            <td rowspan="4" class="border td w-1/4 text-center">
                                <img
                                    :src="imgSrc()"
                                    alt="rider"
                                    class="w-full h-auto  object-cover"
                                />
                            </td>
                            <td class="border td w-1/4 font-semibold">Brand</td>
                            <td class="border td">{{ infos.rm_brand }}</td>
                        </tr>
                        <tr>
                            <td class="border td  font-semibold">Color</td>
                            <td class="border td">{{ infos.rm_color }}</td>
                        </tr>
                        <tr>
                            <td class="border td  font-semibold">Model</td>
                            <td class="border td">{{ infos.rm_color }}</td>
                        </tr>
                        <tr>
                            <td class="border td  font-semibold">Plate No.</td>
                            <td class="border td">{{ infos.rm_plate_num }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </TabPane>
        <TabPane label="Rider Incomplete Liabilities">
            <div class="border-x border-b p-2 space-y-2">
                <div class="flex justify-end items-center">
                    <Button
                        @click="clearData"
                        type="primary"
                        icon="ios-trash-outline"
                        >Clear Data</Button
                    >
                </div>
                <div class="border">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left w-1/4">Ticket ID</th>
                                <th class="text-left w-1/4">Customer Name</th>
                                <th class="text-left">Address</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr class="tr" v-if="!Liabilities.length">
                                <td
                                    colspan="3"
                                    class="text-center td font-semibold"
                                >
                                    NO DATA AVAILABLE
                                </td>
                            </tr>
                            <tr
                                class="tr"
                                v-for="(data, i) in Liabilities"
                                :key="i"
                            >
                                <td class="td">{{ data.ticket }}</td>
                                <td class="td">{{ customer(data) }}</td>
                                <td class="td">{{ address(data) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </TabPane>
    </Tabs>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    name: "Rider-Infos",
    props: ["infos"],
    data() {
        return {};
    },
    computed: {
        ...mapState("Rider", ["Liabilities"])
    },
    methods: {
        ...mapActions("Rider", ["clearLiabilities"]),
        imgSrc() {
            if (this.infos) {
                return (
                    process.env.MIX_IMAGE_PATH +
                    "images/" +
                    this.infos.rm_picture
                );
            }
        },
        customer(data) {
            return `${data.firstname} ${data.lastname}`;
        },
        address(data) {
            return `${data.street_purok}, ${data.brgy_name}, ${data.town_name} ${data.zipcode}, ${data.prov_name}`;
        },
        clearData() {
            this.clearLiabilities({ rider_id: this.infos.id });
        }
    }
};
</script>
