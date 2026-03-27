<script setup>

import UserTable from "./UserTable.vue";
import BaseDrawer from "../../Components/BaseDrawer.vue";
import {computed, ref} from "vue";
import UserForm from "./UserForm.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();
const users = computed(() => page.props.users);
const isDrawerOpen = ref(false);
const User = ref(null);

const handleCreateOrUpdate = (data) => {
    if (data) {
        User.value = data
    } else {
        User.value = null
    }
    isDrawerOpen.value = true
}
const handleFormCancel = () => {
    isDrawerOpen.value = false
}
</script>

<template>
    <UserTable @OnCreateOrUpdate="handleCreateOrUpdate" :users="users"/>
    <BaseDrawer :isOpen="isDrawerOpen"
                :title="User ? 'Sửa người dùng' : 'Thêm người dùng'"
                @close="isDrawerOpen = false">
        <UserForm v-model="User" @Cancel="handleFormCancel"/>
    </BaseDrawer>
</template>

<style scoped>

</style>
