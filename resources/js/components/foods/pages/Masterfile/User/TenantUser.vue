<template>
    <div class="border-x border-b p-2">
        <div class="flex justify-end">
            <Tooltip content="Add" placement="right">
                <Button
                    icon="md-add"
                    type="warning"
                    @click="addModal"
                    shape="circle"
                />
            </Tooltip>
        </div>
        <div class="flex justify-between items-center my-2">
            <Input
                v-model="tableData.search"
                @on-keyup="search"
                placeholder="Search"
                style="width: 40%;"
                suffix="ios-search"
                clearable
                @on-clear="search"
            />
            <div class="justify-end items-center flex gap-1">
                <span class="sm:hidden md:block">Show</span>
                <Select
                    v-model="tableData.length"
                    @on-change="fetch()"
                    style="width: 80px;"
                >
                    <Option
                        v-for="(records, index) in perPage"
                        :key="index"
                        :value="records"
                        >{{ records }}</Option
                    >
                </Select>
                <span class="sm:hidden md:block">Entries</span>
            </div>
        </div>
        <div class="border rounded">
            <Datatable
                :columns="columns"
                :sortKey="sortKey"
                :sortOrders="sortOrders"
                @sort="sortBy"
            >
                <tbody class="tbody">
                    <tr class="tr" v-if="!TenantUser.length">
                        <td colspan="6" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(user, i) in TenantUser" :key="i" class="tr">
                        <td class="td uppercase">{{ user.business_unit }}</td>
                        <td class="td">{{ user.tenant }}</td>
                        <td class="td ">
                            <div class="flex justify-center gap-2 items-center">
                                <img
                                    class="h-6 w-6 object-cover rounded-full"
                                    :src="imgSrc(user.image)"
                                    alt="photo"
                                />
                                |
                                <span
                                    @click="
                                        changePhotoUser(user.id, user.image)
                                    "
                                    class="cursor-pointer underline text-blue-500"
                                    >Edit</span
                                >
                            </div>
                        </td>
                        <td class="td">{{ user.name }}</td>
                        <td class="td text-center uppercase">
                            {{ user.user_type }}
                        </td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    user.active == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(user)"
                                    size="small"
                                    :type="
                                        user.active == 1 ? 'success' : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        user.active == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td text-center">
                            <div class="flex gap-1 items-center justify-center">
                                <Tooltip
                                    content="Reset Password"
                                    placement="bottom"
                                >
                                    <Button
                                        @click="resetPassword(user)"
                                        type="primary"
                                        shape="circle"
                                        size="small"
                                        icon="md-key"
                                    />
                                </Tooltip>
                                <Tooltip content="Edit User" placement="bottom">
                                    <Button
                                        @click="editInfo(user)"
                                        type="primary"
                                        size="small"
                                        shape="circle"
                                        icon="ios-open-outline"
                                    />
                                </Tooltip>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </Datatable>
            <Pagination
                :pagination="pagination2"
                @prev="previousPage(pagination2.prevPageUrl)"
                @next="nextPage(pagination2.nextPageUrl)"
            />
        </div>
        <Drawer
            :title="!editMode ? 'Add User' : 'Update User'"
            v-model="drawer"
            width="512"
            :mask-closable="false"
        >
            <Form :model="form" label-position="left" :label-width="100">
                <FormItem label="Store">
                    <Select
                        v-model="form.store"
                        @on-change="viewTenant"
                        placeholder="Please select a store"
                        default-label
                    >
                        <Option value>Select Store</Option>
                        <Option
                            :value="store.bunit_code"
                            v-for="(store, i) in Stores"
                            :key="i"
                            >{{ store.business_unit }}</Option
                        >
                    </Select>
                    <Error :message="errors.store[0]" v-if="errors.store" />
                </FormItem>
                <FormItem label="Title name">
                    <Select
                        placeholder="Please select a tenant"
                        v-model="form.tenant"
                        :disabled="!SelectedTenant.length"
                    >
                        <Option
                            :value="tenant.tenant_id"
                            v-for="(tenant, i) in SelectedTenant"
                            :key="i"
                            >{{ tenant.tenant }}</Option
                        >
                    </Select>
                    <Error :message="errors.tenant[0]" v-if="errors.tenant" />
                </FormItem>
                <FormItem label="Picture" v-if="!editMode">
                    <div class="w-full flex gap-5 items-center">
                        <img
                            v-if="preview"
                            class="h-14 w-14 object-cover rounded-full"
                            :src="preview"
                            alt="Current profile photo"
                        />
                        <img
                            v-if="!preview"
                            class="h-14 w-14 object-cover rounded-full"
                            :src="$root.path + 'noimage.png'"
                            alt="Current profile photo"
                        />
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input
                                @change="handleFileChange"
                                type="file"
                                ref="image_user_tenant"
                                class="block w-full text-sm text-gray-500 file:cursor-pointer file:mr-4 file:py-2 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-500 hover:file:bg-orange-100"
                            />
                        </label>
                    </div>
                </FormItem>
                <FormItem label="Name">
                    <Input type="text" v-model="form.name" />
                    <Error :message="errors.name[0]" v-if="errors.name" />
                </FormItem>
                <FormItem label="Username">
                    <Input type="text" v-model="form.username" />
                </FormItem>
                <FormItem label="Password">
                    <Input type="password" v-model="form.password" />
                </FormItem>
                <FormItem label="Usertype">
                    <Select
                        v-model="form.usertype"
                        placeholder="Please select a usertype"
                    >
                        <Option
                            :value="usertype.usertype.toLowerCase()"
                            v-for="(usertype, i) in FoodUsertype"
                            :key="i"
                        >
                            {{ usertype.usertype }}</Option
                        >
                    </Select>
                    <Error
                        :message="errors.usertype[0]"
                        v-if="errors.usertype"
                    />
                </FormItem>
            </Form>
            <div class="w-full absolute bottom-0 left-0 border-t">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button
                            type="success"
                            @click="editMode ? updateUser() : createUser()"
                            >SUBMIT</Button
                        >
                        <Button type="default" @click="drawer = !drawer"
                            >CANCEL</Button
                        >
                    </div>
                </div>
            </div>
        </Drawer>
        <Drawer
            title="Change Picture"
            v-model="drawer2"
            width="512"
            :closable="false"
        >
            <ChangePhoto
                @close="drawer2 = !drawer2"
                :id="id"
                :drawer="drawer2"
                :path="url"
            />
        </Drawer>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import ChangePhoto from "../Modal/Change-Photo-User-Tenant.vue";

