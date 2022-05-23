<template>
    <div class="space-y-2 ">
        <div
            class="text-gray-800 overflow-x-auto rounded flex justify-between items-center bg-gray-200"
        >
            <module-header icon="ios-contact" title="Manage User" />
            <div class="flex items-center p-2 rounded  gap-4">
                <label
                    class="font-semibold cursor-pointer "
                    :class="check ? ' text-gray-400' : 'text-gray-500 '"
                    @click="check = false"
                    >Foods User(s)</label
                >
                <i-switch v-model="check" />
                <label
                    class="font-semibold cursor-pointer "
                    :class="check ? ' text-gray-500' : 'text-gray-400'"
                    @click="check = true"
                    >Goods User(s)</label
                >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-2 text-teal-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>
        </div>

        <GoodUsers v-if="check" />
        <FoodUsers v-if="!check" />
    </div>
</template>

<script>
import GoodUsers from "../goods/pages/Masterfile/Users.vue";
import FoodUsers from "../foods/pages/Masterfile/Users.vue";
export default {
    components: { GoodUsers, FoodUsers },
    data() {
        return {
            check: false
        };
    }
};
</script>
