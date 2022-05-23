<template>
    <div class="space-y-2 b">
        <module-header icon="ios-basket" title="Product Lists" />
        <div class="border p-2">
            <div class="flex justify-between items-center my-2 ">
                <div class="flex gap-1 w-3/4  items-center">
                    <div class="w-60">
                        <Input
                            v-model="tableData.search"
                            @on-keyup="search"
                            placeholder="Search"
                            suffix="ios-search"
                            clearable
                            @on-clear="search"
                        />
                    </div>
                    <div class="w-60">
                        <Select
                            placeholder="Please select a category"
                            v-model="tableData.category"
                            @on-change="fetch()"
                            clearable
                            filterable
                        >
                            <Option
                                v-for="(category, index) in ItemCategory"
                                :key="index"
                                :value="category.category_name"
                            >
                                {{ category.category_name }}
                            </Option>
                        </Select>
                    </div>
                    <div class="w-40">
                        <Select
                            v-model="tableData.price_group"
                            @on-change="fetch()"
                        >
                            <Option value="TAGB">TAGBILARAN</Option>
                            <Option value="TALB">TALIBON</Option>
                        </Select>
                    </div>
                    <div class="w-48">
                        <Select
                            placeholder="Please select a store"
                            v-model="tableData.store"
                            @on-change="fetch()"
                        >
                            <Option
                                :value="store.bunit_code"
                                v-for="(store, i) in Stores"
                                :key="i"
                                >{{ store.business_unit }}</Option
                            >
                        </Select>
                    </div>
                </div>
                <div class="text-sm">
                    <span>Show</span>
                    <Select
                        v-model="tableData.length"
                        @on-change="fetch()"
                        style="width: 80px"
                        placeholder="Select"
                    >
                        <Option
                            v-for="(records, index) in perPage"
                            :key="index"
                            :value="records"
                            >{{ records }}
                        </Option>
                    </Select>
                    <span>Entries</span>
                </div>
            </div>
            <div class="border rounded">
                <Datatable
                    :columns="columns"
                    :sortKey="sortKey"
                    :sortOrders="sortOrders"
                    @sort="sortBy"
                >
                    <tbody class="tbody ">
                        <tr class="tr" v-if="!Products.length">
                            <td colspan="8" class="td text-center">
                                NO DATA AVAILABLE
                            </td>
                        </tr>
                        <tr
                            v-for="(product, i) in Products"
                            :key="i"
                            class="tr"
                        >
                            <td
                                class="td flex justify-center gap-2 items-center"
                            >
                                <img
                                    class="h-6 w-6 object-cover rounded-full"
                                    :src="sourceImage(product.image)"
                                    alt="photo"
                                />
                                |
                                <span
                                    @click="changeProductImage(product)"
                                    class="cursor-pointer underline text-blue-500"
                                    >Edit</span
                                >
                            </td>
                            <td class="td uppercase">{{ product.itemcode }}</td>
                            <td class="td ">
                                {{ product.product_name }}
                            </td>
                            <td class="td">{{ product.category_name }}</td>
                            <td class="text-center td">
                                <select
                                    v-if="product.item_price != 0"
                                    class="py-[0.4rem] px-4 w-20 border border-gray-300  cursor-pointer rounded"
                                    @change="getPrice($event, i)"
                                >
                                    <option
                                        v-for="(data,
                                        index) in product.item_price"
                                        :key="index"
                                        :value="
                                            data.price_with_vat | toCurrency2
                                        "
                                    >
                                        {{ data.UOM }}
                                    </option>
                                </select>

                                <span v-else class="text-xs text-red-500">
                                    NO PRICE AVAILABLE</span
                                >
                            </td>
                            <td class="td text-center font-semibold">
                                <span :id="`price-${i}`" class="text-blue-500 ">
                                    {{
                                        !product.item_price.length
                                            ? "0.00"
                                            : product.item_price[0]
                                                  .price_with_vat | toCurrency2
                                    }}</span
                                >
                            </td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        product.status === 'active'
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatus(product)"
                                        :type="
                                            product.status === 'active'
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        size="small"
                                        :icon="
                                            product.status === 'active'
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
                                    />
                                </Tooltip>
                            </td>
                            <td class="td text-center">
                                <Tooltip
                                    :content="
                                        product.item_not_available === null
                                            ? 'Active'
                                            : 'Inactive'
                                    "
                                    placement="left"
                                >
                                    <Button
                                        @click="changeStatusPerStore(product)"
                                        :type="
                                            product.item_not_available === null
                                                ? 'success'
                                                : 'error'
                                        "
                                        shape="circle"
                                        size="small"
                                        :icon="
                                            product.item_not_available === null
                                                ? 'md-checkmark'
                                                : 'md-close'
                                        "
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
        </div>
        <Drawer title="Update Image" v-model="drawer" width="512">
            <ProductImage
                @close="drawer = false"
                :product="product"
                :drawer="drawer"
            />
        </Drawer>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import ProductImage from "./ExtendedComponent/ProductImage.vue";
