<script setup>
import Tag from 'primevue/tag'
const props = defineProps({
    categories: {
        type: Array,
        required: true
    }
});

const tagColors = [
    'primary',
    'success',
    'info',
    'warning',
    'danger'
];

function randomTagColor() {
    const randomIndex = Math.floor(Math.random() * tagColors.length);
    return tagColors[randomIndex];
}

</script>

<template>
    <p class="text-gray-500 w-full">categories:</p>

    <div class="flex gap-1 flex-wrap text-md">
        <template v-for="category in props.categories">
            <Tag :severity="randomTagColor()">{{ category?.name }}</Tag>
        </template>
    </div>
</template>


<style scoped></style>
