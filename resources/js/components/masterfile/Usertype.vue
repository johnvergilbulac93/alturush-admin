<template>
    <div class="space-y-2 ">
        <module-header icon="ios-contacts" title="Usertype" />
        <Tabs>
            <TabPane label="Tenant Usertype" icon="ios-contacts">
                <Tenant
            /></TabPane>
            <TabPane label="System Usertype" icon="ios-contacts">
                <System
            /></TabPane>
        </Tabs>
    </div>
</template>

<script>
import System from "./ExtendedComponent/Usertype/System.vue";
import Tenant from "./ExtendedComponent/Usertype/Tenant.vue";

export default {
    components: { System, Tenant },
    data() {
        return {
            currentTab: false
        };
    }
};
</script>
