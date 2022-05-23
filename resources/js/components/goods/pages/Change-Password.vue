<template>
    <div class=" bg-gray-50 shadow-lg p-5 rounded text-gray-800">
        <div class="flex flex-col justify-center items-center sm:w-full  ">
            <div class="mb-5 bg-gray-100 p-2 md:w-1/2 sm:w-full  border">
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
                    <div>
                        <label
                            for=""
                            class="block font-semibold subpixel-antialiased"
                            >Old Password
                        </label>
                        <div class="relative w-full flex ">
                            <input
                                v-bind:class="{
                                    'border-red-600': errors.old_password
                                }"
                                v-if="showPasswordOld"
                                type="text"
                                class="relative form "
                                placeholder="Old Password"
                                v-model="form.old_password"
                                tabindex="1"
                                autofocus
                            />
                            <input
                                v-bind:class="{
                                    'border-red-600': errors.old_password
                                }"
                                v-else
                                type="password"
                                class="relative form"
                                placeholder="Old Password"
                                v-model="form.old_password"
                                tabindex="1"
                                autofocus
                            />
                            <button
                                v-if="form.old_password.length"
                                class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center focus:outline-none "
                            >
                                <svg
                                    @click="toggleShowOld"
                                    v-if="!showPasswordOld"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 "
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                </svg>

                                <svg
                                    @click="toggleShowOld"
                                    v-if="showPasswordOld"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                    />
                                </svg>
                            </button>
                        </div>
                        <transition
                            enter-active-class="ease-in duration-300"
                            enter-class="opacity-0 "
                            enter-to-class="opacity-100"
                            leave-active-class="ease-out duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <Error
                                :message="errors.old_password[0]"
                                v-if="errors.old_password"
                            />
                        </transition>
                    </div>
                    <div>
                        <label for="" class="block font-semibold"
                            >New Password
                        </label>
                        <div class="relative w-full  flex ">
                            <input
                                v-bind:class="{
                                    'border-red-600': errors.new_password
                                }"
                                v-if="showPasswordNew"
                                type="text"
                                class="relative form"
                                placeholder="New Password"
                                v-model="form.new_password"
                                tabindex="2"
                            />
                            <input
                                v-bind:class="{
                                    'border-red-600': errors.new_password
                                }"
                                v-else
                                type="password"
                                class="relative form"
                                placeholder="New Password"
                                v-model="form.new_password"
                                tabindex="2"
                            />
                            <button
                                v-if="form.new_password.length"
                                class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center focus:outline-none "
                            >
                                <svg
                                    @click="toggleShowNew"
                                    v-if="!showPasswordNew"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 "
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                </svg>

                                <svg
                                    @click="toggleShowNew"
                                    v-if="showPasswordNew"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                    />
                                </svg>
                            </button>
                        </div>
                        <transition
                            enter-active-class="ease-in duration-300"
                            enter-class="opacity-0 "
                            enter-to-class="opacity-100"
                            leave-active-class="ease-out duration-500"
                            leave-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <Error
                                :message="errors.new_password[0]"
                                v-if="errors.new_password"
                            />
                        </transition>
                    </div>
                    <div>
                        <label for="" class="block font-semibold"
                            >Confirm New Password
                        </label>
                        <div class="relative w-full  flex ">
                            <input
                                v-if="showPasswordConfirm"
                                type="text"
                                class="relative form"
                                placeholder="Confirm Password"
                                v-model="form.new_password_confirmation"
                                tabindex="3"
                            />
                            <input
                                v-else
                                type="password"
                                class="relative form"
                                placeholder="Confirm Password"
                                v-model="form.new_password_confirmation"
                                tabindex="3"
                            />
                            <button
                                v-if="form.new_password_confirmation.length"
                                class="absolute right-0 z-10 py-1 pr-2 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center focus:outline-none "
                            >
                                <svg
                                    @click="toggleShowConfirm"
                                    v-if="!showPasswordConfirm"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 "
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                </svg>

                                <svg
                                    @click="toggleShowConfirm"
                                    v-if="showPasswordConfirm"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                                    />
                                </svg>
                            </button>
                        </div>
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
                old_password: "",
                new_password: "",
                new_password_confirmation: ""
            },
            showPasswordOld: false,
            showPasswordNew: false,
            showPasswordConfirm: false
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapActions(["userChangePass"]),
        toggleShowOld() {
            this.showPasswordOld = !this.showPasswordOld;
        },
        toggleShowNew() {
            this.showPasswordNew = !this.showPasswordNew;
        },
        toggleShowConfirm() {
            this.showPasswordConfirm = !this.showPasswordConfirm;
        },
        saveChanges() {
            let user = {
                old_password: this.form.old_password,
                new_password: this.form.new_password,
                new_password_confirmation: this.form.new_password_confirmation
            };

            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, change it!"
            }).then(result => {
                if (result.isConfirmed) {
                    this.userChangePass({ user });
                }
            });
        },
        clear() {
            this.form.old_password = "";
            this.form.new_password = "";
            this.form.new_password_confirmation = "";
            this.errors.old_password = "";
            this.errors.new_password = "";
            this.showPasswordOld = false;
            this.showPasswordNew = false;
            this.showPasswordConfirm = false;
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
