<template>
        <div
            class="bg-gray-50  p-2 font-inter w-full overflow-x-auto sm:hidden lg:block"
        >
            <div class="flex items-center  gap-4">
                <router-link
                    to="/goods"
                    class="flex items-center gap-1  text-black uppercase"
                    ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                        />
                    </svg>
                    <span>Home</span></router-link
                >
                <span class="text-black"> >> </span>
                <router-link
                    :to="menu.route"
                    v-for="(menu, i) in routes"
                    :key="i"
                    class="text-black uppercase "
                    v-bind:class="{
                        'border-b-2 border-yellow-500':
                            $route.path === menu.route
                    }"
                >
                    {{ menu.label }}
                </router-link>
            </div>
        </div>
</template>

<script>
export default {
    props: ["routes", "title"]
};
</script>
