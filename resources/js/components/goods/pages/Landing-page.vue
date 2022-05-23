<template>
    <div class="border h-96">
        <div class="flex  justify-center items-center ">
            <center class="mt-28 ">
                <h1 class=" text-6xl  ">Welcome Back</h1>
                <h1 class="text-lg  mt-5">{{ name }}</h1>
                <h4 class="text-sm  mt-5">
                    Copyright &copy;
                    <a @click="gotoWeb">Alturush | Administrator 2020</a>
                </h4>
            </center>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: null
        };
    },
    methods: {
        gotoWeb() {
            let url = process.env.MIX_WEB_ADMIN;
            window.open(url);
        }
    },
    mounted() {
        this.name = $("meta[name=name]").attr("content");
    }
};
</script>
