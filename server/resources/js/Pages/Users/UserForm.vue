<template>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input v-model="localData.username" type="text" class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
            <select v-model="localData.status" class="w-full mt-1 px-3 py-2 border rounded-lg">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: Object // Dữ liệu từ trang cha truyền vào
});

const localData = ref({ ...props.modelValue });

// Cập nhật lại localData khi modelValue thay đổi (khi bấm sửa user khác)
watch(() => props.modelValue, (newVal) => {
    localData.value = { ...newVal };
}, { deep: true });

// Hàm để trang cha gọi lấy dữ liệu cuối cùng
const getData = () => localData.value;

// Xuất hàm ra ngoài để trang cha có thể truy cập qua ref
defineExpose({ getData });
</script>
