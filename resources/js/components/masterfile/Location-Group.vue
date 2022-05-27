<template>
    <div class="space-y-2">
        <module-header icon="ios-pin-outline" title="Location Group Setup" />
        <div class="border p-2">
            <div class="flex justify-between items-center my-2">
                <Input
                    v-model="search"
                    placeholder="Search"
                    style="width: 40%"
                    suffix="ios-search"
                    clearable
                />
            </div>
            <div class="border rounded">
                <table class="min-w-full">
                    <thead class="tracking-normal">
                        <tr>
                            <th class="p-2 font-semibold text-left">Group</th>
                            <th class="p-2 font-semibold text-left">Town</th>
                            <th class="p-2 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <tr class="tr" v-if="!filteredLocation.length">
                            <td
                                colspan="3"
                                class="td text-center font-semibold"
                            >
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(data, i) in filteredLocation"
                            :key="i"
                            class="tr"
                        >
                            <td class="td">{{ data.bunit_group }}</td>

                            <td class="td">{{ data.town_name }}</td>

                            <td class="td text-center">
                                <Tooltip content="Edit" placement="bottom">
                                    <Button
                                        @click="editInfo(data)"
                                        type="primary"
                                        shape="circle"
                                        size="small"
                                        icon="ios-open-outline"
                                    />
                                </Tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Drawer
            :title="
                editMode
                    ? 'Edit Location Group Setup'
                    : 'Add Location Group Setup'
            "
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form label-position="left" :label-width="100">
                <FormItem label="Town ">
                    <Select
                        v-model="form.town"
                        placeholder="Please select a town"
                        filterable
                    >
                        <Option
                            :value="data.town_id"
                            v-for="(data, i) in towns"
                            :key="i"
                            >{{ data.town_name }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.town[0]"
                        v-if="errors.town"
                    />
                </FormItem>
                <FormItem label="Group">
                    <Select
                        v-model="form.group"
                        placeholder="Please select a group"
                    >
                        <Option
                            :value="data.id"
                            v-for="(data, i) in bu_groups"
                            :key="i"
                            >{{ data.bunit_group }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.group[0]"
                        v-if="errors.group"
                    />
                </FormItem>
            </Form>
            <div class="w-full absolute bottom-0 left-0 border-t">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button type="success" @click="submit">SUBMIT</Button>
                        <Button type="default" @click="drawer = false"
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
    name: "Location-Group-Setup",
    data() {
        return {
            form: {
                id: "",
                group: "",
                town: ""
            },
            search: "",
            editMode: false,
            drawer: false
        };
    },
    computed: {
        ...mapState(["errors", "Towns"]),
        ...mapState("LocGroup", ["LocationGroup", "DefaultData"]),
        filteredLocation() {
            let tempLocation = this.LocationGroup;
            if (this.search) {
                tempLocation = tempLocation.filter(item => {
                    return item.town_name
                        .toUpperCase()
                        .includes(this.search.toUpperCase());
                });
            }
            return tempLocation;
        },
        towns() {
            if (this.DefaultData) {
                return this.DefaultData.towns;
            }
        },
        bu_groups() {
            if (this.DefaultData) {
                return this.DefaultData.bu_group;
            }
        }
    },
    methods: {
        ...mapActions("LocGroup", [
            "getLocationGroup",
            "getDefaultData",
            "updateData"
        ]),
        editInfo(data) {
            this.reset();
            this.editMode = true;
            this.drawer = true;
            this.form.town = data.town_id;
            this.form.group = data.bunit_group_id;
        },
        reset() {
            (this.form.id = ""), (this.form.group = "");
            this.form.town = "";
        },
        submit() {
            let payload = {
                town: this.form.town,
                group: this.form.group
            };
            this.updateData(payload);
        }
    },
    mounted() {
        Fire.$on("reload_location_group", () => {
            this.getLocationGroup();
            this.drawer = false;
        });
        this.getLocationGroup();
        this.getDefaultData();
    }
};
</script>
