<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Pagination from '@/Components/Pagination.vue';
    import moment from "moment";
    import DrawerSide from '../Components/DashboardDrawerSide.vue';

    defineProps({
        route_name: String,
        blogs: Object,
    });

    components: {
        DrawerSide
    }
</script>

<script>
    export default {
        methods: {
            deleteBlog(blogId) {
                swal({
                    text: "This blog will be deleted permanently. Please proceed with caution !",
                    icon: "warning",
                    buttons: "Yes, I Understand.",
                }).then((value) => {
                    if(value) {
                        let responseMsg;
                        axios.delete('/dashboard/blogs/'+blogId).then((response) => {
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
            },
        },
    }
</script>

<template>
    <Head title="My Blogs" />
    <div id="sidebar" class="bg-white dark:bg-gray-900">
        <div class="drawer drawer-mobile">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col p-10">
                <div class="flex lg:justify-start justify-end">
                    <Link :href="'/dashboard/blogs/create'" v-if="route_name == 'blogs.index'" class="btn btn-accent ml-2 border-none bg-teal-50 hover:bg-teal-50 text-teal-500 rounded-full text-2xl dark:bg-gray-800 dark:hover:bg-gray-700">
                        <i class="bi bi-plus-lg"></i>
                    </Link>
                    <label for="my-drawer-2" :class="route_name == 'dashboard' ? 'ml-auto' : ''" class="btn btn-accent ml-2 border-none dark:bg-transparent dark:hover:bg-transparent bg-teal-50 text-teal-500 hover:bg-teal-50 rounded-full drawer-button text-2xl lg:hidden">
                        <i class="bi bi-list"></i>
                    </label>
                </div>
                
                <!-- Page content here -->
                <div v-for="(blog, index) in blogs.data" class="w-auto my-5 px-8 py-4 rounded-lg shadow-md bg-white dark:bg-slate-800" style="cursor: auto;">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-light text-gray-600 dark:text-white">{{ moment(blog.created_at).format("Mo DD, YYYY") }}</span> 
                        <Link :href="'/blogs/?category='+blog.category.slug" class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-200 transform bg-teal-500 rounded cursor-pointer hover:bg-teal-600">{{ blog.category.name }}</Link>
                    </div> 
                    <div class="mt-2">
                        <Link class="text-2xl font-bold text-teal-900 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-500">{{ blog.title }}</Link> 
                        <p class="mt-2 text-gray-500 dark:text-gray-400" v-html="blog.excerpt"></p>
                    </div> 
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center w-">
                            <Link :href="'/blog/'+blog.slug" class="btn btn-accent btn-outline mr-3">Read more</Link>
                            <Link :href="'/dashboard/blogs/'+blog.id+'/edit'" class="group btn btn-warning btn-outline mr-3"><i class="bi bi-pen group-hover:text-white"></i></Link>
                            <button @click="deleteBlog(blog.id)" class="group btn btn-error btn-outline mr-3"><i class="bi bi-trash3 group-hover:text-white"></i></button>
                        </div>
                    </div>
                </div>
            
                <p v-if="blogs.data.length == 0" class="text-teal-500 my-10 font-bold">No blogs found.</p>
                
                <div class="absolute bottom-10">
                    <Pagination :links="blogs.links" />
                </div>
            </div>
            <DrawerSide :route_name="route_name"></DrawerSide>
        </div>
    </div>
</template>