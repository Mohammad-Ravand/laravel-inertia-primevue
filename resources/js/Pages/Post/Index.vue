
<script setup>
import LaravelPagination from '@/Components/LaravelPagination.vue';
import Post from '@/Components/Post.vue';
import Default from '@/Layouts/Default.vue';
import {computed} from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';

const props = defineProps({
    notify:{
        type:Object,
        required:false
    },
    posts:{
        type:Object,
        required:true
    },
    activeAction:{
        type:Boolean,
        default:false,
        required:false
    }
});


const listPosts =computed(()=> props.posts.data)
</script>

<style lang="scss" scoped>


</style>

<template>
    <UserLayout :notify="props.notify">
        <section class="my-5 flex  justify-around flex-wrap gap-y-4 gap-2 mx-2">

            <template v-for="post in listPosts" :key="post.id">
                <Post
                    :id="post.id"
                    :title="post.title"
                    :description="post.description"
                    :image="post.image"
                    :activeAction="props.activeAction"
                />
            </template>

            <LaravelPagination :links="props.posts.links" />

        </section>
    </UserLayout>
</template>
