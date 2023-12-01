<script setup>
import { ref, computed } from 'vue';

import Chips from 'primevue/chips'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import MultiSelect from 'primevue/multiSelect'
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Card from 'primevue/card';
import Button from 'primevue/button';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import CustomeFileUploader from '@/Components/CustomeFileUploader.vue';
import Toast from "primevue/toast";
// const toast = useToast();
import Image from 'primevue/image';


const props = defineProps({
    categories: {
        type: Array,
        required: true
    },
    notify:{
        type:Object,
        required:false
    },
});

const post = ref({
    title: '',
    description: '',
    categories: null
});


const categoryOptions = computed(() => {
    return props.categories.map(category => ({ name: category.name, code: category.id }))
});

const form = useForm({
    title: '',
    description: '',
    categories: [],
    image: null
});

const postImage = ref(null);





const submit = () => {
    form
        .transform((data) => ({
            ...data,
            image: data.image[0],
            categories: data.categories.map(category => category.code)
        }))
        .post(route('admin.post.store'), {
            onFinish: () => {

            }
        });
};

</script>

<template>
    <AdminLayout :notify="props.notify">
        <Card class="w-full m-auto mt-10 p-10  md:w-3/4 lg:w-1/2 bg-gray-50">
            <template #title>
                <h2 class="h-full text-center text-ellipsis">Create New Post</h2>
            </template>

            <template #content>

                <form class="m-3 " @submit.prevent="submit">


                    <span class="p-float-label mb-3">
                        <InputText id="title" class="w-full" v-model="form.title" />
                        <label for="title">title</label>
                    </span>
                    <InputError class="mt-1 mb-2" :message="form.errors.title" />



                    <span class="p-float-label my-2">
                        <Textarea v-model="form.description" class="w-full" rows="5" cols="30" />
                        <label>description</label>
                    </span>
                    <InputError class="mt-1 mb-2" :message="form.errors.description" />


                    <div class="card my-1 flex justify-content-center">
                        <!-- <MultiSelect v-model="post.categories" :options="categoryOptions" optionLabel="categories" placeholder="Select Categories"
                        :maxSelectedLabels="3" class="w-full md:w-20rem" /> -->


                        <MultiSelect v-model="form.categories" display="chip" :options="categoryOptions" optionLabel="name"
                            placeholder="Select Cities" :maxSelectedLabels="3" class="w-full md:w-20rem" />
                    </div>
                    <InputError class="mt-1 mb-2" :message="form.errors.categories" />




                    <CustomeFileUploader v-model="form.image" />
                    <InputError class="mt-1 mb-2" :message="form.errors.image" />




                    <div class="text-center mt-5">
                        <Button type="submit">save post</Button>
                    </div>

                </form>
            </template>
        </Card>
    </AdminLayout>
</template>



<style   scoped></style>
