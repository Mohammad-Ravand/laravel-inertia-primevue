
<script setup>
import { ref,computed } from "vue";
import Menubar from 'primevue/menubar'
import Badge from 'primevue/badge'
import Button from 'primevue/button'
import Dropdown from 'primevue/dropdown'
import InputText from "primevue/inputtext";
import Menu from "primevue/menu";
import Avatar from "primevue/avatar";
import Sidebar from "@/Components/Sidebar.vue";
import {Link} from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import navItems from '@/navbar.js';
import sidebarItems from '@/sidebar.js';
import { router,useForm ,usePage} from '@inertiajs/vue3';

const page = usePage();
const visible=ref(false);
const active=ref(false);

const logoutForm = useForm({

})

function logoutUser(){
    logoutForm
        .post(route('logout'), {
            onFinish: () => {

            }
        });
}

function goLink(path){

    router.visit(route(path))

}

const menu = ref();

const guestMenus = ref([{
    label: 'guest user',
        icon: 'pi pi-desktop',
        items: [
        {
            label: 'register',
            icon: 'pi pi-sign-in',
            url: '/register'
        },
        {
            label: 'login',
            icon: 'pi pi-user',
            url: '/login'

        }
]}]);

const loggedInMenus = ref([{
    label: 'profile user',
        icon: 'pi pi-desktop',
        items: [
    {
        label: 'profile',
        icon: 'pi pi-user',
        command: ()=> goLink('profile.edit')

    },
    {
        label: 'sign out',
        icon: 'pi pi-sign-out',
        command: ()=>logoutUser()
    }
]}]);


const menus = computed(()=>{
    if(page.props.auth.user){
        //return logged in menus
        return loggedInMenus.value;
    }else{
        // return  guest menus
        return guestMenus.value;
    }
});




const selectedCity = ref();
const cities = ref([
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
]);
const toggle = (event) => {
    menu.value.toggle(event);
};
const items = ref(navItems);

</script>

<template>
    <Navbar :navItems="navItems" :sidebarItems="sidebarItems" />
</template>
