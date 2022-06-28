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
                    placeholder="Select"
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
                    <tr class="tr" v-if="!SystemUser.length">
                        <td colspan="6" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(user, i) in SystemUser" :key="i" class="tr">
                        <td class="td ">
                            <div class="flex justify-start gap-2 items-center">
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
                                        size="small"
                                        shape="circle"
                                        icon="md-key"
                                    />
                                </Tooltip>
                                <Tooltip content="Edit Role" placement="bottom">
                                    <Button
                                        @click="openRole(user)"
                                        type="primary"
                                        size="small"
                                        shape="circle"
                                        icon="md-contacts"
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
                :pagination="pagination"
                @prev="previousPage(pagination.prevPageUrl)"
                @next="nextPage(pagination.nextPageUrl)"
            />
        </div>
        <Drawer
            :title="!editMode ? 'Add User' : 'Update User'"
            v-model="drawer"
            width="512"
            :closable="false"
        >
            <Form :model="form" label-position="left" :label-width="100">
                <FormItem label="Name">
                    <Input type="text" v-model="form.name" />
                    <Error :message="errors.name[0]" v-if="errors.name" />
                </FormItem>

                <FormItem label="Username">
                    <Input type="text" v-model="form.username" />
                    <Error
                        :message="errors.username[0]"
                        v-if="errors.username"
                    />
                </FormItem>
                <FormItem label="Password" v-if="!editMode">
                    <Input type="password" v-model="form.password" />
                </FormItem>
                <FormItem label="Usertype">
                    <Select
                        v-model="form.usertype"
                        placeholder="Please select a usertype"
                    >
                        <Option
                            :value="usertype.usertype"
                            v-for="(usertype, i) in FoodUsertype"
                            :key="i"
                            >{{ usertype.usertype }}</Option
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
                type="System"
                :id="id"
                :drawer="drawer2"
                :path="url"
            />
        </Drawer>

        <Drawer
            title="User Role"
            v-model="drawer3"
            width="512"
            :closable="false"
        >
            <UserRoleModal @close="drawer3 = !drawer3" />
        </Drawer>
    </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
import ChangePhoto from "../Modal/Change-Photo-User-System.vue";
import UserRoleModal from "../Modal/User-Role-Modal.vue";
export default {
    components: { ChangePhoto, UserRoleModal },
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Picture",
                name: "pic",
                class: "text-left"
            },
            {
                label: "Name",
                name: "reg_date",
                class: "text-left"
            },
            {
                label: "Usertype",
                name: "usertype",
                class: "text-center"
            },
            {
                label: "Status",
                name: "status",
                class: "text-center"
            },
            {
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
            loading: true,
            searchEmployee: "",
            selectedData: false,
            form: {
                id: "",
                name: "",
                username: "",
                usertype: "",
                password: ""
            },
            currentPage: 1,
            image: null,
            preview: null,
            preview2: null,
            id: "",
            roleFlag: false,
            drawer: false,
            drawer2: false,
            drawer3: false,
            url: ""
            // end form
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination", "FoodUsertype"]),
        ...mapState("User", ["SystemUser", "DefaultUsername"])
    },
    watch: {
        DefaultUsername() {
            this.form.username = this.DefaultUsername.username;
        }
    },
    methods: {
        ...mapActions(["getUserRole"]),
        ...mapActions("User", [
            "getSystemUser",
            "getDefaultUsername",
            "createSystemUser",
            "updateSystemUser",
            "changeSystemUserStatus",
            "systemResetPass"
        ]),
        ...mapMutations(["CLEAR_ERRORS"]),
        imgSrc(img) {
            return process.env.MIX_IMAGE_PATH + img;
        },
        resetPassword(user) {
            this.$Modal.confirm({
                title: "Reset Password",
                content: "<p>Do you want to reset the password?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.systemResetPass({ id: user.id });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        openRole(user) {
            this.drawer3 = !this.drawer3;
            this.getUserRole({ type: "System", id: user.id });
        },
        changeStatus(user) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeSystemUserStatus({
                        id: user.id,
                        status: user.active
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        changePhotoUser(id, image) {
            this.id = id;
            this.drawer2 = !this.drawer2;
            this.url = process.env.MIX_IMAGE_PATH + image;
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
                    title: "Oops!",
                    desc:
                        "Photo only allows file types of GIF, PNG, JPG, JPEG and BMP."
                });
                this.image = null;
            }
        },
        editInfo(user) {
            this.reset();
            this.getFoodUsertype({ type: "System" });
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = user.id;
            this.form.name = user.name;
            this.form.username = user.username;
            this.form.usertype = user.user_type;
        },
        updateUser() {
            let payload = {
                id: this.form.id,
                name: this.form.name,
                username: this.form.username,
                usertype: this.form.usertype
            };
            this.updateSystemUser(payload);
        },
        createUser() {
            let form = new FormData();
            form.append("image", this.image);
            form.append("name", this.form.name);
            form.append("username", this.form.username);
            form.append("password", this.form.password);
            form.append("usertype", this.form.usertype);

            this.createSystemUser(form);
        },
        addModal() {
            this.reset();
            this.getFoodUsertype({ type: "System" });
            this.getDefaultUsername({ type: "System" });
            this.drawer = !this.drawer;
        },
        reset() {
            this.preview = null;
            this.image = null;
            this.form.id = "";
            (this.form.name = ""),
                (this.form.username = ""),
                (this.form.usertype = ""),
                (this.form.password = "");
            (this.editMode = false), (this.id = "");
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getSystemUser({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
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
        Fire.$on("reload_system_user", () => {
            this.fetch();
            this.drawer = false;
            this.drawer2 = false;
        });
        this.fetch();
    }
};
</script>
