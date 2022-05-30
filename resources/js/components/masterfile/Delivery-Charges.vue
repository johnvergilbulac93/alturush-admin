<template>
    <div class="space-y-2">
        <module-header icon="ios-bicycle" title="Delivery Charge" />
        <Tabs>
            <TabPane label="Goods" icon="md-bicycle">
                <GoodDeliveryCharge />
            </TabPane>
            <TabPane label="Foods" icon="md-bicycle">
                <FoodDeliveryCharge />
            </TabPane>
        </Tabs>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import GoodDeliveryCharge from "./../goods/pages/Masterfile/Delivery-charges.vue";
import FoodDeliveryCharge from "./../foods/pages/Masterfile/Delivery-Charges.vue";
export default {
    components: { GoodDeliveryCharge, FoodDeliveryCharge },
    methods: {
        ...mapActions([
            "getRangeLevel",
            "getProvince",
            "getBarangay",
            "getTown",
            "getTransportation"
        ])
    },
    mounted() {
        this.getRangeLevel();
        this.getProvince();
        this.getBarangay();
        this.getTown();
        this.getTransportation();
    }
};
</script>
