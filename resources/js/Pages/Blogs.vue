<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import moment from "moment";

    defineProps({
        blogs: Object
    });
</script>

<script>
    export default {
        data() {
            return {
                moment: moment
            }
        },
    }
</script>

<template>
    <Head title="Blogs" />

    <BreezeAuthenticatedLayout>
        <div class="mx-auto max-w-7xl flex flex-wrap justify-evenly">
            
            <div v-for="(blog, index) in blogs" :class="index === 0 ? 'my-10' : 'mb-10'" class="w-full mx-5 px-8 py-4 rounded-lg shadow-md bg-white" style="cursor: auto;">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-light text-gray-600">{{ moment(blog.created_at).format("Mo DD, YYYY") }}</span> 
                    <a class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-200 transform bg-teal-600 rounded cursor-pointer hover:bg-gray-500">{{ blog.category.name }}</a>
                </div> 
                <div class="mt-2">
                    <Link class="text-2xl font-bold text-sky-900 hover:text-sky-800">{{ blog.title }}</Link> 
                    <p class="mt-2 text-gray-500">{{ blog.body }}</p>
                </div> 
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center w-">
                        <Link :href="route('home')" class="btn btn-primary btn-outline mr-3">Read more</Link>
                    </div>

                    <div class="flex items-center">
                        <img src="https://picsum.photos/200" alt="Author Photo" class="hidden object-cover w-10 h-10 mx-4 rounded-full sm:block"> 
                        <a class="font-bold cursor-pointer text-slate-600">{{ blog.author.name }}</a>
                    </div>
                </div>
            </div>
            
        </div>
    </BreezeAuthenticatedLayout>
</template>