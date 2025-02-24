
<template>
    <Head title="Dashboard" />    
 
    <div className="max-w-6xl mx-auto bg-white rounded-lg shadow-lg border">
        <div className="relative">
            <div className="h-32 md:h-40 bg-gradient-to-r from-white to-teal-600 rounded-t-lg"></div>
            <div className="absolute inset-x-0 -bottom-10 flex justify-center">
                <img
                    :src="user.profile_photo_url"
                    alt="Profile"
                    className="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-white shadow-lg"
                />
                
                <div className="absolute bottom-1 right-1 bg-gray-200 p-1 rounded-full shadow-md cursor-pointer">
                    📷
                </div>
            </div>
        </div>
        
        <div className="pt-12 pb-6 text-center">
            <h2 className="text-lg font-semibold">{{user.name}}</h2>
            <p className="text-gray-500">{{user.email}}</p>
        </div>
        
        <div className="flex justify-center space-x-6 text-gray-500 text-sm border-t py-3">
            <Link :href="route('profile.show')" className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>👤</span>
                <span>Mon Profile</span>
            </Link>
            <!-- <div className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>👥</span>
                <span>Teams</span>
            </div> -->
            <Link :href="route('curriculum.index')" className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>📂</span>
                <span>Mon CV</span>
            </Link>
            <div className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>🔗</span>
                <span>Connections</span>
            </div>
        </div>

        <div className="text-right p-4">
            <button className="px-4 py-1 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg shadow hover:bg-gray-200">
                Edit
            </button>
        </div>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    user: Object,
    errors: Object,
});
</script>
