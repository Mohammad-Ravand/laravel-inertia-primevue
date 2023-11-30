<script setup>
import {onMounted,watch,ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import AdminNavbar from '@/Features/Admin/AdminNavbar.vue';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import Button from 'primevue/button';

const props = defineProps({
    notify:{
        type:Object,
        required:false,
        default:{}
    }
});

const toast = useToast();


watch(()=> props.notify,(v)=>{
    toast.add({ severity: props.notify.type, summary: props.notify.title, detail:props.notify.content, group: 'tr', right: 3000 });
})




</script>

<template>

    <div class="card flex justify-content-center">
        <Toast position="top-right" group="tr" />
    </div>

    <AdminNavbar />
    <slot></slot>


</template>
