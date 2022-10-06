<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import DrawerSide from '../Components/DashboardDrawerSide.vue';
    
    defineProps({
        route_name: String,
        countries: Object,
        user: Object
    });

    components: {
        DrawerSide
    }
</script>

<script>
    export default {
        data() {
            return {
                bio: this.user.bio,
                fullname: this.user.name,
                status: this.user.status,
            }
        }, methods: {
            updateProfile(id) {
                axios.put('/dashboard/profile/'+id, {
                        params: {
                            bio: this.bio,
                            fullname: this.fullname,
                            status: this.status,
                            country: document.getElementById("countryInput").value
                        }
                    }).then((response) => {
                            swal({
                                title: "Yay !",
                                text: response.data.success,
                                icon: "success",
                                timer: 3000,
                                buttons: false
                            });
                        }
                    )
            }
        },
    }
</script>

<template>
    <Head title="Edit Profile" />

    <div id="sidebar" class="bg-white dark:bg-gray-900">
        <div class="drawer drawer-mobile">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col p-10">
                <div class="flex lg:justify-start justify-end">
                    <label for="my-drawer-2" class="btn btn-accent ml-2 border-none dark:bg-transparent dark:hover:bg-transparent bg-teal-50 text-teal-500 hover:bg-teal-50 rounded-full drawer-button text-2xl lg:hidden">
                        <i class="bi bi-list"></i>
                    </label>
                </div>
                <!-- Page content here -->
                <h1 class="lg:text-4xl text-2xl text-teal-900 dark:text-teal-500">Edit Profile</h1>
                <div class="mt-10">
                    <div class="form-control max-w-7xl mb-10">
                        <!-- Fullname edit input -->
                        <div class="mt-5 md:w-1/2 w-full">
                            <label class="label">
                                <span class="label-text text-base">Full name</span>
                            </label>
                            
                            <input type="text" v-model="fullname" class="input text-base input-bordered w-full text-gray-600 dark:text-white border-slate-300 bg-transparent" />
                        </div>

                        <!-- Country edit input -->
                        <div class="mt-8">
                            <select id="countryInput" class="md:w-1/2 w-full select select-bordered bg-transparent text-gray-600 border-slate-300 dark:text-white text-base font-light">
                                <option v-if="user.country" :value="user.country" selected>{{ user.country }}</option>
                                <option v-else selected>Your country</option>
                                <option v-for="country in countries" :value="country.Name">{{ country.Name }}</option>
                            </select>
                        </div>
                        
                        <!-- Bio edit input -->
                        <div class="mt-5 text-gray-600 dark:text-white">
                            <label class="label">
                                <span class="label-text text-base">Bio</span>
                            </label>
                            <textarea
                                v-model="bio"
                                id="bioInput"
                                name="bio"
                                class="bg-transparent h-40 px-3 text-base py-1 mt-5 outline-none border-gray-200 w-full lg:w-3/4 resize-none border rounded-lg placeholder:text-base dark:border-gray-500"
                                placeholder="Write something about yourself here...">
                            </textarea>
                        </div>

                        <!-- Status edit input -->
                        <div class="mt-5 md:w-1/2 w-full">
                            <label class="label">
                                <span class="label-text text-base">Status</span>
                            </label>
                            
                            <input v-model="status" placeholder="ex : Fullstack Web Developer" type="text" class="input text-base input-bordered w-full text-gray-600 dark:text-white border-slate-300 bg-transparent" />
                        </div>
                    </div>
                    <Link :href="'/dashboard/profile'" @click="updateProfile(user.id)" class="btn btn-accent">Update</Link>
                </div>
            </div>
            <DrawerSide :route_name="route_name"></DrawerSide>
        </div>
    </div>
</template>