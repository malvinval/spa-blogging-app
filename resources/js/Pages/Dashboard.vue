<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Pagination from '@/Components/Pagination.vue';
    import moment from "moment";

    defineProps({
        route_name: String,
        blogs: Object,
    })
</script>

<script>
    export default {
        data() {
            return {
                moment: moment,
            }
        },
        methods: {
            deleteBlog() {
                swal({
                    text: "This blog will be deleted permanently. Please proceed with caution !",
                    icon: "warning",
                    buttons: "Yes, I Understand.",
            }).then((value) => {
                if(value) {
                    let responseMsg;
        
                    axios.delete('/dashboard/blogs/'+this.blogs.data[0].id).then((response) => {
                        responseMsg = response.data.success;
                        swal({
                            text: responseMsg,
                            icon: "success",
                            timer: 3000,
                            buttons: false
                        });
                    })
                }
            });
                
            }
        },
        components: {
            Pagination
        },
    }
</script>

<template>
    <Head title="Dashboard" />
    <div id="sidebar" class="bg-white">
        <div class="drawer drawer-mobile">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col p-10">
                <div class="flex justify-end">
                    <button v-if="route_name == 'blogs.index'" class="btn btn-accent ml-2 border-none bg-teal-50 hover:bg-teal-50 text-teal-500 rounded-full text-2xl">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <label for="my-drawer-2" :class="route_name == 'dashboard' ? 'ml-auto' : ''" class="btn btn-accent ml-2 border-none bg-teal-50 text-teal-500 hover:bg-teal-50 rounded-full drawer-button text-2xl lg:hidden">
                        <i class="bi bi-list"></i>
                    </label>
                </div>
                
                <!-- Page content here -->

                <!-- Profile -->
                <div v-if="route_name == 'dashboard'">
                    {{ route_name }}
                </div>

                <!-- Dashboard Blogs -->
                <div v-else-if="route_name == 'blogs.index'">
                    <div v-for="(blog, index) in blogs.data" :key="blog.id" class="w-auto my-5 px-8 py-4 rounded-lg shadow-md bg-white" style="cursor: auto;">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-light text-gray-600">{{ moment(blog.created_at).format("Mo DD, YYYY") }}</span> 
                            <Link :href="'/blogs/?category='+blog.category.slug" class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-200 transform bg-teal-500 rounded cursor-pointer hover:bg-teal-600">{{ blog.category.name }}</Link>
                        </div> 
                        <div class="mt-2">
                            <Link class="text-2xl font-bold text-teal-900 hover:text-teal-800">{{ blog.title }}</Link> 
                            <p class="mt-2 text-gray-500">{{ blog.excerpt }}</p>
                        </div> 
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center w-">
                                <Link :href="'/blog/'+blog.slug" class="btn btn-accent btn-outline mr-3">Read more</Link>
                                <Link class="group btn btn-warning btn-outline mr-3"><i class="bi bi-pen group-hover:text-white"></i></Link>
                                <button @click="deleteBlog()" class="group btn btn-error btn-outline mr-3"><i class="bi bi-trash3 group-hover:text-white"></i></button>
                            </div>
                        </div>
                    </div>

                    <p v-if="blogs.data.length == 0" class="text-teal-500 my-10 font-bold">No blogs found.</p>
                    
                    <div class="mx-auto my-10">
                        <Pagination :links="blogs.links" />
                    </div>
                </div>
            </div>
            <div class="drawer-side">
                <label for="my-drawer-2" class="drawer-overlay"></label>
                <div class="h-full bg-white sidebar-container border border-r-slate-200 w-80 flex items-center">
                    <ul class="text-black menu p-4 overflow-y-auto w-80 h-auto">
                        <!-- Sidebar content here -->
                        <!-- <li class="">
                            <p class="text-sm text-slate-500">User menu</p>
                        </li> -->
                        <li class="sidebar-navigator">
                            <Link :href="'/blogs'" class="focus:bg-teal-500 focus:text-white hover:bg-teal-500 hover:text-white">
                                <div class="sidebar-icon-container px-3">
                                    <i class="bi bi-house-door-fill"></i>
                                </div>
                                <div>
                                    <p class="text-opacity-40">Back to blogs</p>
                                </div>  
                            </Link>
                        </li>
                        <li class="sidebar-navigator">
                            <Link :href="'/dashboard'" :class="route_name == 'dashboard' ? 'bg-teal-500 text-white' : ''" class="focus:bg-teal-500 focus:text-white hover:bg-teal-500 hover:text-white active:bg-teal-500 active:text-white">  
                                <div class="sidebar-icon-container px-3">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div>
                                    <p>Profile</p>
                                </div>            
                            </Link>
                        </li>
                        <li class="sidebar-navigator">
                            <Link :href="'/dashboard/blogs'" :class="route_name == 'blogs.index' ? 'bg-teal-500 text-white' : ''" class="focus:bg-teal-500 focus:text-white hover:bg-teal-500 hover:text-white active:bg-teal-500 active:text-white">  
                                <div class="sidebar-icon-container px-3">
                                    <i class="bi bi-book-half active:text-teal-500"></i>
                                </div>
                                <div>
                                    <p>My blogs</p>
                                </div>            
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .sidebar-navigator {
        margin-bottom: 0.5rem;
    }
</style>