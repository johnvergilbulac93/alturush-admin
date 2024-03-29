<template>
    <div class="space-y-2">
        <module-header
            icon="md-cloud-upload"
            title="Upload Product Description"
        />
        <div class="flex justify-between items-center mt-">
            <label class="block">
                <span class="sr-only">Choose file</span>
                <input
                    @change="handleFileChange"
                    type="file"
                    id="product_desc_file"
                    class="focus:outline-none block w-full text-sm text-gray-500 file:cursor-pointer file:mr-4 file:py-2 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-500 hover:file:bg-blue-100"
                />
            </label>
            <div class="items-center gap-2">
                <Button
                    type="primary"
                    :loading="loading"
                    :disabled="!product"
                    @click="upload"
                >
                    {{ loading ? "Uploading..." : "Upload" }}
                </Button>
                <Button type="error" :disabled="!loading" @click="cancelUpload"
                    >Cancel</Button
                >
            </div>
        </div>
    </div>
</template>

<script>
import Http from "./../../../../services/Uploading";
import axios from "axios";
import NProgress from "nprogress";

export default {
    data() {
        return {
            loading: false,
            product: null,
            request: null
        };
    },
    methods: {
        handleFileChange(event) {
            let input = event.target;
            let validExtensions = ["csv"];
            let fileName = input.files[0].name;
            let fileNameExt = fileName.substr(fileName.lastIndexOf(".") + 1);
            if (validExtensions.includes(fileNameExt)) {
                if (input.files) {
                    this.product = input.files[0];
                }
            } else {
                this.$Notice.error({
                    title: "System Notification",
                    desc: "Allowed file type is only CSV."
                });
                this.product = null;
                document.getElementById("product_desc_file").value = "";
            }
        },
        reset() {
            this.loading = false;
            this.product = null;
            document.getElementById("product_desc_file").value = "";
        },
        async upload() {
            let payload = new FormData();
            payload.append("file_description", this.product);

            let source = axios.CancelToken.source();
            this.request = { cancel: source.cancel };

            try {
                NProgress.start();
                this.loading = true;
                const { status, data } = await Http.update_description(
                    payload,
                    source
                );
                if (status == 200) {
                    NProgress.hide();
                    this.$Notice.success({
                        title: "System Notification",
                        desc: `${data.msg}`
                    });
                    this.reset();
                }
            } catch (error) {
                NProgress.hide();
                this.loading = false;
                const { status, data } = error.response;
                switch (status) {
                    case 422:
                        let obj = data.errors;
                        for (let msg in obj) {
                            this.$Notice.error({
                                title: "System Notification",
                                desc: `${obj[msg]}`,
                                duration: 5
                            });
                        }
                        break;
                    case 500:
                        this.$toast.open({
                            message: "Internal Server Error.",
                            type: "error"
                        });
                        break;
                    default:
                        break;
                }
            }
        },
        cancelUpload() {
            if (this.request) {
                this.request.cancel("File upload has been cancelled.");
                this.$Notice.error({
                    title: "System Notification",
                    desc: "Upload Aborted."
                });
                this.loading = false;
            }
        }
    }
};
</script>
