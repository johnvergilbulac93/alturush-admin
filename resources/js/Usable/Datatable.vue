<template>
    <table class="min-w-full table-auto">
        <thead class="  text-gray-600 border-b ">
            <tr class="tracking-wide ">
                <th
                    v-for="column in columns"
                    :key="column.name"
                    @click="$emit('sort', column.name)"
                    class="p-3 font-semibold"
                    :class="[
                        sortKey === column.name
                            ? sortOrders[column.name] > 0
                                ? 'sorting_up'
                                : 'sorting_down'
                            : 'sorting_both',
                        column.class,
                        'mx-2'
                    ]"
                    style="cursor:pointer;"
                >
                    {{ column.label }}
                </th>
            </tr>
        </thead>
        <slot></slot>
    </table>
</template>

<script>
export default {
    props: ["columns", "sortKey", "sortOrders"]
};
</script>
