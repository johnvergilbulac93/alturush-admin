<template>
    <div class="space-y-2">
        <Button
            type="success"
            size="large"
            icon="ios-pricetag-outline"
            @click="changePrice"
            v-if="$root.userType == 15"
            >List of Order Requested Change Price</Button>
        <div class="w-full">
            <item-disabled />
        </div>
    </div>
</template>

<script>
import ItemDisabled from "./ExtendedComponent/Item-Disabled.vue";
export default {
    name: "Store-Dashboard",
    components: { "item-disabled": ItemDisabled },
    methods: {
        changePrice() {
            let url = process.env.MIX_URL_PRICE_CHANGES + btoa(this.$root.id);
            window.open(url);
        }
    }
};
</script>
