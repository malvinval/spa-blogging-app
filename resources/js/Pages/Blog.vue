<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import moment from "moment";

    defineProps({
        blogObj: Object,
        previous: Object,
        next: Object,
    });
</script>

<script>
    export default {
        data() {
            return {
                moment: moment,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                likes: this.getLike(),
                liked: false,
            }
        },

        methods: {
            like() {
                axios.post('/like-blog/'+this.blogObj[0].id)
                    .then(this.getLike());
            },

            getLike() {
                axios.post('/get-like/'+this.blogObj[0].id)
                .then((response)=>{
                    this.likes = response.data.likes;
                    this.liked = response.data.liked;
                })
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
                    <div class="flex items-center text-xl justify-between">
                        <p class="text-sm md:text-base font-normal text-gray-600">Published {{ moment(blog.created_at).format("Mo DD, YYYY") }}</p>
                        <div class="flex">
                            <div class="flex views-btn-container mr-5">
                                <i class="bi bi-eye-fill mr-2"></i>
                                <p class="text-slate-800">{{ blog.reads }}</p>
                            </div>
                            <div class="flex like-btn-container">
                                <i @click="like()" class="cursor-pointer bi-suit-heart-fill bi mr-2" :class="liked ? 'text-secondary' : '' "></i>
                                <p class="text-slate-800">{{ likes }}</p>
                            </div>
                        </div>  
                    </div>
                </div>

                <!--Post Content-->

                <!--Body-->
                <p class="py-6">
                    {{ blog.body }}
                </p>
            </div>

            <!--Category -->
            <div class="text-base flex justify-between md:text-sm text-gray-500 px-4 py-6">
                <span>
                    Category: <Link class="text-base md:text-sm text-teal-500 no-underline hover:underline">{{ blog.category.name }}</Link>
                </span>
                <!-- Create Like Button here later ! -->
                
            </div>

            <!--Divider-->
            <hr class="border-b-2 border-gray-400 mb-8 mx-4">

            <!-- Related Blog -->

            <blockquote class="border-l-4 border-teal-500 bg-slate-200 mx-5 my-8 pl-8 md:pl-12 py-2">
                Related blog : <Link :href="route('blogs')" class="text-teal-600 hover:underline">Building Single Page Apps using Laravel Breeze</Link>
            </blockquote>

            <!-- /Related Blog -->

            <!-- Tags -->
                <div class="text-base md:text-sm text-gray-500 px-4 py-6">
                    Tags : <Link class="btn btn-xs bg-teal-500 border-none text-white hover:bg-teal-600">java</Link>
                </div>
            <!-- /Tags -->

            <!-- Comment -->
            <div class="collapse">
                <input type="checkbox" />
                <div class="collapse-title text-xl font-medium">
                    <p><i class="text-warning bi bi-exclamation-triangle-fill stroke-current flex-shrink-0 h-6 w-6"></i> <span class="text-teal-900 text-base underline">We provide rules for commenting</span></p>
                </div>
                <div class="collapse-content">
                    <Transition class="alert alert-warning shadow-lg">
                        <div>
                            <span class="text-gray-600">Please do not share comments that are degrading, discriminatory, or insulting to gender, sexual orientation, disability, ethnicity, religion, threats of violence, sexual harassment, and any form of harassment.</span>
                        </div>
                    </Transition>
                </div>
            </div>

            <div class="rounded-[12px] mx-5 mb-10">
                <textarea class="bg-transparent h-40 px-3 text-sm py-1 mt-5 outline-none border-gray-200 w-full resize-none border rounded-lg placeholder:text-sm" placeholder="Comment here.."></textarea>  
                
                <div class="mt-2">
                    <button class="h-12 w-[150px] btn bg-indigo-600 hover:bg-indigo-700 border-none text-sm text-white rounded-lg transition-all cursor-pointer">Submit</button>
                </div>   
            </div>
            <!-- /Comment -->

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
                            <h3 class="font-bold text-gray-900">About the author</h3>
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