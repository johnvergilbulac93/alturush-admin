<template>
    <div>
        <table class="min-w-full">
            <thead class="border bg-gray-50 tracking-normal ">
                <tr>
                    <th class="p-2 text-center border">
                        <input
                            type="checkbox"
                            class="form-checkbox disabled:cursor-not-allowed"
                            checked
                            disabled
                        />
                    </th>
                    <th class="p-2 text-left border">
                        Usertype
                    </th>
                </tr>
            </thead>
            <tbody class="border">
                <tr class="tr" v-if="!Roles.length">
                    <td colspan="2" class="td text-center">
                        Loading Data
                    </td>
                </tr>
                <tr v-for="role in Roles" :key="role.id" class="tr">
                    <td class="td w-10 text-center border">
                        <input
                            type="checkbox"
                            class="form-checkbox"
                            :id="'ut_' + role.id"
                            :value="role.id"
                            :checked="role.stat"
                            @click="assignRole(role.id, role.userdata)"
                        />
                    </td>
                    <td class="td border">{{ role.usertype }}</td>
                </tr>
            </tbody>
        </table>
        <div class=" w-full absolute bottom-0 left-0 border-t ">
            <div class="flex justify-end items-center">
                <div class="p-2">
                    <Button type="default" @click="$emit('close')"
                        >CANCEL</Button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    props: ["flag"],
    computed: {
        ...mapState(["Roles"])
    },
    methods: {
        ...mapActions("User", ["userRole"]),
        assignRole(id, data) {
            let payload = {
                status: $("#ut_" + id).is(":checked"),
                usertype: id,
                user_id: data.id
            };
            this.userRole(payload);
        }
    }
};
</script>
