
<template>
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
          <thead>
            <tr>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Nom</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Email</th>
              <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Avatar</th>
              <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
            <tr v-for="user in users.data" :key="user.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{user.name}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{user.email}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                <img :src="user.profile_photo_url" alt="Profile" class="w-10 h-10 object-cover  bg-gray-200" />
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                <div class="flex items-center justify-end space-x-2 p-2 ">
                    <Link :href="route('users.show', user.id)" class="text-[#2b8d96] hover:text-[#1a646b]" >📂</Link>
                    <button class="text-red-500 hover:text-red-700" @click="deleteUser(user.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</template>

<script setup>
import { confirmDelete } from '@/Utils/useConfirm';
import { showToast } from '@/Utils/useToast';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: Boolean,
    users: Object,
    errors: Object,
});


const deleteUser = async (id) => {
    if (!await confirmDelete()) return;
    router.delete(route('users.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
        showToast("success", "Supprimer avec succès !");
        },
    })

}

</script>
