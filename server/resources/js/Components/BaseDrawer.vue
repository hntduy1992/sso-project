<script setup>

defineProps({
    isOpen: Boolean,
    title: String
});
</script>
<template>
    <div class="relative z-50">
        <transition name="fade">
            <div
                v-show="isOpen"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm shadow-inner"
                @click="$emit('close')"
            ></div>
        </transition>

        <transition name="slide">
            <div
                v-show="isOpen"
                class="fixed inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col border-l border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800">{{ title }}</h2>
                    <button @click="$emit('close')"
                            class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                    <slot></slot>
                </div>

                <div class="p-6 border-t border-gray-100 flex gap-3 bg-white">
                    <button @click="$emit('confirm')"
                            class="flex-1 bg-[#243c5a] hover:bg-[#1a2e45] text-white py-2.5 rounded-lg font-bold transition-all transform active:scale-[0.98]">
                        Xác nhận
                    </button>
                    <button @click="$emit('close')"
                            class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-lg font-medium hover:bg-gray-200 transition-all">
                        Hủy
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
/* Hiệu ứng Fade cho Overlay */
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* Hiệu ứng Slide cực mượt cho Panel */
.slide-enter-active, .slide-leave-active {
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1); /* Cubic-bezier giúp trượt tự nhiên hơn */
}

.slide-enter-from, .slide-leave-to {
    transform: translateX(100%);
}

/* Tùy chỉnh thanh cuộn cho đẹp */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
</style>
