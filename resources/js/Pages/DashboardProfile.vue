<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import DrawerSide from '../Components/DashboardDrawerSide.vue';
    
    defineProps({
        user: Object,
        route_name: String,
    });
</script>

<script>
    export default {
        data() {
            return {
                profileImageUpdated: ""                
            }
        },

        mounted() {
            let profileImageScript = document.createElement('script');
            profileImageScript.setAttribute('src', '/js/profile-image.js');
            document.head.appendChild(profileImageScript);
        },
        methods: {
            enableApplyButton() {
                $("#apply-image").removeClass("hidden");
            },
        },
    }
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
                <section class="pt-14 lg:pt-28">
                    <div class="w-full px-4 mx-auto">
                    <div class="relative flex flex-col min-w-0 break-words bg-white dark:bg-gray-800 w-full mb-6 shadow-xl rounded-lg mt-16">
                        <div class="px-6">
                            <div class="flex flex-wrap justify-center online">
                                <div class="w-full px-4 flex justify-center">
                                    <div class="relative">
                                        <img alt="..." :src="user.image" class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 max-w-150-px">
                                        <label for="my-modal-3" class="modal-button cursor-pointer top-9 left-11 absolute w-7 h-7 bg-gray-700 border-2 border-white dark:border-gray-800 rounded-full">
                                            <p class="text-center text-yellow-500"><i class="bi bi-arrow-repeat"></i></p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-32">
                                <h3 class="text-xl font-semibold leading-normal mb-2">
                                {{ user.name }}
                                </h3>
                                <div class="text-sm leading-normal mt-0 mb-2 uppercase">
                                    <i class="fas fa-map-marker-alt mr-2 text-lg"></i>
                                    <span v-if="user.country" class="font-bold">{{ user.country }}</span>
                                    <span v-else class="italic">No country data provided</span>
                                </div>
                                <div class="mb-2 mt-5">
                                    <i class="fas fa-briefcase mr-2 text-lg"></i>
                                    <span v-if="user.status">Fullstack Web Developer - Cyber Security Researcher</span>
                                    <span v-else class="italic">No status data provided</span>
                                </div>
                            </div>
                            <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                                <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <p v-if="user.bio" class="mb-10 text-lg leading-relaxed">
                                        {{ user.bio }}
                                    </p>
                                    <p v-else class="mb-10 text-lg leading-relaxed italic">
                                        Empty bio
                                    </p>
                                    <Link :href="'/dashboard/profile/' + user.id + '/edit'" class="group btn btn-warning btn-outline mr-3"><i class="bi bi-pen group-hover:text-white"></i></Link>
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
    <input type="checkbox" id="my-modal-3" class="modal-toggle" />
        <div class="modal">
        <div class="modal-box relative">
            <label for="my-modal-3" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <div class="container">
                <div class="row">
                  <div class="col">
                    <form id="form1" runat="server">
                      <input type='file' id="imgInp" class="mb-10"/>
                      <img id="my-image" class="hidden" src="#" />
                    </form>
                    <img id="result" src="" class="mx-auto">
                    <div class="flex justify-center items-center mt-10">
                        <button @click="enableApplyButton()" id="use" class="btn btn-secondary mr-2 hidden">Apply</button>
                        <Link id="apply-image" class="btn btn-success hidden">Confirm</Link>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</template>