<script setup>
import Card from 'primevue/card'
import Button from 'primevue/button'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    id:{
        type:Number,
        required:true
    },
    image:{
        type:String,
        required:true
    },
    title:{
        type:String,
        required:true
    },
    description:{
        type:String,
        required:true
    },
    activeAction:{
        type:Boolean,
        required:false,
        default:false
    }
});

function pickTextSlice(text){
    return text.substr(0,80)+' ...'
}

</script>
<template>
    <div class="card flex align-items-center justify-content-center">
        <Card style="width: 20em">
            <template #header>
                <!-- <img class="" alt="user header"  :src="image" /> -->
                <figure class="max-w-lg">
                    <img class="object-fill bg-red-600 w-full h-52 rounded-lg" :src="image" alt="image description">
                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Image caption</figcaption>
                </figure>
            </template>
            <template #title> {{title}} </template>
            <!-- <template #subtitle> Card subtitle </template> -->
            <template #content>
                <p class="m-0">
                    <!-- {{pickTextSlice(description)}} -->
                    {{ pickTextSlice('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, voluptas recusandae voluptate quam hic impedit sunt aliquam iste sapiente modi aperiam ullam nostrum!') }}
                </p>

                <div class="mt-4 text-center ">
                    <Link :href="`/news/${props.id}`" class="m-auto rounded-md text-sm px-3 py-2 bg-blue-500 text-white">
                        read more
                    </Link>
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
</template>

