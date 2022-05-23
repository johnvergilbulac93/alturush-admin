<template>
    <div
        class="px-8 py-1.5 text-xs text-gray-500 font-medium cursor-pointer hover:text-gray-800 hover:bg-gray-200 "
        :class="{ 'text-gray-800': activeSubMenu }"
        @click="onClick"
    >
        {{ text }}
    </div>
</template>

<script>
export default {
    name: "TheSubMenuItem",
    props: {
        text: {
            type: String,
            required: true
        },
        route: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            activeSubMenu: false
        };
    },
    watch: {
        $route: {
            immediate: true,
            handler(val) {
                if (
                    val.name == this.route?.name ||
                    val.path == this.route?.path
                ) {
                    // this.$parent.setActiveMenu(true);
                    this.activeSubMenu = true;
                } else {
                    this.activeSubMenu = false;
                }
            }
        }
    },

    methods: {
        onClick() {
            if (this.route) this.$router.push(this.route).catch(() => {});
            else console.log("No action found!");
        }
    }
};
</script>
