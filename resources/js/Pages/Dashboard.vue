<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProfilCard from '@/Pages/Auth/ProfileCard.vue';
import UserTable from '@/Pages/Admin/UserTable.vue';

const props = defineProps({
    user: Object,
    users: Object,
});


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <ProfilCard :user="user.data" v-if="!user.data.isAdmin" />
                    <div v-else>
                        <UserTable :users="users" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
