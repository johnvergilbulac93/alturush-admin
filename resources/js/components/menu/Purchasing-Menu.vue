<template>
    <div class="mt-5 w-full border-l ">
        <MenuItem text="Dashboard" icon="fas fa-tachometer-alt" :route="{ name: 'dashboard' }" /> 
        <MenuItem text="Item Masterfile" icon="fas fa-shopping-bag" :route="{ name: 'item' }" />
        <MenuItem text="Upload item code to disable" icon="fas fa-file-upload" :route="{ name: 'disabled_item' }" /> 
        <MenuItem text="Item report" icon="fas fa-chart-line" :route="{ name: 'reports_store' }" /> 
    </div>
</template>
