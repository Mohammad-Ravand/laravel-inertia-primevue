
<script setup>
import { ref,computed } from "vue";
import Menubar from 'primevue/menubar'
import Badge from 'primevue/badge'
import Button from 'primevue/button'
import Dropdown from 'primevue/dropdown'
import InputText from "primevue/inputtext";
import Menu from "primevue/menu";
import Avatar from "primevue/avatar";
import Sidebar from "./Sidebar.vue";
import {Link} from '@inertiajs/vue3';

import { router,useForm ,usePage} from '@inertiajs/vue3';


const props = defineProps({
    sidebarItems:{
        type:Array,
        required:true
    },
    navItems:{
        type:Array,
        required:true
    }
});

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

const toggle = (event) => {
    menu.value.toggle(event);
};

const items = computed(()=>{
    return props.navItems
})

</script>

<template>
    <div class="card">

        <Menubar   :model="items"   :pt="{
        action: ({ props, state, context }) => ({
          button: 'one',
          class: context.active
            ? 'bg-primary-200 border-round-sm'
            : context.focused
            ? 'bg-primary-300 border-round-sm'
            : undefined,
        }),
        button: (instance,props,state,context,global) => ({ class: 'hidden' }),
      }">
            <template  #menubuttonicon="{active}">

            </template>

            <template #start>
                <Sidebar  v-model="visible" :items="sidebarItems"/>
                <!-- <svg width="35" height="40" viewBox="0 0 35 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-2rem">
                    <path
                        d="M25.87 18.05L23.16 17.45L25.27 20.46V29.78L32.49 23.76V13.53L29.18 14.73L25.87 18.04V18.05ZM25.27 35.49L29.18 31.58V27.67L25.27 30.98V35.49ZM20.16 17.14H20.03H20.17H20.16ZM30.1 5.19L34.89 4.81L33.08 12.33L24.1 15.67L30.08 5.2L30.1 5.19ZM5.72 14.74L2.41 13.54V23.77L9.63 29.79V20.47L11.74 17.46L9.03 18.06L5.72 14.75V14.74ZM9.63 30.98L5.72 27.67V31.58L9.63 35.49V30.98ZM4.8 5.2L10.78 15.67L1.81 12.33L0 4.81L4.79 5.19L4.8 5.2ZM24.37 21.05V34.59L22.56 37.29L20.46 39.4H14.44L12.34 37.29L10.53 34.59V21.05L12.42 18.23L17.45 26.8L22.48 18.23L24.37 21.05ZM22.85 0L22.57 0.69L17.45 13.08L12.33 0.69L12.05 0H22.85Z"
                        fill="var(--primary-color)"
                    />
                    <path
                        d="M30.69 4.21L24.37 4.81L22.57 0.69L22.86 0H26.48L30.69 4.21ZM23.75 5.67L22.66 3.08L18.05 14.24V17.14H19.7H20.03H20.16H20.2L24.1 15.7L30.11 5.19L23.75 5.67ZM4.21002 4.21L10.53 4.81L12.33 0.69L12.05 0H8.43002L4.22002 4.21H4.21002ZM21.9 17.4L20.6 18.2H14.3L13 17.4L12.4 18.2L12.42 18.23L17.45 26.8L22.48 18.23L22.5 18.2L21.9 17.4ZM4.79002 5.19L10.8 15.7L14.7 17.14H14.74H15.2H16.85V14.24L12.24 3.09L11.15 5.68L4.79002 5.2V5.19Z"
                        fill="var(--text-color)"
                    />
                </svg> -->
            </template>
            <template #item="{ item, props, hasSubmenu, root }">
                <Component :is="((item?.href) ? Link : 'a')" :href="((item?.href) ? item.href : null)" ripple class="flex align-items-center" v-bind="props.action">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                    <Badge v-if="item.badge" :class="{ 'ml-auto': !root, 'ml-2': root }" :value="item.badge" />
                    <span v-if="item.shortcut" class="ml-auto border-1 surface-border border-round surface-100 text-xs p-1">{{ item.shortcut }}</span>
                    <i v-if="hasSubmenu" :class="['pi pi-angle-down text-primary', { 'pi-angle-down ml-2': root, 'pi-angle-right ml-auto': !root }]"></i>
                </Component>
            </template>
            <template #end>
                <div class="flex align-items-center gap-2">
                    <InputText placeholder="Search" type="text"   class="w-8rem sm:w-auto" />

                    <!-- <div class="flex justify-center items-center">
                    </div> -->


                    <div v-if="$page.props.auth.user"  class="card flex justify-content-center">
                        <Button type="button" class="p-0 m-0 flex bg-transparent justify-center items-center" @click="toggle" aria-haspopup="true" aria-controls="overlay_menu" >
                            <Avatar
                            type="button" class="h-10 w-10" image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"   shape="circle" />


                        </Button>
                        <Menu  ref="menu" id="overlay_menu" :model="menus" :popup="true" />
                    </div>


                    <div v-else  class="card flex justify-content-center">
                        <Button type="button" class="p-0 m-0 flex bg-transparent text-gray-500 justify-center items-center" @click="toggle" aria-haspopup="true" outlined aria-controls="overlay_menu" >
                            <span class="pi pi-sign-in"></span>
                        </Button>
                        <Menu  ref="menu" id="overlay_menu" :model="menus" :popup="true" />
                    </div>
                </div>
            </template>
        </Menubar>

    </div>
</template>
