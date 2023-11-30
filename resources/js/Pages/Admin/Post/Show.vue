
<script setup>
import Post from '@/Components/Post.vue';
import Default from '@/Layouts/Default.vue';
import { Link } from '@inertiajs/vue3';
import {computed} from 'vue';
import Card from 'primevue/card'
import Button from 'primevue/button'
import Tag from 'primevue/tag'
import PostCategories from './PostCategories.vue';

function pickTextSlice(text){
    return text.substr(0,80)+' ...'
}
const props = defineProps({
    post:{
        type:Object,
        required:true
    },
    activeAction:{
        type:Boolean,
        default:false,
        required:false
    }
});


const listPosts =computed(()=> props.post.data);

</script>

<style lang="scss" scoped>


</style>

<template>
    <Default>
        <section class="my-5 flex  justify-around flex-wrap gap-y-4 gap-2 mx-2">

        <div class="card flex w-full align-items-center justify-center">
            <Card class="w-full mb-10 pb-10 md:w-4/5   lg:w-3/5 xl:w-2/5">
                <template #header>
                    <!-- <img class="" alt="user header"  :src="image" /> -->
                    <figure class="h-96 overflow-hidden">
                        <img class="object-fill w-full rounded-lg" :src="props.post.image" alt="image description">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Image caption</figcaption>
                    </figure>


                </template>
                <template #title> {{post.title}} </template>
                <!-- <template #subtitle> Card subtitle </template> -->
                <template #content>
                    <p class="m-0 pb-8">
                        {{post.description}}
                    </p>

                    <div class="flex gap-1 flex-wrap h-30">
                        <PostCategories :categories="post.categories" />
                    </div>

                </template>
                <template #footer v-if="props.activeAction" >
                    <div class="flex justify-end">
                        <Button rounded  icon="pi pi-pencil" class="bg-cyan-500"  />
                        <Button  rounded  icon="pi pi-eye"  class="mx-2 " />
                        <Button rounded  icon="pi pi-times"  severity="secondary" />
                    </div>

                </template>
            </Card>
        </div>


        </section>
    </Default>
</template>
