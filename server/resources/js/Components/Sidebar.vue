<template>
    <div :class="[isCollapsed ? 'w-20' : 'w-64']"
         class="bg-slate-900 h-screen transition-all duration-300 flex flex-col shadow-xl">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <svg class="h-8 w-8 text-indigo-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                <path strokeLinecap="round" strokeLinejoin="round"
                      d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33"/>
            </svg>
            <span v-if="!isCollapsed" class="ml-3 text-white font-bold text-xl tracking-tight">
                <slot name="title"/>
            </span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
            <div v-for="item in navigation" :key="item.name">
                <div v-if="!item.children" @click="router.visit(item.href)"
                     class="flex items-center px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all group">
                    <component :is="item.icon" class="h-6 w-6 shrink-0 group-hover:text-indigo-400"/>
                    <span v-if="!isCollapsed" class="ml-3 font-medium">{{ item.name }}</span>
                </div>

                <div v-else>
                    <button @click="item.isOpen = !item.isOpen"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-all">
                        <div class="flex items-center">
                            <component :is="item.icon" class="h-6 w-6 shrink-0"/>
                            <span v-if="!isCollapsed" class="ml-3 font-medium">{{ item.name }}</span>
                        </div>
                        <ChevronDownIcon v-if="!isCollapsed"
                                         :class="[item.isOpen ? 'rotate-180' : '', 'h-4 w-4 transition-transform duration-200']"/>
                    </button>

                    <div v-show="item.isOpen && !isCollapsed"
                         class="mt-1 ml-4 border-l border-slate-700 pl-4 space-y-1">
                        <div v-for="sub in item.children" :key="sub.name" @click="router.visit(sub.href)"
                             class="block px-3 py-2 text-sm text-slate-400 hover:text-indigo-400 transition-colors">
                            {{ sub.name }}
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import {
    HomeIcon,
    ChevronDownIcon,
    UserGroupIcon, BuildingLibraryIcon
} from '@heroicons/vue/24/outline'
import {Link, router} from "@inertiajs/vue3";
import {route} from "ziggy-js";

defineProps(['isCollapsed'])

const navigation = ref([
    {name: 'Dashboard', href: route('dashboard.index'), icon: HomeIcon},
    {
        name: 'Users',
        icon: UserGroupIcon,
        isOpen: true,
        children: [
            {name: 'Danh sách', href: route('users.index')},
            // { name: 'Bị khóa', href: '/users/blocked' },
        ]
    },
    {
        name: 'Departments',
        icon: BuildingLibraryIcon,
        isOpen: true,
        children: [
            {name: 'Danh sách', href: route('departments.index')},
        ]
    }
])
</script>
