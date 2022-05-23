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
                    <tr class="tr" v-if="!TenantFoods.length">
                        <td colspan="7" class="td text-center">
                            NO DATA AVAILABLE
                        </td>
                    </tr>
                    <tr v-for="(data, i) in TenantFoods" :key="i" class="tr">
                        <td class="td">
                            {{ data.businessunit.business_unit }}
                        </td>
                        <td class="td">
                            <div class="flex items-center gap-2">
                                <img
                                    v-if="data.logo"
                                    :src="$root.web_url + data.logo"
                                    alt="image"
                                    class="w-6 h-6 rounded-full"
                                />
                                <img
                                    :src="$root.path + 'noimage.png'"
                                    v-else
                                    alt="image"
                                    class="w-6 h-6 rounded-full"
                                />
                                |
                                <span
                                    @click="
                                        changePhotoTenant(
                                            data.tenant_id,
                                            data.logo
                                        )
                                    "
                                    class="cursor-pointer underline text-blue-500"
                                    >Edit</span
                                >
                            </div>
                        </td>
                        <td class="td">{{ data.tenant }}</td>
                        <td class="td">
                            {{ data.acroname != "null" ? data.acroname : "" }}
                        </td>
                        <td class="td">
                            {{
                                data.global_category
                                    ? data.global_category.category
                                    : ""
                            }}
                        </td>
                        <td class="td text-center">
                            <Badge
                                :count="data.contact_nums.length"
                                type="primary"
                            >
                                <Tooltip content="Contacts" placement="left">
                                    <Button
                                        @click="viewContacts(data)"
                                        size="small"
                                        icon="ios-call"
                                    />
                                </Tooltip>
                            </Badge>
                        </td>
                        <td class="td text-center">
                            <Tooltip
                                :content="
                                    data.active == 1 ? 'Active' : 'Inactive'
                                "
                                placement="left"
                            >
                                <Button
                                    @click="changeStatus(data)"
                                    size="small"
                                    :type="
                                        data.active == 1 ? 'success' : 'error'
                                    "
                                    shape="circle"
                                    :icon="
                                        data.active == 1
                                            ? 'md-checkmark'
                                            : 'md-close'
                                    "
                                />
                            </Tooltip>
                        </td>
                        <td class="td text-center ">
                            <Tooltip content="Edit" placement="bottom">
                                <Button
                                    @click="editInfo(data)"
                                    type="primary"
                                    size="small"
                                    shape="circle"
                                    icon="ios-open-outline"
                                />
                            </Tooltip>
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
        <Drawer :title="labelTenantName" width="512" v-model="drawer2">
            <Contacts :tenantId="tenantId" :tenantName="labelTenantName" />
        </Drawer>
        <Drawer title="Change Picture" width="512" v-model="drawer3">
            <ChangeImage
                @close="drawer3 = false"
                :id="id"
                :drawer="drawer3"
                :path="url"
            />
        </Drawer>
        <Drawer
            :title="!editMode ? 'Add Tenant' : 'Edit Tenant'"
            width="512"
            v-model="drawer"
        >
            <Form label-position="left" :label-width="150">
                <FormItem
                    label="Category"
                    prop="category"
                    :required="!editMode"
                >
                    <Select
                        placeholder="Please select a category"
                        v-model="form.category"
                    >
                        <Option value>Select a category</Option>
                        <Option
                            :value="data.id"
                            v-for="(data, i) in GlobalCategory"
                            :key="i"
                            >{{ data.category }}
                        </Option>
                    </Select>
                    <Error
                        :message="errors.category[0]"
                        v-if="errors.category"
                    />
                </FormItem>
                <FormItem
                    label="Business Unit"
                    prop="store"
                    :required="!editMode"
                >
                    <Select
                        placeholder="Please select a business unit"
                        v-model="form.store"
                    >
                        <Option value>Select a business unit</Option>
                        <Option
                            :value="store.bunit_code"
                            v-for="(store, i) in Stores"
                            :key="i"
                            >{{ store.business_unit }}
                        </Option>
                    </Select>
                    <Error :message="errors.store[0]" v-if="errors.store" />
                </FormItem>
                <FormItem
                    label="Tenant name"
                    prop="tenant_name"
                    :required="!editMode"
                >
                    <Input v-model="form.tenant_name" />
                    <Error
                        :message="errors.tenant_name[0]"
                        v-if="errors.tenant_name"
                    />
                </FormItem>
                <FormItem
                    label="Acroname"
                    prop="acroname"
                    :required="!editMode"
                >
                    <Input v-model="form.acroname" />
                    <Error
                        :message="errors.acroname[0]"
                        v-if="errors.acroname"
                    />
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
                                id="fileTenant"
                                class="block w-full text-sm text-gray-500 file:cursor-pointer file:mr-4 file:py-2 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-500 hover:file:bg-orange-100"
                            />
                        </label>
                    </div>
                </FormItem>
            </Form>
            <div class="w-full absolute bottom-0 left-0 border-t">
                <div class="flex justify-end items-center">
                    <div class="p-2">
                        <Button
                            type="success"
                            @click="editMode ? update() : create()"
                            >SUBMIT</Button
                        >
                        <Button type="default" @click="drawer = !drawer"
                            >CANCEL</Button
                        >
                    </div>
                </div>
            </div>
        </Drawer>
    </div>
