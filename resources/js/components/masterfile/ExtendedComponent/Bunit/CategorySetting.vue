<template>
    <div class="border rounded">
        <table class="min-w-full">
            <thead class="border-b tracking-normal">
                <tr>
                    <th class="p-2 text-left ">Category</th>
                    <th class="p-2 text-center ">Status</th>
                    <th class="p-2 text-center ">Action</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <tr class="tr" v-if="!GlobalCategory.length">
                    <td colspan="3" class="td text-center">
                        NO DATA AVAILABLE
                    </td>
                </tr>
                <tr v-for="(cat, i) in GlobalCategory" :key="i">
                    <td class="td ">{{ cat.category }}</td>
                    <td class="td text-center  w-5">
                        <Badge
                            class-name="w-5"
                            :status="
                                !checkCat(cat.id, cat.check_cat)
                                    ? 'success'
                                    : 'error'
                            "
                        />
                    </td>
                    <td class="td  text-center w-10">
                        <Tooltip content="Change Status" placement="bottom">
                            <Button
                                @click="changeStatus(cat.id)"
                                type="primary"
                                size="small"
                                shape="circle"
                                icon="ios-open-outline"
                            />
                        </Tooltip>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
    props: ["bunit_code"],
    computed: {
        ...mapState(["GlobalCategory"])
    },
    methods: {
        ...mapActions(["getGlobalCategory"]),
        ...mapActions("B_unit", ["updateCategoryStatus"]),
        checkCat(id, unavailable) {
            let status = false;
            unavailable.forEach(data => {
                if (
                    data.bunit_code == this.bunit_code &&
                    data.category_id == id
                ) {
                    status = true;
                }
            });
            return status;
        },
        changeStatus(id) {
            this.$Modal.confirm({
                title: "Change Status",
                content: "<p>Do you want to change the status?</p>",
                okText: "OK",
                cancelText: "Cancel",
                onOk: () => {
                    this.updateCategoryStatus({
                        category: id,
                        bunit_code: this.bunit_code
                    });
                },
                onCancel: () => {
                    this.$Message.info("You cancel");
                }
            });
        }
    },
    mounted() {
        Fire.$on("reload_sub_cat", () => {
            this.getGlobalCategory();
        });
        this.getGlobalCategory();
    }
};
</script>

<style></style>
