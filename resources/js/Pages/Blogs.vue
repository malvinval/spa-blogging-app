<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    defineProps({
        blogs: Object
    });
</script>

<script>
    export default {
        data() {
            return {
                isFirstBlogData: false
            }
        },
        methods: {
            toggleFirstBlogData() {
                this.isFirstBlogData = !this.isFirstBlogData;
            }
        },
    }
</script>

<template>
    <Head title="Blogs" />

    <BreezeAuthenticatedLayout>
        <div class="font-serif mx-auto max-w-7xl flex flex-wrap justify-evenly">
            <div v-for="blog in blogs" class="m-5 card" :class="{ 'w-full': isFirstBlogData, 'w-96': !isFirstBlogData }">
                <figure><img src="https://placeimg.com/400/225/arch" alt="Shoes" /></figure>
                
                <div class="card-body border">
                    <span class="font-sans indicator-item badge badge-primary">new</span> 
                    <h2 class="text-black card-title">
                    {{ blog.title }}
                    </h2>
                    <p class="text-gray-500">by {{ blog.author.name }}</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline text-gray-700">{{ blog.category.name }}</div> 
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>