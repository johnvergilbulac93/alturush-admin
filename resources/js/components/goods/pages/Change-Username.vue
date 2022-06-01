<template>
    <div class="  p-5 rounded text-gray-800 ">
        <div class="flex flex-col justify-center items-center ">
            <div class="mb-5  p-2 md:w-1/2 sm:w-full  border">
                <label class=" flex items-center space-x-1">
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
                    <span class="tracking-wider text-lg">Change Username</span>
                </label>
                <div class=" mt-5 p-2 space-y-4 ">
                    <div>
                        <label class="block font-semibold">Old Username </label>
                        <Input
                            v-model="form.old_username"
                            placeholder="Enter old username"
                        />
                        <Error
                            :message="errors.old_username[0]"
                            v-if="errors.old_username"
                        />
                    </div>
                    <div>
                        <label for="" class="block font-semibold"
                            >New Username
                        </label>

                        <Input
                            v-model="form.new_username"
                            placeholder="Enter new username"
                        />
                        <Error
                            :message="errors.new_username[0]"
                            v-if="errors.new_username"
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
                old_username: "",
                new_username: ""
            }
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapActions(["userChangeUsername"]),
        saveChanges() {
            let user = {
                old_username: this.form.old_username,
                new_username: this.form.new_username
            };
            this.userChangeUsername({ user });

            Fire.$on("clear_field", () => {
                this.clear();
            });
        },
        clear() {
            (this.form.old_username = ""),
                (this.form.new_username = ""),
                (this.errors.old_username = ""),
                (this.errors.new_username = "");
        }
    }
};
</script>

<style></style>
