<script setup>
import { ref, computed, toRefs,watch } from 'vue';

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
import TabMenu from 'primevue/tabmenu';
import PreviousMap from 'postcss/lib/previous-map';


const props = defineProps({
    categories: {
        type: Array,
        required: true
    },
    news: {
        type: Object,
        required: true
    },
    notify:{
        type:Object,
        required:false
    },
});


const categoryOptions = computed(() => {
    return props.categories.map(category => ({ name: category.name, code: category.id }))
});

const selectedCategories = computed(() => {
    let r = props.news.categories.map(selectedCategory => {
        selectedCategory = JSON.parse(JSON.stringify(selectedCategory))
        let t= props.categories.find(cat => {
            return cat.id == selectedCategory.id;
        });

        return {name:t.name,code:t.id}
    });

    return r;
});

console.log('selectedCategories',selectedCategories.value)


const form = useForm({
    title: props.news.title ?? '',
    description: props.news.description ?? '',
    categories: selectedCategories.value,
    image: null
});


const postOldImage = ref(props.news.image);

const postImage = ref(null);

function getImage(data){
    try {
        return data.image[0];
    } catch (error) {
        return null;
    }
}

const submit = () => {
    form
        .transform((data) => ({
            ...data,
            image: getImage(data),
            categories: data.categories.map(category => category.code)
        }))
        .post(route('admin.news.updatePost',props.news.id), {
            onFinish: () => {

            }
        });
};

const activeMenu = ref(0);

const tabItems = ref([
    { label: 'current image', value: 'pi pi-home' },
    { label: 'upload new', value: 'pi pi-chart-line' },
]);

</script>

<template>
    <AdminLayout :notify="props.notify">
        <Card class="w-full m-auto mt-10 p-10  md:w-3/4 lg:w-1/2 bg-gray-50">
            <template #title>
                <h2 class="h-full text-center text-ellipsis">Create New Post</h2>
                <h2>form: {{ form.data.categories }}</h2>
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
                        <!-- <MultiSelect v-model="news.categories" :options="categoryOptions" optionLabel="categories" placeholder="Select Categories"
                        :maxSelectedLabels="3" class="w-full md:w-20rem" /> -->

                    <MultiSelect   v-model="form.categories" display="chip" :options="categoryOptions" optionLabel="name"
                            placeholder="Select Cities" :maxSelectedLabels="20" class="w-full md:w-20rem" />
                    </div>
                    <InputError class="mt-1 mb-2" :message="form.errors.categories" />

                    <TabMenu v-model:activeIndex="activeMenu" :model="tabItems" />
                    <br>
                    <!-- show old image -->
                    <Image v-show="activeMenu == 0" :src="postOldImage" alt="Image" width="250" preview />
                    <CustomeFileUploader v-show="activeMenu == 1" v-model="form.image" />

                    <InputError class="mt-1 mb-2" :message="form.errors.image" />


                    <div class="text-center mt-5">
                        <Button type="submit">update news</Button>
                    </div>

                </form>
            </template>
        </Card>
    </AdminLayout>
</template>



<style   scoped></style>
