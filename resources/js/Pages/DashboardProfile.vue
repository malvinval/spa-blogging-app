<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import DrawerSide from '../Components/DashboardDrawerSide.vue';
    defineProps({
        user_name: String,
        route_name: String,
    });
</script>

<template>
    <Head title="Profile" />
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
                <section class="pt-16">
                    <div class="w-full px-4 mx-auto">
                    <div class="relative flex flex-col min-w-0 break-words bg-white dark:bg-gray-800 w-full mb-6 shadow-xl rounded-lg mt-16">
                        <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full px-4 flex justify-center">
                            <div class="relative">
                                <img alt="..." src="../../../public/img/man.jpg" class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px">
                            </div>
                            </div>
                        </div>
                        <div class="text-center mt-32">
                            <h3 class="text-xl font-semibold leading-normal mb-2">
                            {{ user_name }}
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 font-bold uppercase">
                            <i class="fas fa-map-marker-alt mr-2 text-lg"></i>
                            Los Angeles, California
                            </div>
                            <div class="mb-2 mt-5">
                                <i class="fas fa-briefcase mr-2 text-lg"></i>
                                Fullstack Web Developer - Cyber Security Researcher
                            </div>
                        </div>
                        <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                            <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-9/12 px-4">
                                <p class="mb-10 text-lg leading-relaxed">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugit quaerat esse, sapiente illum culpa quis asperiores, quod similique voluptatibus ipsa, expedita error ratione! Nam commodi aperiam fugit aspernatur, maiores repudiandae!
                                </p>
                                <Link class="group btn btn-warning btn-outline mr-3"><i class="bi bi-pen group-hover:text-white"></i></Link>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </section>
            </div>                 
            <DrawerSide :route_name="route_name"></DrawerSide>
        </div>
    </div>
</template>