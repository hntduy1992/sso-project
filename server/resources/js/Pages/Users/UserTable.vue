<template>
    <div class="p-6 bg-gray-50 min-h-screen relative" @click="closeContextMenu">
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Quản lý Tài khoản (Users)</h2>
            </div>

            <button @click="addNewUser"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm transition-all text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                          clip-rule="evenodd"/>
                </svg>
                Thêm người dùng
            </button>
        </div>

        <div class="bg-white p-4 rounded-t-xl border border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4 flex-grow">
                <div class="relative w-full max-w-xs">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          </span>
                    <input v-model="searchQuery" type="text" placeholder="Tìm username..."
                           class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500"/>
                </div>


            </div>

            <div v-if="selectedIds.length > 0" class="flex items-center gap-2 animate-fade-in">
        <span class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
          Đã chọn {{ selectedIds.length }}
        </span>
                <button @click="bulkDelete"
                        class="text-sm text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg font-medium border border-red-200 transition-colors">
                    Xóa hàng loạt
                </button>
            </div>
        </div>

        <div class="bg-white rounded-b-xl shadow-sm border-x border-b border-gray-200 overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4 w-10">
                        <input type="checkbox" :checked="isAllSelected" @change="toggleSelectAll"
                               class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4 shadow-sm"/>
                    </th>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Username</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Department</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in paginatedUsers" :key="user.id"
                    @contextmenu.prevent="openContextMenu($event, user)"
                    :class="[
                'border-b border-gray-100 transition-colors',
                selectedIds.includes(user.id) ? 'bg-blue-50/50' : 'hover:bg-gray-50'
              ]"
                >
                    <td class="px-6 py-4">
                        <input type="checkbox" v-model="selectedIds" :value="user.id"
                               class="rounded text-blue-600 w-4 h-4 shadow-sm"/>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">#{{ user.id }}</td>
                    <td class="px-6 py-4">{{ user.username }}</td>
                    <td class="px-6 py-4">
              <span :class="user.status === 'active' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100'"
                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                {{ user.status }}
              </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ user.department.name || '—' }}</td>
                </tr>
                </tbody>
            </table>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2 animate-fade-in">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>Hiển thị:</span>
                        <select v-model="itemsPerPage"
                                class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option :value="5">5</option>
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                        </select>
                    </div>
                    <span class="text-xs text-gray-500 font-medium uppercase tracking-tight">
          Hiển thị {{ startIndex + 1 }} - {{ endIndex }}  [tổng {{ filteredUsers.length }}]
        </span>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="currentPage--" :disabled="currentPage === 1"
                            class="p-2 border rounded-md bg-white hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <div class="flex gap-1">
                        <button v-for="p in totalPages" :key="p" @click="currentPage = p"
                                :class="currentPage === p ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'"
                                class="w-8 h-8 text-xs font-bold rounded-md border transition-all">
                            {{ p }}
                        </button>
                    </div>
                    <button @click="currentPage++" :disabled="currentPage === totalPages"
                            class="p-2 border rounded-md bg-white hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div v-if="contextMenu.visible" :style="{ top: contextMenu.y + 'px', left: contextMenu.x + 'px' }"
             class="fixed z-50 bg-white border border-gray-200 shadow-2xl rounded-lg w-52 py-2 text-sm text-gray-700 ring-1 ring-black ring-opacity-5">
            <div
                class="px-4 py-2 border-b border-gray-100 font-bold text-gray-400 uppercase text-[10px] tracking-widest">
                Tùy chọn
            </div>
            <button @click="editUser(contextMenu.user)"
                    class="w-full text-left px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 flex items-center gap-3 transition-colors">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Sửa bản ghi
            </button>
            <button @click="deleteUser(contextMenu.user)"
                    class="w-full text-left px-4 py-2.5 hover:bg-red-50 hover:text-red-700 flex items-center gap-3 transition-colors">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Xóa bản ghi
            </button>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, watch} from 'vue';

const emit = defineEmits(['OnCreateOrUpdate']);
const props = defineProps({
    users: Object,
})

// States
const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(5);
const selectedIds = ref([]); // Chứa các ID được chọn

const contextMenu = ref({visible: false, x: 0, y: 0, user: null});

// Reset trang khi đổi itemsPerPage hoặc tìm kiếm
watch([itemsPerPage, searchQuery], () => {
    currentPage.value = 1;
});

// Computed Logic
const filteredUsers = computed(() => {
    return props.users.filter(u => u.username.toLowerCase().includes(searchQuery.value.toLowerCase()));
});

const totalPages = computed(() => Math.ceil(filteredUsers.value.length / itemsPerPage.value));

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value);
const endIndex = computed(() => Math.min(startIndex.value + itemsPerPage.value, filteredUsers.value.length));

const paginatedUsers = computed(() => {
    return filteredUsers.value.slice(startIndex.value, endIndex.value);
});

// Xử lý chọn tất cả (chỉ chọn các dòng đang hiển thị trên trang hiện tại)
const isAllSelected = computed(() => {
    return paginatedUsers.value.length > 0 && paginatedUsers.value.every(u => selectedIds.value.includes(u.id));
});

const toggleSelectAll = () => {
    const currentIds = paginatedUsers.value.map(u => u.id);
    if (isAllSelected.value) {
        selectedIds.value = selectedIds.value.filter(id => !currentIds.includes(id));
    } else {
        selectedIds.value = [...new Set([...selectedIds.value, ...currentIds])];
    }
};

// Handlers
const openContextMenu = (e, user) => {
    contextMenu.value = {visible: true, x: e.clientX, y: e.clientY, user};
};

const closeContextMenu = () => {
    contextMenu.value.visible = false;
};

const addNewUser = () => emit('OnCreateOrUpdate', null);

const editUser = (user) => emit('OnCreateOrUpdate', user);

const deleteUser = (user) => {
    if (confirm(`Xóa ${user.username}?`)) {
        users.value = users.value.filter(u => u.id !== user.id);
        selectedIds.value = selectedIds.value.filter(id => id !== user.id);
    }
};

const bulkDelete = () => {
    if (confirm(`Bạn có chắc chắn muốn xóa ${selectedIds.value.length} người dùng đã chọn?`)) {
        users.value = users.value.filter(u => !selectedIds.value.includes(u.id));
        selectedIds.value = [];
        alert("Đã xóa hàng loạt thành công!");
    }
};
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

table {
    user-select: none;
}
</style>
