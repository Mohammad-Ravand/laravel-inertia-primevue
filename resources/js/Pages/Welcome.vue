<script setup>
import { Head, Link } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import Card from 'primevue/card'
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <UserLayout>

        <Head title="Welcome" />


        <div class="card flex flex-col justify-center mx-5 mt-10 shadow-md shadow-purple-500 ">
            <Card class="py-20 px-5 text-center">
                <template #title> News Website </template>

                <template #content>
                    <h2>Welcome to My News Website</h2>
                </template>
            </Card>
        </div>



    </UserLayout>
</template>

<style>

</style>
