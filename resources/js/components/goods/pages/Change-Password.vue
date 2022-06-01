<template>
    <div class="   p-5 rounded text-gray-800">
        <div class="flex flex-col justify-center items-center sm:w-full  ">
            <div class="mb-5 p-2 md:w-1/2 sm:w-full  border">
                <label for="" class=" flex items-center space-x-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1"
                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span class="tracking-wider text-lg ">Change Password</span>
                </label>
                <div class=" mt-5 p-2 space-y-4 text-gray-800">
                    <div class="w-auto">
                        <label class="block font-semibold "
                            >Old Password
                        </label>
                        <Input
                            v-model="form.old_password"
                            type="password"
                            password
                            placeholder="Enter old password"
                        />

                        <Error
                            :message="errors.old_password[0]"
                            v-if="errors.old_password"
                        />
                    </div>
                    <div class="w-auto">
                        <label class="block font-semibold">New Password </label>
                        <Input
                            v-model="form.new_password"
                            type="password"
                            password
                            placeholder="Enter new password"
                        />

                        <Error
                            :message="errors.new_password[0]"
                            v-if="errors.new_password"
                        />
                    </div>
                    <div class="w-auto">
                        <label class="block font-semibold"
                            >Confirm New Password
                        </label>
                        <Input
                            v-model="form.new_password_confirmation"
                            type="password"
                            password
                            placeholder="Confirm new password"
                        />
                        <Error
                            :message="errors.new_password_confirmation[0]"
                            v-if="errors.new_password_confirmation"
                        />
                    </div>
                    <Button type="primary" @click="saveChanges">Submit</Button>
                    <Button @click="clear">Clear</Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    name: "Change-Username",
    data() {
        return {
            form: {
                old_password: "",
                new_password: "",
                new_password_confirmation: ""
            }
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapActions(["userChangePass"]),

        saveChanges() {
            let user = {
                old_password: this.form.old_password,
                new_password: this.form.new_password,
                new_password_confirmation: this.form.new_password_confirmation
            };
            this.$Modal.confirm({
                title: "Confirmation",
                content: "<p>Do you want to change the password?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.userChangePass({ user });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        clear() {
            this.form.old_password = "";
            this.form.new_password = "";
            this.form.new_password_confirmation = "";
        }
    },
    mounted() {
        Fire.$on("clear_field", () => {
            this.clear();
        });
    }
};
</script>

<style></style>
