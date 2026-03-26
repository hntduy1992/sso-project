<template xmlns="http://www.w3.org/1999/html">
    <div class="flex h-screen bg-gray-50 overflow-hidden font-sans antialiased text-slate-900">
        <Sidebar :isCollapsed="isCollapsed">
            <template #title>
                SSO MANAGER
            </template>
        </Sidebar>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <Navbar @toggle="isCollapsed = !isCollapsed"/>

            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                <slot/>
            </main>
        </div>
    </div>
    <ToashNotification/>
</template>

<script setup>
import {onMounted, onUnmounted, ref} from 'vue'
import Navbar from "../Components/Navbar.vue";
import Sidebar from "../Components/Sidebar.vue";
import ToashNotification from "../Components/ToashNotification.vue";


const isCollapsed = ref(false)
const handleResize = () => {

    if (window.innerWidth < 1024) {
        isCollapsed.value = true
    } else {
        isCollapsed.value = false
    }
}
onMounted(() => {
    handleResize() // Kiểm tra ngay khi load trang
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
})
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* Tùy chỉnh thanh cuộn cho Sidebar */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 10px;
}
</style>