export default {
    components: { ChangePhoto },
    data() {
        let sortOrders = {};
        let columns = [
            {
                width: "25%",
                label: "Business Unit",
                name: "bu",
                class: "text-left"
            },
            {
                width: "25%",
                label: "Tenant",
                name: "tenant",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Picture",
                name: "loc",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Fullname",
                name: "reg_date",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Usertype",
                name: "inactive_date",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Status",
                name: "status",
                class: "text-center"
            },
            {
                width: "15%",
                label: "Action",
                name: "action",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            columns: columns,
            sortKey: "itemcode",
            sortOrders: sortOrders,
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "desc"
            },
            editMode: false,
            form: {
                id: "",
                name: "",
                username: "",
                usertype: "",
                password: "",
                store: "",
                tenant: ""
            },
            currentPage: 1,
            image: null,
            preview: null,
            preview2: null,
            id: "",
            drawer: false,
            drawer2: false,
            url: ""

            // end form
        };
    },
    computed: {
        ...mapState([
            "errors",
            "perPage",
            "pagination2",
            "isModal",
            "isModal2",
            "Stores",
            "SelectedTenant",
            "FoodUsertype"
        ]),
        ...mapState("User", ["TenantUser", "DefaultUsername"])
    },
    watch: {
        DefaultUsername() {
            this.form.username = this.DefaultUsername.username;
        }
    },
    methods: {
        ...mapActions([
            "modal",
            "modal2",
            "getStore",
            "getSelectedTenant",
            "getFoodUsertype"
        ]),
        ...mapActions("User", [
            "getDefaultUsername",
            "getTenantUser",
            "updateTenantUser",
            "createTenantUser",
            "tenantResetPass",
            "changeTenantUserStatus"
        ]),
        imgSrc(img) {
            return process.env.MIX_IMAGE_PATH + img; 
        },
        changePhotoUser(id, image) {
            this.id = id;
            this.drawer2 = !this.drawer2;
            this.url = process.env.MIX_IMAGE_PATH + image;
        },
        changeStatus(user) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeTenantUserStatus({
                        id: user.id,
                        status: user.active
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        updateUser() {
            let payload = {
                id: this.form.id,
                store: this.form.store,
                tenant: this.form.tenant,
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype
            };
            this.updateTenantUser(payload);
        },
        createUser() {
            let form = new FormData();
            form.append("image", this.image);
            form.append("store", this.form.store);
            form.append("tenant", this.form.tenant);
            form.append("name", this.form.name);
            form.append("username", this.form.username);
            form.append("password", this.form.password);
            form.append("usertype", this.form.usertype);

            this.createTenantUser(form);
        },
        resetPassword(user) {
            this.$Modal.confirm({
                title: "Reset Password",
                content: "<p>Do you want to reset the password?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.tenantResetPass({ id: user.id });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        handleFileChange(event) {
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
                }
            } else {
                this.$Notice.error({
                    title: "System Information!",
                    desc:
                        "Photo only allows file types of GIF, PNG, JPG, JPEG and BMP.. "
                });
                this.image = null;
            }
        },
        viewTenant() {
            this.getSelectedTenant({ id: this.form.store });
        },
        addModal() {
            this.reset();
            this.getDefaultUsername({ type: "Tenant" });
            this.getFoodUsertype({ type: "Tenant" });
            this.drawer = !this.drawer;
            this.editMode = false;
        },
        reset() {
            (this.image = null), (this.preview = null);
            (this.form.id = ""),
                (this.form.name = ""),
                (this.form.username = ""),
                (this.form.usertype = ""),
                (this.form.store = ""),
                (this.form.tenant = ""),
                (this.form.password = "");
        },
        editInfo(user) {
            this.reset();
            this.editMode = true;
            this.getFoodUsertype({ type: "Tenant" });
            this.drawer = !this.drawer;
            this.form.id = user.id;
            this.form.name = user.name;
            this.form.username = user.username;
            this.form.usertype = user.user_type;
            this.form.store = user.bunit_code;
            this.getSelectedTenant({ id: user.bunit_code });
            this.form.tenant = user.tenant_id;
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getTenantUser({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.fetch();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        }
    },
    mounted() {
        Fire.$on("reload_tenant_user", () => {
            this.fetch();
            this.drawer = false;
            this.drawer2 = false;
        });
        this.fetch();
        this.getStore();
    }
};
</script>
