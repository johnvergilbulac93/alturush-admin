<template>
    <div class="flex justify-between items-center p-2">
        <span class="text-sm"
            >Showing {{ !pagination.from ? 0 : pagination.from }} to
            {{ !pagination.to ? 0 : pagination.to }} of
            {{ pagination.total }} entries</span
        >
        <ButtonGroup>
            <Button
                type="warning"
                :disabled="!pagination.prevPageUrl"
                @click="$emit('prev')"
            >
                <Icon type="ios-arrow-back" />
                Prev
            </Button>
            <Button
                type="warning"
                :disabled="!pagination.nextPageUrl"
                @click="$emit('next')"
            >
                Next
                <Icon type="ios-arrow-forward" />
            </Button>
        </ButtonGroup>
    </div>
</template>

<script>
export default {
    props: ["pagination"],
    data() {
        return {
            buttonSize: "medium"
        };
    }
};
</script>
