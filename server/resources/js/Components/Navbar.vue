<template>
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-10">
        <div class="flex items-center flex-1">
            <button @click="$emit('toggle')" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                <Bars3BottomLeftIcon class="h-6 w-6"/>
            </button>

            <div class="ml-4 max-w-md w-full hidden lg:block">
                <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <MagnifyingGlassIcon class="h-5 w-5"/>
          </span>
                    <input type="text"
                           class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 sm:text-sm transition-all"
                           placeholder="Tìm kiếm nhanh...">
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <UserControl></UserControl>
        </div>
    </header>
</template>

<script setup>
import {
    Bars3BottomLeftIcon,
    MagnifyingGlassIcon,

} from '@heroicons/vue/24/outline'
import UserControl from "./UserControl.vue";
</script>
