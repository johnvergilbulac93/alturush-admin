<template>
    <div class="text-xs">
        <div
            class="px-5 flex items-center py-2 group  hover:bg-gray-200  cursor-pointer"
            @click="onClick"
        >
            <Icon :type="icon" size="22" />
            <div class="pl-4 flex-grow flex items-center justify-between ">
                <div
                    class="text-sm  text-gray-500
                    font-semibold
                    group-hover:text-gray-600
                "
                >
                    {{ text }}
                </div>
                <span
                    class="material-icons text-gray-500 transform transition duration-100"
                    :class="{ 'rotate-180': showSubMenu }"
                    v-if="subMenuExists"
                    >keyboard_arrow_down</span
                >
            </div>
        </div>

        <div
            v-if="subMenuExists"
            class="px-2 h-0 overflow-hidden"
            :class="{ 'h-auto': showSubMenu }"
        >
            <slot name="sub-menu" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        },
        iconClass: {
            type: [String, Array, Object],
            default: ""
        },
        route: {
            type: Object,
            default: () => {}
        },
        active: {
            type: Boolean
        }
    },
    data() {
        return {
            showSubMenu: false
        };
    },
    computed: {
        subMenuExists() {
            return !!this.$slots["sub-menu"];
        }
    },
    // watch: {
    //     $route: {
    //         immediate: true,
    //         handler(val) {
    //             if (
    //                 val.name == this.route?.name ||
    //                 val.path == this.route?.path
    //             ) {
    //                 this.activeMenu = true;
    //             } else {
    //                 this.activeMenu = false;
    //             }
    //         }
    //     },
    //     active() {
    //         return this.$router.name === this.route.name;
    //     }
    // },
    methods: {
        onClick() {
            if (this.subMenuExists) {
                this.showSubMenu = !this.showSubMenu;
            } else {
                // this.$router.push(this.route);
                this.$router.push(this.route).catch(() => {});
            }
        }
    }
};
</script>
