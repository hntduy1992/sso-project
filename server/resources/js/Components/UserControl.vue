<template>
    <div class="relative" ref="userMenuRef">
        <button
            @click="isUserMenuOpen = !isUserMenuOpen"
            class="flex items-center group focus:outline-none"
        >
            <div class="relative">
                <img
                    class="h-9 w-9 rounded-full object-cover border-2 border-transparent group-hover:border-indigo-500 transition-all shadow-sm"
                    :src="`storage/systems/images/user-avatar.png`"
                    alt="User"
                >
                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-white"></span>
            </div>

            <div class="ml-3 text-left hidden md:block">
                <p class="text-sm font-semibold text-gray-700 group-hover:text-indigo-600 transition-colors leading-none">Alex Dan</p>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider mt-1">Quản trị viên</p>
            </div>

            <ChevronDownIcon
                :class="[isUserMenuOpen ? 'rotate-180' : '', 'ml-2 h-4 w-4 text-gray-400 transition-transform duration-200']"
            />
        </button>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-show="isUserMenuOpen"
                class="absolute right-0 mt-3 w-56 origin-top-right divide-y divide-gray-100 rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
            >

                <div class="py-1">
                    <a href="#" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <UserIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" />
                        Hồ sơ của bạn
                    </a>
                    <a href="#" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <Cog6ToothIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" />
                        Cài đặt tài khoản
                    </a>
                    <a href="#" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <CreditCardIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" />
                        Thanh toán
                    </a>
                </div>

                <div class="py-1">
                    <a href="#" class="group flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <ArrowRightOnRectangleIcon class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" />
                        Đăng xuất
                    </a>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import {
    ChevronDownIcon,
    UserIcon,
    Cog6ToothIcon,
    CreditCardIcon,
    ArrowRightOnRectangleIcon
} from '@heroicons/vue/24/outline'

const isUserMenuOpen = ref(false)
const userMenuRef = ref(null)

const handleClickOutside = (event) => {
    if (userMenuRef.value && !userMenuRef.value.contains(event.target)) {
        isUserMenuOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside)
})
</script>
