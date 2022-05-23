<template>
    <transition name="fade">
        <div
            v-if="flag"
            class="fixed top-0 left-0 z-50 flex justify-center p-2 items-center w-full min-h-screen bg-black/30"
        >
            <slot></slot>
        </div>
    </transition>
</template>
<script>
export default {
    props: ["flag"]
};
</script>
