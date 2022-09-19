<script setup>
    import { QuillEditor } from '@vueup/vue-quill'
    import '@vueup/vue-quill/dist/vue-quill.snow.css';
    import moment from "moment";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import DrawerSide from '../Components/DashboardDrawerSide.vue';

    defineProps({
        route_name: String,
        categories: Object,
    });
    components: {
        QuillEditor,
        DrawerSide
    }
</script>

<script>
    export default {
        data() {
            return {
                moment: moment,
                newBlogTitle: null,
                newBlogCategoryId: null,
                newBlogBody: null,
                newBlogSlug: null,
                newTags: null,
                tags: [],
                tempTags: this.blogTags,
                inputtedTag: '',
            }
        },
        created() {
            this.isTagsRendered();
        },        
        methods: {
            isTagsRendered() {
                if(this.tempTags) {
                    this.tempTags.forEach(tag => {
                        this.tags.push(tag.name.en);
                    });
                }
            },
            createBlog() {
                if(this.newBlogTitle && this.newBlogBody && this.newBlogCategoryId) {
                    let preslug = this.newBlogTitle;
                    preslug = preslug.replace(/ /g,"-");
                    this.newBlogSlug = preslug.toLowerCase();
                    axios.post('/dashboard/blogs', {
                        params: {
                            title: this.newBlogTitle,
                            slug: this.newBlogSlug,
                            body: this.newBlogBody,
                            categoryId: this.newBlogCategoryId,
                            tags: this.tags
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

            deleteTag(arr, value) {
                return arr.filter(function(x){
                    return x != value;
                });
            },
            insertTag(inputtedTag) {
                this.tags.push(inputtedTag.toUpperCase());
                this.inputtedTag = '';
            },
            isInsertTag(inputtedTag) {
                if(inputtedTag.includes(",")) {
                    this.inputtedTag = '';
                    inputtedTag = inputtedTag.replace(',', '');
                    if(!inputtedTag.includes(",")) {
                        /^\s*$/.test(inputtedTag) ? '' : this.insertTag(inputtedTag);
                    }
                }
            }
        },
    }
</script>

<template>
    <Head title="Create Blogs" />
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
                <h1 class="lg:text-4xl text-2xl text-teal-900 dark:text-teal-500">Create new blog</h1>

                <div class="mt-10">
                    <div class="form-control max-w-7xl mb-10">
                        <!-- Title input -->
                        <div class="md:w-1/2 w-full">
                            <label class="label">
                                <span class="label-text text-base">Title</span>
                            </label>
                            
                            <input v-model="newBlogTitle" type="text" class="input input-bordered w-full text-gray-600 dark:text-white border-slate-300 text-base bg-transparent" />
                        </div>

                        <!-- Category input -->
                        <div class="mt-8">
                            <select class="md:w-1/2 w-full select select-bordered bg-transparent text-gray-600 dark:text-white border-slate-300 text-base font-light">
                                <option disabled selected>Pick category</option>
                                <option v-for="category in categories" @click="newBlogCategoryId = category.id">{{ category.name }}</option>
                            </select>
                        </div>
                        
                        <!-- Body input -->
                        <div class="mt-5 text-gray-600">
                            <label class="label">
                                <span class="label-text text-base">Caption</span>
                            </label>
                            <QuillEditor class="dark:text-white" theme="snow" v-model:content="newBlogBody" contentType="html" />
                        </div>

                        <!-- Tags input -->
                        <div class="md:w-1/2 w-full mt-5 items-center bg-transparent rounded-2xl overflow-hidden sm:max-w-4xl\">
                            
                            <div class="flex flex-col items-center mt-1 text-sm sm:flex-row sm:space-y-0 sm:space-x-4">
                                <div class="w-full sm:mb-2">
                                    <label for="input1">
                                        <span class="ml-2 text-sm sm:text-base">Tags (separate by comma)</span>
                                        <input @keyup="isInsertTag(inputtedTag)" v-model="inputtedTag" id="input1" class="mt-2 py-2 px-5 border-slate-300 w-full text-base outline-none placeholder:text-gray-400 dark:bg-transparent peer"
                                        type="text" />
                                    </label>
                                </div>
                            </div>

                            <div class='pt-2  flex flex-wrap rounded-lg'>
                                <span v-for="tag in tags"
                                    class="flex flex-wrap m-1 pl-4 pr-2 py-2 justify-between items-center text-sm font-medium rounded-xl cursor-pointer bg-teal-50 text-teal-500 dark:bg-teal-500 dark:bg-opacity-50 dark:text-white">
                                    {{ tag }}
                                    <svg @click="tags = deleteTag(tags, tag)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-3" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button @click="createBlog()" class="btn btn-accent text-white">Submit</button>
                </div>
            </div>
            <DrawerSide :route_name="route_name"></DrawerSide>
        </div>
    </div>
</template>