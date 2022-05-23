<template>
    <div class="mt-5 w-full border-l ">
        <MenuItem text="Dashboard" icon="fas fa-tachometer-alt" :route="{ name: 'dashboard' }" />
        <MenuItem text="Export files" icon="fas fa-file-download" :route="{ name: 'export' }" />
    </div>
</template>
