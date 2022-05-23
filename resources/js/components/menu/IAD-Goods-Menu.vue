<template>
    <div class="mt-5 w-full border-l ">
        <MenuItem text="Dashboard" icon="fas fa-tachometer-alt" :route="{ name: 'dashboard' }" />
        <MenuItem text="Liquidition Report" icon="fas fa-chart-line" :route="{ name: 'liquidition_store' }" />
        <MenuItem text="Cashier Accountability Report" icon="fas fa-chart-line" :route="{ name: 'accountability_store' }" />
    </div>
</template>
    