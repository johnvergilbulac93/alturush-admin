<template>
    <div class="space-y-2">
        <module-header icon="ios-home" title="Tenant" />
        <Tabs>
            <TabPane label="Goods" icon="ios-home">
                <GoodsTenant />
            </TabPane>
            <TabPane label="Foods" icon="ios-home">
                <FoodTenant />
            </TabPane>
        </Tabs>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import FoodTenant from "./../foods/pages/Masterfile/Tenant.vue";
import GoodsTenant from "../goods/pages/Masterfile/Tenant.vue";
export default {
    name: "Tenants",
    components: { FoodTenant, GoodsTenant },
    methods: {
        ...mapActions(["getStore", "getDepartment", "getGlobalCategory"])
    },
    mounted() {
        this.getStore();
        this.getDepartment();
        this.getGlobalCategory();
    }
};
</script>
