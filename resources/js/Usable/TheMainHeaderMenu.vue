<template>
    <header class="flex items-center mt-5 px-5">
        <img
            :src="$root.path + 'AlturushDeliveryLogoGradient.png'"
            alt="Logo"
            class="w-10"
        />
        <div class="ml-2 flex flex-col">
            <h1 class="text-sm text-gray-700 font-medium">Alturush Admin</h1>
            <p class="text-gray-400 text-xs">{{ text }}</p>
        </div>
    </header>
</template>

<script>
export default {
    name: "TheMainMenuHeader",
    props: {
        text: {
            type: String,
            required: true
        }
    }
};
</script>
