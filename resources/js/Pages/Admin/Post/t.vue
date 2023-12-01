<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

import MultiSelect from 'primevue/multiSelect'

const props = defineProps({
    categories: {
        type: Array,
        required: true
    },
    post: {
        type: Object,
        required: true
    }
});

const categoryOptions = computed(() => {
    return props.categories.map(category => ({ name: category.name, code: category.id }))
});

const selectedCategories = computed(() => {
    let r = props.post.categories.map(selectedCategory => {
        selectedCategory = JSON.parse(JSON.stringify(selectedCategory))
        let t= props.categories.find(cat => {
            return cat.id == selectedCategory.id;
        });

        return {name:t.name,code:t.id}
    });

    return r;
});


const form = useForm({
    title: props.post.title ?? '',
    description: props.post.description ?? '',
    categories: selectedCategories.value,
    image: null
});




const submit = () => {
    form
        .transform((data) => ({
            ...data,
            image: data.image[0],
            categories: data.categories.map(category => category.code)
        }))
        .post(route('post.store'), {
            onFinish: () => {

            }
        });
};

</script>

<template>
    <
        <MultiSelect   v-model="form.categories" display="chip" :options="categoryOptions" optionLabel="name"
                placeholder="Select Cities" :maxSelectedLabels="20" class="w-full md:w-20rem" />
        </div>
        <InputError class="mt-1 mb-2" :message="form.errors.categories" />

</template>
