<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import moment from "moment";

    defineProps({
        blogObj: Object,
        previous: Object,
        next: Object
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
    <Head title="Blog" />

    <BreezeAuthenticatedLayout>
        <div v-for="blog in blogObj" class="container w-full max-w-7xl mx-auto pt-20">

            <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">

                <!--Title-->
                <div class="font-sans">
                    <p class="text-base md:text-sm text-teal-500 font-bold"><Link :href="route('blogs')" class="text-base md:text-sm text-teal-500 font-bold no-underline hover:underline">BACK TO BLOGS</Link></p>
                    <h1 class="font-bold break-normal text-teal-900 pt-6 pb-2 text-3xl md:text-4xl">{{ blog.title }}</h1>
                    <p class="text-sm md:text-base font-normal text-gray-600">Published {{ moment(blog.created_at).format("Mo DD, YYYY") }}</p>
                </div>

                <!--Post Content-->

                <!--Body-->
                <p class="py-6">
                    {{ blog.body }}
                </p>
            </div>

            <!--Tags -->
            <div class="text-base md:text-sm text-gray-500 px-4 py-6">
                Category: <Link class="text-base md:text-sm text-teal-500 no-underline hover:underline">{{ blog.category.name }}</Link>
            </div>

            <!--Divider-->
            <hr class="border-b-2 border-gray-400 mb-8 mx-4">


            <!--Donate-->
            <div class="container px-4">
                <div class="bg-gradient-to-b from-teal-100 to-gray-100 rounded-lg shadow-xl p-4 text-center">
                    <h2 class="font-bold break-normal text-xl md:text-3xl text-teal-800">Show your <span class="text-rose-600">&hearts;</span> for this author !</h2>
                    <h3 class="font-bold break-normal text-gray-400 text-sm md:text-base">Please ensure that you do this without any coercion.</h3>
                    <div class="w-full text-center pt-4">                       
                        <div class="max-w-xl mx-auto p-1 pr-0 flex flex-wrap items-center">
                            <input type="email" placeholder="youremail@example.com" class="flex-1 mt-4 appearance-none border border-gray-400 rounded shadow-md p-3 text-gray-600 mr-2 focus:outline-none">
                            <Link class="flex-1 mt-4 block md:inline-block appearance-none bg-teal-500 text-white text-base font-semibold tracking-wider uppercase py-4 rounded shadow hover:bg-teal-400">Saweria.co</Link>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Donate-->

            <!--Author-->
            <div class="flex w-full items-center font-sans px-4 py-12">
                <img class="w-10 h-10 rounded-full mr-4" src="http://i.pravatar.cc/300" alt="Avatar of Author">
                <div class="flex-1 px-2">
                    <p class="font-bold text-base md:text-xl leading-none mb-2">{{ blog.author.name }}</p>
                    <p class="text-gray-600 text-xs md:text-base">Fullstack Web Developer</p>
                </div>
                <div class="justify-end">
                    <button class="bg-transparent border border-gray-500 hover:border-teal-500 text-xs text-gray-500 hover:text-teal-500 font-bold py-2 px-4 rounded-full">See More</button>
                </div>
            </div>
            <!--/Author-->

            <!--Divider-->
            <hr class="border-b-2 border-gray-400 mb-8 mx-4">

            <!--Next & Prev Links-->
            <div class="font-sans flex justify-between content-center px-4 pb-12">
                <div class="text-left">
                    <Link v-if="previous != NULL" :href="'/blog/'+previous.slug" class="font-bold text-secondary">&lt; Previous Blog</Link>
                </div>
                <div class="text-right">
                    <Link v-if="next != NULL" :href="'/blog/'+next.slug" class="font-bold text-accent">Next Blog &gt;</Link>
                </div>
            </div>

	    </div>
        <footer class="bg-white border-t border-gray-400 shadow">
            <div class="container max-w-4xl mx-auto flex py-8">

                <div class="w-full mx-auto flex flex-wrap">
                    <div class="flex w-full md:w-1/2 ">
                        <div class="px-8">
                            <h3 class="font-bold text-gray-900">About</h3>
                            <p class="py-4 text-gray-600 text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel mi ut felis tempus commodo nec id erat. Suspendisse consectetur dapibus velit ut lacinia.
                            </p>
                        </div>
                    </div>

                    <div class="flex w-full md:w-1/2">
                        <div class="px-8">
                            <h3 class="font-bold text-gray-900">Social</h3>
                            <ul class="list-reset items-center text-sm pt-3">
                                <li>
                                    <a class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:text-underline py-1" href="#">Github</a>
                                </li>
                                <li>
                                    <a class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:text-underline py-1" href="#">VK</a>
                                </li>
                                <li>
                                    <a class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:text-underline py-1" href="#">Facebook</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </BreezeAuthenticatedLayout>
</template>

<style>
    * {
        font-family: 'Quicksand', sans-serif;
    }
</style>