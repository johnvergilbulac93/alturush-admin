<template>
    <div class=" bg-gray-50 shadow-lg p-5 rounded text-gray-800 ">
        <div class="flex flex-col justify-center items-center ">
            <div class="mb-5 bg-gray-100 p-2 md:w-1/2 sm:w-full  border">
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
                        <label for="" class="block font-semibold"
                            >Old Username
                        </label>
                        <input
                            v-bind:class="{
                                'border-red-600': errors.old_username
                            }"
                            type="text"
                            v-model="form.old_username"
                            class="form"
                            tabindex="1"
                            autofocus
                            placeholder="Old Username"
                        />
                        <transition
                            enter-active-class="ease-in duration-300"
                            enter-class="opacity-0 "
                            enter-to-class="opacity-100"
                            leave-active-class="ease-out duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <Error
                                :message="errors.old_username[0]"
                                v-if="errors.old_username"
                            />
                        </transition>
                    </div>
                    <div>
                        <label for="" class="block font-semibold"
                            >New Username
                        </label>
                        <input
                            v-bind:class="{
                                'border-red-600': errors.new_username
                            }"
                            type="text"
                            v-model="form.new_username"
                            class="form"
                            tabindex="2"
                            placeholder="New Username"
                        />
                        <transition
                            enter-active-class="ease-in duration-300"
                            enter-class="opacity-0 "
                            enter-to-class="opacity-100"
                            leave-active-class="ease-out duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <Error
                                :message="errors.new_username[0]"
                                v-if="errors.new_username"
                            />
                        </transition>
                    </div>
                    <button
                        @click="saveChanges"
                        class="px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 rounded transition duration-500 focus:outline-none"
                    >
                        Save
                    </button>
                    <button
                        @click="clear"
                        class="px-4 py-2 bg-gray-500 text-white  hover:bg-gray-600 rounded transition duration-500 focus:outline-none"
                    >
                        Clear
                    </button>
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
