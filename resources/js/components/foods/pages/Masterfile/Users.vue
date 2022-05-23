<template>
    <Tabs>
        <TabPane label="System Users" icon="ios-contacts">
            <SystemUser
        /></TabPane>
        <TabPane label="Tenant Users" icon="ios-contacts">
            <TenantUser
        /></TabPane>
    </Tabs>
</template>

<script>
import TenantUser from "./User/TenantUser.vue";
import SystemUser from "./User/SystemUser.vue";

export default {
    components: {
        TenantUser,
        SystemUser
    }
};
</script>
