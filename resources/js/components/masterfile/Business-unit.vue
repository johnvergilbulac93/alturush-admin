<template>
    <div class="space-y-2">
        <module-header icon="ios-cube" title="Business Unit(s)" />
        <div class="border p-2">
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
                        <tr class="tr" v-if="!Bunit.length">
                            <td colspan="7" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr v-for="(bu, i) in Bunit" :key="i" class="tr">
                            <td class="td ">
                                <div
                                    class="flex justify-start gap-2 items-center"
                                >
                                    <img
                                        class="h-6 w-6 object-cover rounded-full"
                                        :src="imgSrc(bu.logo)"
                                        alt="photo"
                                    />
                                    |
                                    <span
                                        @click="
                                            changePhotoUser(
                                                bu.bunit_code,
                                                bu.logo
                                            )
                                        "
                                        class="cursor-pointer underline text-blue-500"
                                        >Edit</span
                                    >
                                </div>
                            </td>
                            <td class="td">{{ bu.bunitgroup.bunit_group }}</td>
                            <td class="td">{{ bu.business_unit }}</td>
                            <td class="td">{{ bu.acroname }}</td>
                            <td class="td">
                                <Button
                                    type="primary"
                                    size="small"
                                    icon="ios-settings-outline"
                                    @click="categorySetting(bu)"
                                    >Category Setting</Button
                                >
                            </td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        bu.active == 1 ? 'Active' : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatus(bu)"
                                        size="small"
                                        :type="
                                            bu.active == 1 ? 'success' : 'error'
                                        "
                                        shape="circle"
                                        :icon="
                                            bu.active == 1
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip content="Edit " placement="bottom">
                                    <Button
                                        @click="editInfo(bu)"
                                        size="small"
                                        type="primary"
                                        shape="circle"
                                        icon="ios-open-outline"
                                    />
                                </Tooltip>
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
                :title="editMode ? 'Edit Business Unit' : 'Add Business Unit'"
                v-model="drawer"
                width="512"
                :closable="false"
            >
                <Form label-position="left" :label-width="120">
                    <FormItem label="Group">
                        <Select
                            v-model="form.group"
                            placeholder="Please select a group"
                        >
                            <Option value>Select a group</Option>
                            <Option
                                :value="bu.id"
                                v-for="(bu, i) in BuGroup"
                                :key="i"
                                >{{ bu.bunit_group }}</Option
                            >
                        </Select>
                        <Error :message="errors.group[0]" v-if="errors.group" />
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
                                <span class="sr-only"
                                    >Choose profile photo</span
                                >
                                <input
                                    @change="handleFileChange"
                                    type="file"
                                    ref="image_user_tenant"
                                    id="img_tenant"
                                    class="block w-full text-sm text-gray-500 file:cursor-pointer file:mr-4 file:py-2 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-500 hover:file:bg-orange-100"
                                />
                            </label>
                        </div>
                    </FormItem>
                    <FormItem label="Business unit">
                        <Input type="text" v-model="form.business_unit" />

                        <Error
                            :message="errors.business_unit[0]"
                            v-if="errors.business_unit"
                        />
                    </FormItem>
                    <FormItem label="Acroname">
                        <Input type="text" v-model="form.acroname" />

                        <Error
                            :message="errors.acroname[0]"
                            v-if="errors.acroname"
                        />
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
            <Drawer
                :title="title"
                v-model="drawer2"
                width="512"
                :closable="false"
            >
                <CategorySetting
                    @close="drawer2 = !drawer2"
                    :bunit_code="bunit_code"
                />
                <div class="w-full absolute bottom-0 left-0 border-t">
                    <div class="flex justify-end items-center">
                        <div class="p-2">
                            <Button type="default" @click="drawer2 = !drawer2"
                                >CANCEL</Button
                            >
                        </div>
                    </div>
                </div>
            </Drawer>
            <Drawer
                title="Change Picture"
                v-model="drawer3"
                width="512"
                :closable="false"
            >
                <ChangePhoto
                    @close="drawer3 = !drawer3"
                    :bunit_code="bu_id"
                    :drawer="drawer3"
                    :url="url"
                />
            </Drawer>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import CategorySetting from "./ExtendedComponent/Bunit/CategorySetting.vue";
import ChangePhoto from "./ExtendedComponent/Bunit/Change-Photo.vue";

export default {
    components: { CategorySetting, ChangePhoto },
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Logo",
                name: "logo",
                class: "text-left"
            },
            {
                label: "Group",
                name: "group",
                class: "text-left"
            },
            {
                label: "Business Unit",
                name: "bunit",
                class: "text-left"
            },
            {
                label: "Acroname",
                name: "acro",
                class: "text-left"
            },
            {
                label: "BU Categories ",
                name: "bunit_cat",
                class: "text-left"
            },
            {
                label: "Status ",
                name: "stat",
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
            form: {
                id: "",
                group: "",
                business_unit: "",
                acroname: ""
            },
            currentPage: 1,
            image: null,
            preview: null,
            id: "",
            bunit_code: "",
            bu_id: "",
            drawer: false,
            drawer2: false,
            drawer3: false,
            title: "",
            url: ""
        };
    },
    computed: {
        ...mapState(["errors", "perPage", "pagination", "BuGroup"]),
        ...mapState("B_unit", ["Bunit"])
    },
    methods: {
        ...mapMutations(["CLEAR_ERRORS"]),
        ...mapActions(["getBuGroup"]),
        ...mapActions("B_unit", [
            "getBUnit",
            "addBusinessUnit",
            "editBusinessUnit",
            "updateStatus"
        ]),
        imgSrc(img) {
            return process.env.MIX_IMAGE_PATH + img;
        },
        changePhotoUser(id, image) {
            this.bu_id = id;
            this.url = process.env.MIX_IMAGE_PATH + image;
            this.drawer3 = !this.drawer3;
        },
        changeStatus(bu) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: bu.bunit_code,
                        status: bu.active
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        editInfo(bu) {
            this.reset();
            this.editMode = true;
            this.drawer = !this.drawer;
            this.form.id = bu.bunit_code;
            this.form.group = bu.group_id;
            this.form.business_unit = bu.business_unit;
            this.form.acroname = bu.acroname;
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
                this.preview = null;
            }
        },
        update() {
            this.editBusinessUnit({
                id: this.form.id,
                group: this.form.group,
                business_unit: this.form.business_unit,
                acroname: this.form.acroname
            });
        },
        create() {
            let form = new FormData();
            form.append("image", this.image);
            form.append("group", this.form.group);
            form.append("business_unit", this.form.business_unit);
            form.append("acroname", this.form.acroname);

            this.addBusinessUnit(form);
        },
        categorySetting(bu) {
            this.reset();
            this.bunit_code = bu.bunit_code;
            this.title = `Current Status Category  [ ${bu.business_unit} ]`;
            this.drawer2 = !this.drawer2;
        },
        addModal() {
            this.reset();
            document.getElementById("img_tenant").value = "";
            this.editMode = false;
            this.drawer = !this.drawer;
        },
        reset() {
            (this.form.id = ""),
                (this.form.acroname = ""),
                (this.form.group = ""),
                (this.form.business_unit = ""),
                (this.editMode = false);
            (this.image = null), (this.preview = null);

            this.CLEAR_ERRORS();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column
            };
            this.getBUnit({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
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
        Fire.$on("reload_bunit", () => {
            this.fetch();
            this.drawer = false;
            this.drawer3 = false;
        });
        this.fetch();
        this.getBuGroup();
    }
};
</script>
