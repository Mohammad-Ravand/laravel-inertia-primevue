
<script setup>
import LaravelPagination from '@/Components/LaravelPagination.vue';
import News from '@/Components/News.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {computed} from 'vue';
const props = defineProps({
    notify:{
        type:Object,
        required:false
    },
    newses:{
        type:Object,
        required:true
    },
    activeAction:{
        type:Boolean,
        default:false,
        required:false
    }
});

const listnewses =computed(()=> props.newses.data);

</script>

<style lang="scss" scoped>


</style>

<template>
    <AdminLayout :notify="props.notify">
        <section class="my-5 flex  justify-around flex-wrap gap-y-4 gap-2 mx-2">
            <template v-for="news in listnewses" :key="news.id">
                <News
                    :id="news.id"
                    :title="news.title"
                    :description="news.description"
                    :image="news.image"
                    :activeAction="props.activeAction"
                />
            </template>


            <LaravelPagination :links="props.newses.links" />

        </section>
    </AdminLayout>
</template>
