<template>
    <div class="mt-5 w-full border-l ">
        <MenuItem text="Dashboard" icon="fas fa-tachometer-alt" :route="{ name: 'dashboard' }" > </MenuItem>
        <MenuItem text="Uploading Item and Price" icon="fas fa-tachometer-alt" :route="{ name: 'uploading' }" > </MenuItem>
        <MenuItem text="Uploading Item Category and Filename" icon="fas fa-tachometer-alt" :route="{ name: 'setting' }" > </MenuItem>
    </div>
</template>
