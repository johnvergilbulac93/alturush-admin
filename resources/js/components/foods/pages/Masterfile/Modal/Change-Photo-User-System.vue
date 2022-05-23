<template>
    <div class="flex flex-col justify-center">
        <div class="mt-10 mx-auto">
            <img
                v-if="preview"
                class="h-28 w-28 object-cover rounded"
                :src="preview"
                alt="Current profile photo"
            />
            <img
                v-else
                class="h-28 w-28 object-cover rounded"
                :src="path"
                alt="Current profile photo"
            />
        </div>
        <div class="mt-2 mx-auto">
            <input
                @change="handleChangeImage"
                type="file"
                ref="system_image"
                id="system_file"
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
                        :disabled="!this.image"
                        type="success"
                        @click="upload()"
                    >
                        UPLOAD
                    </Button>
                    <Button
                        type="default"
                        class="btn-cancel cursor-pointer"
                        @click="$emit('close')"
                    >
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
    props: ["id", "type", "drawer", "path"],
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
            document.getElementById("system_file").value = "";
        }
    },
    methods: {
        ...mapActions("User", ["updateSystemUserPhoto"]),

        upload() {
            let form = new FormData();
            form.append("image", this.image);
            form.append("id", this.id);

            this.updateSystemUserPhoto(form);
        },
        selectFile() {
            document.getElementById("system_file").click();
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
                        this.url = "";
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
                document.getElementById("system_file").value = "";
            }
        }
    }
};
</script>
