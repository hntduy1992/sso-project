<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const page = usePage();
const notifications = ref([]); // Chuyển thành mảng để chứa nhiều thông báo

// Hàm tạo ID ngẫu nhiên để làm key cho v-for
const generateId = () => Math.random().toString(36).substr(2, 9);

const removeNotification = (id) => {
    notifications.value = notifications.value.filter(n => n.id !== id);
};

watch(() => page.props.flash, (flash) => {
    // Kiểm tra xem flash có nội dung thực sự không
    if (flash && flash.message) {
        const id = generateId();

        // Thêm thông báo mới vào đầu mảng
        notifications.value.unshift({
            id,
            message: flash.message,
            type: flash.type || 'success'
        });

        // Tự động xóa sau 3 giây
        setTimeout(() => {
            removeNotification(id);
        }, 3000);
    }
}, { deep: true });
</script>

<template>
    <div class="fixed top-5 right-5 z-[100] max-w-sm w-full space-y-3 pointer-events-none">
        <TransitionGroup
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-for="notification in notifications" :key="notification.id"
                 class="bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden border-l-4"
                 :class="notification.type === 'success' ? 'border-green-400' : 'border-red-400'">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg v-if="notification.type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <svg v-else class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">Thông báo</p>
                            <p class="mt-1 text-sm text-gray-500">{{ notification.message }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="removeNotification(notification.id)" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>
