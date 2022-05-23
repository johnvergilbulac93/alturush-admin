<template>
    <div
        class=" fixed top-0 left-0 z-50 flex justify-center items-center w-full min-h-screen text-gray-800"
    >
        <div class="bg-white border border-gray-300 w-1/2 shadow-lg ">
            <div class="p-2 flex justify-between items-center">
                <label for="" class="text-lg tracking-wide"
                    >Select profile photo</label
                >
                <a @click="closeUpload" class="transition duration-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-gray-500 hover:text-red-500"
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
            <hr />
            <div class="p-3 my-2">
                <div class="text-red-600 text-xs ">
                    <ul v-for="(error, i) in errors.profile_image" :key="i">
                        <li>{{   }}</li>
                    </ul>
                </div>
                <label
                    class="flex flex-col items-center px-4 py-16 border bg-white  uppercase  cursor-pointer hover:text-yellow-500 hover:border-yellow-500 transistion duration-500"
                >
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
                            stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    <p>Select a photo from your computer</p>
                    <input
                        type="file"
                        id="profile_image"
                        ref="profile_image"
                        class="hidden"
                        @change="handleOnchange()"
                    />
                </label>
                <label for="" v-if="filename" class=" text-xs"
                    >{{ filename }}
                    <span><a @click="remove" class="underline">remove</a></span>
                </label>
            </div>
            <hr />
            <div class="p-2">
                <button
                    @click="handleUpload"
                    :disabled="!filename"
                    class=" text-center px-4 py-1 bg-blue-500 text-white hover:bg-blue-600 rounded transition duration-500 focus:outline-none disabled:opacity-50"
                >
                    Upload
                </button>
                <button
                    @click="cancelRequest"
                    :disabled="!filename"
                    class=" text-center px-4 py-1 bg-red-500 text-white hover:bg-red-600 rounded transition duration-500 focus:outline-none disabled:opacity-50"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import User from "../../../services/masterfile/User";
import { mapState, mapMutations } from "vuex";
import axios from "axios";
import NProgress from "nprogress";

export default {
    name: "Profile",
    data() {
        return {
            file: "",
            filename: "",
            request: null
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapMutations(["SET_ERRORS"]),
        closeUpload() {
            this.$root.upload_profile = false;
            this.errors.profile_image = "";
            this.file = "";
            this.filename = "";
        },
        handleOnchange() {
            this.file = this.$refs.profile_image.files[0];
            this.filename = this.$refs.profile_image.files[0].name;
        },
        cancelRequest() {
            if (this.request) {
                this.request.cancel("File upload has been cancelled.");
            }
        },
        remove() {
            this.file = "";
            this.filename = "";
            this.errors.profile_image = "";
        },
        handleUpload() {
            let formData = new FormData();
            formData.append("profile_image", this.file);
            let axiosSource = axios.CancelToken.source();
            this.request = { cancel: axiosSource.cancel };
            User.profilePhoto(formData, axiosSource)
                .then(() => {
                    toast.fire({
                        icon: "success",
                        title: "Success",
                        text: "Uploaded successfully."
                    });
                    this.$root.upload_profile = false;
                    this.file = "";
                    this.filename = "";
                    this.errors.profile_image = "";
                    location.reload();
                })
                .catch(error => {
                    NProgress.done()
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                    }
                });
        }
    }
};
</script>
