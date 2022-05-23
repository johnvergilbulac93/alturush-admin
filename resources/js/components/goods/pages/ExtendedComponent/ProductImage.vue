<template>
    <div class="flex flex-col justify-center">
        <div class="mt-10 flex justify-center ">
            <img
                v-if="preview"
                class="h-64 w-64 object-cover rounded"
                :src="preview"
                alt="Current profile photo"
            />
            <img
                v-else
                class="h-64 w-64 object-cover rounded"
                :src="sourceImage()"
                alt="Current profile photo"
            />
        </div>
        <div class="mt-2 mx-auto">
            <input
                @change="handleChangeImage"
                type="file"
                ref="product_image"
                id="product_file"
                hidden
            />
            <Button @click="selectFile" type="primary" icon="md-camera"
                >Choose a photo</Button
            >
        </div>

        <div class=" w-full absolute bottom-0 left-0 border-t ">
            <div class="flex justify-end items-center">
                <div class="p-2">
                    <Button
                        type="success"
                        @click="upload()"
                        :disabled="!this.image"
                    >
                        UPLOAD
                    </Button>
                    <Button type="default" @click="$emit('close')">
                        CANCEL
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
    props: ["product", "drawer"],
    data() {
        return {
            image: null,
            preview: null
        };
    },
    watch: {
        drawer() {
            this.preview = null;
            this.image = null;
            document.getElementById("product_file").value = "";
        }
    },
    methods: {
        ...mapActions("Product", ["updateImage"]),
        sourceImage() {
            if (this.product != null) {
                if (this.product.image == null) {
                    let path =
                        this.$root.web_url + "ITEM-IMAGES/" + "noimage.png";
                    return path;
                } else {
                    let path =
                        this.$root.web_url +
                        "ITEM-IMAGES/" +
                        this.product.image;
                    return path;
                }
            }
        },
        upload() {
            let form = new FormData();
            form.append("image", this.image);
            form.append("id", this.product.product_id);
            form.append("itemcode", this.product.itemcode);
            this.updateImage(form);
        },
        selectFile() {
            document.getElementById("product_file").click();
        },
        handleChangeImage(event) {
            let input = event.target;
            let validExtensions = [
                "jpg",
                "png",
                "jpeg",
                "bmp",
                "JPEG",
                "JPG",
                "PNG",
                "BMP"
            ];
            let fileName = input.files[0].name;
            let fileNameExt = fileName.substr(fileName.lastIndexOf(".") + 1);
            if (validExtensions.includes(fileNameExt)) {
                if (input.files) {
                    let reader = new FileReader();
                    reader.onload = e => {
                        this.preview = e.target.result;
                    };
                    this.image = input.files[0];
                    reader.readAsDataURL(input.files[0]);
                } else {
                }
            } else {
                this.$Notice.error({
                    title: "Oops!",
                    desc:
                        "Photo only allows file types of GIF, PNG, JPG, JPEG and BMP."
                });
                this.image = null;
                document.getElementById("product_file").value = "";
            }
        }
    }
};
</script>
