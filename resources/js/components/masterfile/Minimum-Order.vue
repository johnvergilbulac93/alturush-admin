<template>
    <div class="space-y-2">
        <module-header icon="ios-basket-outline" title="Minimum Order" />
        <Tabs>
            <TabPane label="Foods" icon="ios-basket-outline"
                ><minOrderFoods />
            </TabPane>
            <TabPane label="Goods" icon="ios-basket-outline"
                ><minOrderGoods />
            </TabPane>
        </Tabs>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import minOrderGoods from "../goods/pages/Masterfile/Minimum-Order.vue";
import minOrderFoods from "../foods/pages/Masterfile/Minimum-Order.vue";
export default {
    name: "Minimum-Order",
    components: { minOrderGoods, minOrderFoods },
    methods: {
        ...mapActions(["getStore", "getDepartment"])
    },
    mounted() {
        this.getStore();
        this.getDepartment();
    }
};
</script>
