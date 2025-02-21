
<template>
    <Head title="Dashboard" />
    
 
    <div className="max-w-4xl mx-auto mt-10 bg-white rounded-lg shadow-lg border">
        {/* Cover Photo */}
        <div className="relative">
            <div className="h-32 md:h-40 bg-gradient-to-r from-gray-200 to-blue-300 rounded-t-lg"></div>
            {/* Profile Picture */}
            <div className="absolute inset-x-0 -bottom-10 flex justify-center">
                <img
                    src="https://via.placeholder.com/100"
                    alt="Profile"
                    className="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-white shadow-lg"
                />
                {/* Camera Icon */}
                <div className="absolute bottom-1 right-1 bg-gray-200 p-1 rounded-full shadow-md cursor-pointer">
                    📷
                </div>
            </div>
        </div>

        {/* Profile Info */}
        <div className="pt-12 pb-6 text-center">
            <h2 className="text-lg font-semibold">Amanda Harvey</h2>
            <p className="text-gray-500">@iam_amanda</p>
        </div>

        {/* Navigation Links */}
        <div className="flex justify-center space-x-6 text-gray-500 text-sm border-t py-3">
            <div className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>👤</span>
                <span>My Profile</span>
            </div>
            <div className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>👥</span>
                <span>Teams</span>
            </div>
            <div className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>📂</span>
                <span>Files</span>
            </div>
            <div className="flex items-center space-x-1 cursor-pointer hover:text-gray-700">
                <span>🔗</span>
                <span>Connections</span>
            </div>
        </div>

        {/* Edit Button */}
        <div className="text-right p-4">
            <button className="px-4 py-1 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg shadow hover:bg-gray-200">
                Edit
            </button>
        </div>
    </div>

</template>

<script setup>
</script>
