<template>
    <div class="space-y-2">
        <module-header icon="md-analytics" title="Comments & Suggestions" />
        <ul class="flex items-center">
            <li>
                <a
                    href="#"
                    @click="unfoundTab"
                    class="px-3 py-2  text-gray-800 hover:text-[#2d8cf0]  transition duration-300 "
                    v-bind:class="
                        unfoundFlag
                            ? '  border-b-2 border-[#2d8cf0] text-[#2d8cf0]'
                            : ''
                    "
                    >Comments & Suggestions</a
                >
            </li>
            <li>
                <a
                    href="#"
                    @click="instructionTab"
                    class="px-3 py-2 text-gray-800 hover:text-[#2d8cf0]  transition duration-300 "
                    v-bind:class="
                        instructionFlag
                            ? '  border-b-2 text-[#2d8cf0] border-[#2d8cf0]'
                            : ''
                    "
                    >Special Instruction</a
                >
            </li>
        </ul>
        <section>
            <Instruction v-if="instructionFlag" :stores="Stores" />
            <CommentSuggestions v-if="unfoundFlag" :stores="Stores" />
        </section>
    </div>
</template>

<script>
import Instruction from "./ExtendedComponent/Special-Instruction.vue";
import CommentSuggestions from "./ExtendedComponent/Comment-Suggestions.vue";
import { mapActions, mapState } from "vuex";

export default {
    name: "Special-Instruction-Unfound-Items",
    components: {
        Instruction,
        CommentSuggestions
    },
    data() {
        return {
            instructionFlag: false,
            unfoundFlag: true
        };
    },
    computed: {
        ...mapState(["Stores", "errors"])
    },
    methods: {
        ...mapActions(["getStore"]),

        instructionTab() {
            this.instructionFlag = true;
            this.unfoundFlag = false;
        },
        unfoundTab() {
            this.instructionFlag = false;
            this.unfoundFlag = true;
        }
    },
    created() {
        this.getStore();
    }
};
</script>
