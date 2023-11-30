
<script setup>
import LaravelPagination from '@/Components/LaravelPagination.vue';
import News from '@/Components/News.vue';
import Default from '@/Layouts/Default.vue';
import {computed} from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';

const props = defineProps({
    notify:{
        type:Object,
        required:false
    },
    newss:{
        type:Object,
        required:true
    },
    activeAction:{
        type:Boolean,
        default:false,
        required:false
    }
});

const listNewss =computed(()=> props.newss.data)
</script>

<style lang="scss" scoped>


</style>

<template>
    <UserLayout :notify="props.notify">
        <section class="my-5 flex  justify-around flex-wrap gap-y-4 gap-2 mx-2">

            <template v-for="news in listNewss" :key="news.id">
                <News
                    :id="news.id"
                    :title="news.title"
                    :description="news.description"
                    :image="news.image"
                    :activeAction="props.activeAction"
                />
            </template>


            <LaravelPagination :links="props.newss.links" />

        </section>
    </UserLayout>
</template>
