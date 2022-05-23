import BaseApi from "./BaseApi";

export default {
    upload_new_product(formData, axiosSource) {
        return BaseApi.post("/uploading/item", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
            cancelToken: axiosSource.token
        });
    },
    upload_price_update(formData, axiosSource) {
        return BaseApi.post("/uploading/item_price", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
            cancelToken: axiosSource.token
        });
    },
    upload_category(formData) {
        return BaseApi.post("/uploading/item_category", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    upload_image_filename(formData) {
        return BaseApi.post("/uploading/item_filename", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    batch_disable_item(formData) {
        return BaseApi.post("/uploading/item_disable", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    },
    update_description(formData, axiosSource) {
        return BaseApi.post("/uploading/item_description", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
            cancelToken: axiosSource.token
        });
    }
};
