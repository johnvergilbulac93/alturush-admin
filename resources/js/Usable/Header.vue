<template>
    <div class=" rounded  bg-gray-200">
        <div class=" p-2 text-gray-500  flex gap-2 items-center ">
            <Icon :type="icon" size="26" />
            <label class=" text-lg font-semibold ">{{ title }}</label>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "icon"]
};
</script>
