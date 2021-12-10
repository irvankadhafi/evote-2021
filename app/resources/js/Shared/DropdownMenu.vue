<template>
    <li class="list-none block ">
        <div class="flex mb-2 cursor-pointer" @click="toggleShow">
            <i :class="iconName+' mr-2 h-4 w-4'"></i>
<!--            <icon name="dashboard" class="w-4 h-4 mr-2" :class="'text-gray-800 group-hover:fill-black'" />-->
            <div :class="'text-gray-800 group-hover:text-gray-500'">{{ title }}</div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" :class="{'rotate-90' : showMenu}" class="dropdown-menu pb-1" viewBox="0 0 24 24">
                <path fill="none" d="M0 0h24v24H0V0z"/><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
            </svg>
        </div>
        <ul class="ml-4 overflow-hidden dropdown-menu font-normal" :class="this.class">
            <slot></slot>
        </ul>
    </li>
</template>

<script>
import Popper from 'popper.js'
import Icon from '@/Shared/Icon'
export default {
    components: {
        Icon
    },
    props: ["title", "height","iconName"],
    data() {
        return {
            showMenu: false
        };
    },

    methods: {
        toggleShow() {
            this.showMenu = !this.showMenu;
        },
    },

    computed: {
        class() {
            return this.showMenu ? this.height : "h-0";
        }
    }
}
</script>
