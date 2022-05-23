<template>
    <div class="space-y-2 ">
        <module-header icon="ios-hammer" title="Business Rule " />
        <div class=" border rounded">
            <table class="min-w-full  ">
                <thead class=" tracking-normal ">
                    <tr class="border-b">
                        <th class="p-3 text-left ">
                            Minimum Order Amount
                        </th>
                        <th class="p-3 text-left ">
                            Pick-Up Charge
                        </th>
                        <th class="p-3 text-center ">
                            Maximum no. of order
                        </th>
                        <th class="p-3 text-center " colspan="2" rowspan="2">
                            Ordering Time Cut-off
                            <hr />
                            <tr class="flex justify-around items-center mt-1">
                                <th>Start</th>
                                <th>End</th>
                            </tr>
                        </th>

                        <th class="p-3 text-center " colspan="2">
                            Serving Time
                            <hr />
                            <tr class="flex justify-around items-center mt-1">
                                <th>Start</th>
                                <th>End</th>
                            </tr>
                        </th>

                        <th class="text-center p-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr class="tr" v-for="(rule, i) in BRule" :key="i">
                        <td class="p-2 ">
                            {{ rule.minimum_order_amount | toCurrency2 }}
                        </td>
                        <td class="p-2 ">
                            {{ rule.pickup_charge | toCurrency2 }}
                        </td>
                        <td class="p-2  text-center">
                            {{ rule.maximum_no_of_orders }}
                        </td>
                        <td class="p-2  text-center">
                            {{ rule.ordering_cutoff_time_start | formatTime2 }}
                        </td>
                        <td class="p-2  text-center">
                            {{ rule.ordering_cutoff_time_end | formatTime2 }}
                        </td>
                        <td class="p-2  text-center">
                            {{ rule.serving_time_start | formatTime2 }}
                        </td>
                        <td class="p-2  text-center">
                            {{ rule.serving_time_end | formatTime2 }}
                        </td>
                        <td class="p-2 text-center">
                            <Tooltip content="Edit" placement="right">
                                <Button
                                    @click="editInfo(rule)"
                                    size="small"
                                    type="primary"
                                    shape="circle"
                                    icon="ios-open-outline"
                                />
                            </Tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Drawer
            title="Update Rule"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="right" :label-width="200">
                <FormItem label="Minimum Order Amount">
                    <InputNumber
                        :max="10000"
                        v-model="minimum_order_amount"
                        style="width: 100%;"
                        :formatter="
                            value =>
                                `PHP ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                    />
                </FormItem>
                <FormItem label="Pick-up Charge">
                    <InputNumber
                        :max="10000"
                        v-model="pickup_charge"
                        style="width: 100%;"
                        :formatter="
                            value =>
                                `PHP ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                    />
                </FormItem>
                <FormItem label="Maximum no. of order">
                    <InputNumber
                        :max="10000"
                        v-model="maximum_no_of_order"
                        style="width: 100%;"
                        :formatter="
                            value =>
                                `PHP ${value}`.replace(
                                    /\B(?=(\d{3})+(?!\d))/g,
                                    ','
                                )
                        "
                        :parser="value => value.replace(/\$\s?|(,*)/g, '')"
                    />
                </FormItem>
                <Divider />
                <FormItem label="Ordering Time Start">
                    <TimePicker
                        type="time"
                        v-model="order_time_cutoff_start"
                        placeholder="Select time"
                        style="width: 100%;"
                        format="HH:mm"
                    ></TimePicker>
                </FormItem>
                <FormItem label="Ordering Time End">
                    <TimePicker
                        type="time"
                        v-model="order_time_cutoff_end"
                        placeholder="Select time"
                        style="width: 100%;"
                        format="HH:mm"
                    ></TimePicker>
                </FormItem>
                <Divider />
                <FormItem label="Serving Time Start">
                    <TimePicker
                        type="time"
                        v-model="serving_time_start"
                        placeholder="Select time"
                        style="width: 100%;"
                        format="HH:mm"
                    ></TimePicker>
                </FormItem>
                <FormItem label="Serving Time End">
                    <TimePicker
                        type="time"
                        v-model="serving_time_end"
                        placeholder="Select time"
                        style="width: 100%;"
                        format="HH:mm"
                    ></TimePicker>
                </FormItem>
            </Form>
            <div class=" w-full absolute bottom-0 left-0 border-t ">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button type="success" @click="update()">SUBMIT</Button>
                        <Button type="default" @click="drawer = !drawer"
                            >CANCEL</Button
                        >
                    </div>
                </div>
            </div>
        </Drawer>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    data() {
        return {
            id: "",
            minimum_order_amount: 0,
            pickup_charge: 0,
            order_time_cutoff_start: "",
            order_time_cutoff_end: "",
            serving_time_start: "",
            serving_time_end: "",
            maximum_no_of_order: 0,
            drawer: false,
            time: ""
        };
    },
    computed: {
        ...mapState("B_Rule", ["BRule"])
    },
    methods: {
        ...mapActions("B_Rule", ["getRule", "updateRule"]),
        update() {
            this.updateRule({
                id: this.id,
                min_order_amt: this.minimum_order_amount,
                pickup_charge: this.pickup_charge,
                order_cutoff_start: this.order_time_cutoff_start,
                order_cutoff_end: this.order_time_cutoff_end,
                serving_time_start: this.serving_time_start,
                serving_time_end: this.serving_time_end,
                max_no_order: this.maximum_no_of_order
            });
        },
        editInfo(rule) {
            this.reset();
            this.drawer = !this.drawer;
            this.id = rule.id;
            this.minimum_order_amount = parseFloat(rule.minimum_order_amount);
            this.pickup_charge = parseFloat(rule.pickup_charge);
            this.order_time_cutoff_start = rule.ordering_cutoff_time_start;
            this.order_time_cutoff_end = rule.ordering_cutoff_time_end;
            this.serving_time_start = rule.serving_time_start;
            this.serving_time_end = rule.serving_time_end;
            this.maximum_no_of_order = parseFloat(rule.maximum_no_of_orders);
        },
        reset() {
            this.id = "";
            this.minimum_order_amount = 0;
            this.pickup_charge = 0;
            this.order_time_cutoff_start = "";
            this.order_time_cutoff_end = "";
            this.serving_time_start = "";
            this.serving_time_end = "";
            this.maximum_no_of_order = 0;
        }
    },
    mounted() {
        Fire.$on("reload_rule", () => {
            this.getRule();
            this.drawer = !this.drawer;
            this.reset();
        });
        this.getRule();
    }
};
</script>
