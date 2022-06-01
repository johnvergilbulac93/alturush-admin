<template>
    <div class="flex items-center gap-4 ">
        <h2 v-text="currentTime" class="text-xl font-semibold "></h2>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: "Time:",
            currentTime: null
        };
    },
    methods: {
        updateCurrentTime() {
            this.currentTime = moment().format("LLLL");
        }
    },
    created() {
        this.currentTime = moment().format("LLLL");
        setInterval(() => this.updateCurrentTime(), 1 * 1000);
    }
};
</script>