</template>

<script>
import Contacts from "./ExtendedComponent/Tenant-Contacts.vue";
import ChangeImage from "./Modal/Tenant-Modal.vue";
import { mapActions, mapState, mapMutations } from "vuex";

export default {
    name: "TenantFood",
    components: { Contacts, ChangeImage },
    data() {
        let sortOrders = {};
        let columns = [
            {
                width: "15%",
                label: "Business Unit",
                name: "bu_id",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Logo",
                name: "logo",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Tenant",
                name: "tenant",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Acroname",
                name: "acro",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Category",
                name: "category",
                class: "text-left"
            },
            {
                width: "15%",
                label: "Contact #",
                name: "contact",
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
            sortKey: "id",
            sortOrders: sortOrders,
            tableData: {
                length: "10",
                search: "",
                column: 1,
                dir: "desc"
            },
            form: {
                id: "",
                category: "",
                store: "",
                tenant_name: "",
                acroname: ""
            },
            currentPage: 1,
            editMode: false,
            contacts: [],
            labelTenantName: "",
            drawer2: false,
            drawer: false,
            drawer3: false,
            tenantId: "",
            image: null,
            preview: null,
            id: "",
            url: ""
        };
    },
    computed: {
        ...mapState([
            "perPage",
            "pagination2",
            "errors",
            "GlobalCategory",
            "Stores"
        ]),
        ...mapState("Tenant", ["TenantFoods"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions("Tenant", [
            "getTenantFoods",
            "changeStatusTenantFoods",
            "saveFoodsTenant",
            "updateFoodsTenant",
            
        ]),
        changePhotoTenant(id, image) {
            this.id = id;
            this.drawer3 = true;
            this.url = this.$root.web_url + image;
        },
        addModal() {
            this.reset();
            this.editMode = false;
            this.drawer = true;
        },
        changeStatus(data) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.changeStatusTenantFoods({
                        id: data.tenant_id,
                        status: data.active
                    });
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
        update() {
            this.updateFoodsTenant({
                id: this.form.id,
                category: this.form.category,
                store: this.form.store,
                tenant_name: this.form.tenant_name,
                acroname: this.form.acroname
            });
        },
        create() {
            let form = new FormData();
            form.append("image", this.image);
            form.append("category", this.form.category);
            form.append("store", this.form.store);
            form.append("tenant_name", this.form.tenant_name);
            form.append("acroname", this.form.acroname);
            this.saveFoodsTenant(form);
        },
        reset() {
            document.getElementById("fileTenant").value = "";
            this.form.id = "";
            this.form.category = "";
            this.form.store = "";
            this.form.tenant_name = "";
            this.form.acroname = "";
            this.image = null;
            this.preview = null;
            this.editMode = false;
            (this.drawer2 = false), this.CLEAR_ERRORS();
        },
        editInfo(data) {
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = data.tenant_id;
            this.form.category = data.global_cat_id;
            this.form.store = data.bunit_code;
            this.form.tenant_name = data.tenant;
            this.form.acroname = data.acroname;
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir
            };
            this.getTenantFoods({
                filterData: filterData,
                currentPage: this.currentPage
            });
        },
        viewContacts(data) {
            this.drawer2 = true;
            this.labelTenantName = data.tenant;
            this.contacts = data.contact_nums;
            this.tenantId = data.tenant_id;
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
        Fire.$on("reload_foods_tenant", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
    }
};
</script>
