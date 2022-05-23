<template>
    <div class=" space-y-2 border">
        <div class=" text-gray-800 overflow-x-auto">
            <div class="mb-2 bg-gray-100 p-2">
                <label for="" class="font-semibold text-lg"
                    >Upload Item code to disable
                </label>
            </div>
            <div class=" p-2">
                <div class="relative rounded">
                    <div
                        class="absolute inset-0 bg-white p-5 text-center"
                        v-if="loading"
                    >
                        <div
                            class="flex flex-col items-center justify-between space-y-4"
                        >
                            <label for="" class="mt-3 "
                                >Please be patient, the file is being uploaded.
                                Details about the upload are not
                                available.</label
                            >
                            <LoopingRhombusesSpinner
                                :animation-duration="2500"
                                :rhombus-size="20"
                                color="#ff1d5e"
                            />
                        </div>
                    </div>
                    <transition
                        enter-active-class="ease-out duration-500"
                        enter-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="ease-in duration-500"
                        leave-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div
                            class="mb-1 bg-red-500 bg-opacity-75 px-2 py-1 flex justify-between items-center  hover:bg-red-600 transition duration-500"
                            v-if="errors.file_item"
                        >
                            <small class="text-white text-sm ">
                                {{ errors.file_item[0] }}
                            </small>
                            <button
                                class="focus:outline-none"
                                @click="clearErrorMessage"
                            >
                                <i
                                    class="fas fa-times text-gray-50 hover:text-white"
                                ></i>
                            </button>
                        </div>
                    </transition>
                    <label
                        class="flex flex-col items-center px-4 py-5 border bg-white  uppercase  cursor-pointer hover:text-yellow-500 hover:border-yellow-500 transistion duration-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-10 w-10"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                            />
                        </svg>
                        <span class="mt-2 "
                            >Uploading for item code to disable</span
                        >
                        <small>(Click here to select file)</small>
                        <input
                            type="file"
                            id="file_item"
                            ref="file_item"
                            class="hidden"
                            @change="handleFile"
                        />
                    </label>
                </div>
                <transition
                    enter-active-class="ease-out duration-500"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-500"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="filename"
                        class="flex justify-between items-center mt-2 bg-white p-2 border border-gray-400 border-opacity-30 shadow-lg "
                    >
                        <label
                            for=""
                            class="text-green-500 font-bold text-xs"
                            >{{ filename }}</label
                        >
                        <div class=" text-white font-bold text-sm ">
                            <button
                                @click="upload"
                                class="bg-green-500 px-2 py-1 w-20 focus:outline-none hover:bg-green-600 transition duration-300 rounded "
                            >
                                Upload
                            </button>
                            <button
                                @click="cancel"
                                class="bg-red-500 px-2 py-1 w-20 focus:outline-none hover:bg-red-600 transition duration-300 rounded "
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import Upload from "../../../services/Uploading";
import { mapState, mapMutations } from "vuex";
import { LoopingRhombusesSpinner } from "epic-spinners";
export default {
    components: { LoopingRhombusesSpinner },
    data() {
        return {
            filename: "",
            file: "",
            loading: false
        };
    },
    computed: {
        ...mapState(["errors"])
    },
    methods: {
        ...mapMutations(["SET_ERRORS"]),
        clearErrorMessage() {
            this.errors.file_item = "";
        },
        handleFile() {
            this.file = this.$refs.file_item.files[0];
            this.filename = this.$refs.file_item.files[0].name;
            this.errors.file_item = "";
        },

        upload() {
            let formData = new FormData();
            formData.append("file_item", this.file);
            this.loading = true;
            Upload.batch_disable_item(formData)
                .then(() => {
                    this.filename = "";
                    this.loading = false;
                    swal.fire(
                        "Success",
                        "Uploaded Complete.",
                        "info"
                    );
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 422) {
                        this.SET_ERRORS(error.response.data.errors);
                    }
                });
        },
        cancel() {
            this.filename = "";
            this.errors.file_item = "";
        },
        handleSuccess() {
            swal.fire("Success", "Upload Complete.", "success");
        }
    }
};
</script>
