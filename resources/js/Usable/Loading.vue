<template>
    <div
        class="fixed top-0 left-0 z-50 bg-white/50 backdrop-blur-sm flex justify-center items-center w-full h-screen overflow-y-auto"
    >
        <looping-rhombuses-spinner
            :animation-duration="2500"
            :rhombus-size="15"
            color="#ff1d5e"
        />
    </div>
</template>

<script>
import { LoopingRhombusesSpinner } from "epic-spinners";
export default {
    components: { LoopingRhombusesSpinner }
};
</script>
