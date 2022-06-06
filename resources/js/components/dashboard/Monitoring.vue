<template>
    <section>
        <admin-dashboard v-if="$root.userType == 12 || $root.userType == 6 || $root.userType == 7 " />
        <store-dashboard v-else />
    </section>
</template>

<script>
import AdminDashboard from "./Admin-Dashboard.vue";
import StoreAdminDashboard from "./Store-Admin-Dashboard.vue";
export default {
    name: "Monitoring",
    components: {
        "admin-dashboard": AdminDashboard,
        "store-dashboard": StoreAdminDashboard
    }
};
</script>
