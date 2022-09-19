<script setup>
    import { Link } from '@inertiajs/inertia-vue3';

    defineProps({
        route_name: String,
    })
</script>

<template>
    <div class="drawer-side">
        <label for="my-drawer-2" class="drawer-overlay"></label>
        <div class="h-full bg-white sidebar-container border border-r-slate-200 dark:border-none w-80 flex items-center dark:bg-gray-900">
            <ul class="text-black menu p-4 overflow-y-auto w-80 h-auto">
                <!-- Sidebar content here -->
                <li class="sidebar-navigator mb-3">
                    <Link :href="'/blogs'" class="focus:bg-teal-500 focus:text-white hover:bg-teal-500 hover:text-white">
                        <div class="sidebar-icon-container px-3">
                            <i class="bi bi-arrow-left text-teal-600"></i>
                        </div>
                        <div>
                            <p class="text-opacity-40 dark:text-white">Back to blogs</p>
                        </div>  
                    </Link>
                </li>
                <li class="sidebar-navigator mb-3">
                    <Link :href="'/dashboard'" :class="route_name == 'dashboard' ? 'bg-teal-500 text-white' : ''" class="focus:bg-teal-500 focus:text-white hover:bg-teal-500 hover:text-white active:bg-teal-500 active:text-white">  
                        <div class="sidebar-icon-container px-3">
                            <i class="bi bi-person text-teal-600" :class="route_name == 'dashboard' ? 'dark:text-white' : ''"></i>
                        </div>
                        <div>
                            <p class="dark:text-white" :class="route_name == 'dashboard' ? 'dark:text-white' : ''">Profile</p>
                        </div>            
                    </Link>
                </li>
                <li class="sidebar-navigator mb-3">
                    <Link :href="'/dashboard/blogs'"
                        :class="route_name == 'blogs.index' || route_name == 'blogs.edit' || route_name == 'blogs.create' ? 'bg-teal-500 text-white' : ''"
                        class="focus:bg-teal-500 focus:text-white hover:bg-teal-500 hover:text-white active:bg-teal-500 active:text-white">  
                        <div class="sidebar-icon-container px-3 text-teal-500">
                            <i class="bi bi-book-half text-teal-600" :class="route_name == 'blogs.index' ? 'dark:text-white' : ''"></i>
                        </div>
                        <div>
                            <p class="dark:text-white">My blogs</p>
                        </div>            
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>