import _ from "lodash";

export default {
    name: "Central-Item",
    components: { ProductImage },
    data() {
        let sortOrders = {};
        let columns = [
            {
                label: "Image",
                name: "img",
                class: "text-left "
            },
            {
                label: "Code",
                name: "itemcode",
                class: "text-left w-20"
            },
            {
                label: "Description",
                name: "description",
                class: "text-left w-80"
            },
            {
                label: "Category",
                name: "category",
                class: "text-left"
            },
            {
                label: "UOM",
                name: "uom",
                class: "text-center"
            },
            {
                label: "Price",
                name: "price",
                class: "text-center"
            },
            {
                label: "Status",
                name: "status",
                class: "text-center"
            },
            {
                label: "Status Per Store",
                name: "sstatus",
                class: "text-center"
            }
        ];
        columns.forEach(column => {
            sortOrders[column.name] = -1;
        });
        return {
            viewImage: false,
            uploadImage: false,
            columns: columns,
            sortKey: "itemcode",
            sortOrders: sortOrders,
            file: "",
            filename: "",
            itemcode: "",
            imgsrc: "",
            loadingImage: false,
            tableData: {
                draw: 0,
                length: "10",
                search: "",
                column: 1,
                dir: "desc",
                category: "",
                price_group: "TAGB",
                store: ""
            },
            form: {
                product_id: "",
                itemcode: "",
                quantity: "",
                product_name: "",
                status: ""
            },
            currentPage: 1,
            drawer: false,
            image: null,
            product: null
        };
    },
    computed: {
        ...mapState([
            "Stores",
            "perPage",
            "errors",
            "pagination",
            "ItemCategory"
        ]),
        ...mapState("Product", ["Products"])
    },
    methods: {
        ...mapActions(["getStore", "modal", "getItemCategory"]),
        ...mapActions("Product", [
            "getItems",
            "updateStatus",
            "updateStatusPerStore"
        ]),

        reset() {
            this.errors.item_image = "";
            (this.filename = ""), (this.file = ""), (this.itemcode = "");
        },

        previousPage() {
            this.currentPage--;
            this.fetch();
        },
        nextPage() {
            this.currentPage++;
            this.fetch();
        },
        fetch() {
            let filterData = {
                length: this.tableData.length,
                search: this.tableData.search,
                dir: this.tableData.dir,
                column: this.tableData.column,
                category: this.tableData.category,
                price_group: this.tableData.price_group,
                store: this.tableData.store
            };
            this.getItems({
                currentPage: this.currentPage,
                filterData: filterData
            });
        },
        search: _.debounce(function() {
            this.fetch();
        }, 500),
        clear() {
            this.tableData.search = "";
            this.fetch();
        },
        getPrice(e, i) {
            $("#price-" + i).text(e.target.value);
        },
        sourceImage(image) {
            if (image == null) {
                let path =
                    process.env.MIX_IMAGE_PATH + "ITEM-IMAGES/" + "noimage.png";
                return path;
            } else {
                let path = process.env.MIX_IMAGE_PATH + "ITEM-IMAGES/" + image;
                return path;
            }
        },
        changeProductImage(product) {
            this.drawer = !this.drawer;
            this.product = product;
        },
        changeStatusPerStore(product) {
            if (this.tableData.store === "") {
                this.$Notice.warning({
                    title: "System Notification",
                    desc: "Please select a store first."
                });
                return;
            }
            let status = 0;

            if (product.item_not_available === null) {
                status = 1;
            } else {
                status = 0;
            }
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatusPerStore({
                        store: this.tableData.store,
                        itemcode: product.itemcode,
                        status: status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        },
        changeStatus(product) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateStatus({
                        id: product.product_id,
                        status: product.status
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
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
        Fire.$on("reload_product", () => {
            this.fetch();
            this.drawer = false;
        });
        this.fetch();
        this.getItemCategory();
        this.getStore();
    }
};
</script>
