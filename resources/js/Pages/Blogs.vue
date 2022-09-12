<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import moment from "moment";
    import 'bootstrap-icons/font/bootstrap-icons.css';
    import Pagination from '@/Components/Pagination.vue'

    defineProps({
        blogs: Object,
        categories: Object,
    });
</script>

<script>
    export default {
        data() {
            return {
                moment: moment,
                searchValue: '',
                blogsDataSize: this.blogs.data.length,
            }
        },

        components: {
            Pagination
        },
    } 
</script>

<template>
    <Head title="Blogs" />

    <BreezeAuthenticatedLayout>
        <div v-if="blogsDataSize > 0" class="mt-10 mx-auto max-w-7xl flex justify-end items-center">
            <div class="dropdown">
                <label tabindex="0" class="btn border-none text-white hover:bg-accent-focus bg-accent m-1">
                    <span class="text-base"><i class="bi bi-ui-radios"></i></span>
                </label>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li v-for="category in categories">
                        <Link :href="'/blogs?category='+category.slug">{{ category.name }}</Link>
                    </li>
                </ul>
            </div>
            <div class="filter-container mr-5 ml-1">
                <div class="form-control">
                    <div :class="searchValue == '' ? '' : 'input-group'">
                        <input v-model="searchValue" type="text" placeholder="Search a title..." class="text-gray-600 input input-bordered border-accent bg-transparent dark:text-white" autocomplete="off"/>
                        <Link v-if="searchValue !== ''" :href="'/blogs?search='+searchValue" class="btn btn-square border-none hover:bg-accent-focus bg-accent">
                            <i class="bi bi-search text-white"></i>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl flex flex-wrap justify-evenly">
            <div v-for="(blog, index) in blogs.data" :key="blog.id" :class="index === 0 ? 'my-10' : 'mb-10'" class="w-full mx-5 px-8 py-4 rounded-lg shadow-md bg-white dark:bg-slate-800" style="cursor: auto;">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-light text-gray-600 dark:text-white">{{ moment(blog.created_at).format("Mo DD, YYYY") }}</span> 
                    <Link :href="'/blogs/?category='+blog.category.slug" class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-200 transform bg-teal-500 rounded cursor-pointer hover:bg-teal-600">{{ blog.category.name }}</Link>
                </div> 
                <div class="mt-2">
                    <Link class="text-2xl font-bold text-teal-900 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-500">{{ blog.title }}</Link> 
                    <p class="mt-2 text-gray-500 dark:text-gray-400" v-html="blog.excerpt"></p>
                </div> 
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <Link :href="'/blog/'+blog.slug" class="btn btn-accent btn-outline mr-3 hover:text-white">Read more</Link>
                    </div>

                    <div class="flex items-center">
                        <img src="https://picsum.photos/200" alt="Author Photo" class="hidden object-cover w-10 h-10 mx-4 rounded-full sm:block"> 
                        <Link class="font-bold text-right cursor-pointer text-slate-600 dark:text-slate-300">{{ blog.author.name }}</Link>
                    </div>
                </div>
            </div>

            <p v-if="blogsDataSize == 0" class="text-teal-500 my-10 font-bold">No blogs found.</p>
            
            <div class="mx-auto my-10">
                <Pagination :links="blogs.links" />
            </div>
        </div>



    </BreezeAuthenticatedLayout>
</template>