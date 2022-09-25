<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import moment from "moment";
    
    defineProps({
        blogObj: Object,
        previous: Object,
        next: Object,
        commentReportsCategories: Object,
        comments: Object,
        isLiked: Boolean,
        likesData: Number,
        isRulesConfirmed: Boolean,
        tags: Object,
        relatedBlog: Object
    });
</script>

<script>
export default {
    data() {
        return {
            moment: moment,
            blogId: this.blogObj[0].id,
            likes: this.likesData,
            liked: this.isLiked,
            commentsData: this.comments,
            rulesConfirmed: this.isRulesConfirmed,
            commentBody: '',
            reportCommentId: '',
            reportCommentCategoryId: '',
            reportCommentSuccessTitle: '',
            reportCommentSuccessText: ''
        }
    },

    methods: {
        like() {
            axios.post('/like-blog/' + this.blogId)
                .then((response) => {
                    this.likes = response.data.likesData;
                    this.liked = response.data.isLiked;
                });
        },
        setRulesConfirmed() {
            swal({
                text: "Can you promise us not to violate the commenting rules that we have provided ?",
                icon: "warning",
                buttons: "Yes, I promise.",
            }).then((value) => {
                if(value) {
                    axios.post('/set-rules-confirmed')
                    .then(() => {   
                            this.rulesConfirmed = true;
                            this.$forceUpdate();
                        }
                    );

                    swal({
                        title: "Thank you !",
                        text: "Now you can use the comment feature.",
                        icon: "success",
                        timer: 3000,
                        buttons: false
                    });
                }
            });
        },
        comment() {
            if(this.rulesConfirmed) {
                axios.post('/comment/' + this.blogId, {
                    params: {
                        body: this.commentBody,
                        blogId: this.blogId
                    }
                }).then((response) => {
                        swal({
                            text: "Your comment has been published.",
                            icon: "success",
                            timer: 3000,
                            buttons: false
                        });
                        this.updateComments();

                        this.commentBody = '';
                    }
                )
            } else {
                swal({
                    title: "Oops !",
                    text: 'Please read our commenting rules carefully, then click the "I Understand" button.',
                    icon: "error",
                    button: true,
                });
            }
        },
        updateComments() {
            axios.post('/update-comments/' + this.blogObj[0].id)
                .then((response) => {
                    this.commentsData = response.data.updatedComments;
                })
        },
        sendCommentReport() {            
            axios.post('/send-comment-report/' + this.reportCommentId, {
                params: {
                    reportCommentCategoryId: this.reportCommentCategoryId,
                    blogId: this.blogId,
                }
            }).then((response) => {
                this.reportCommentSuccessTitle = response.data.successTitle;
                this.reportCommentSuccessText = response.data.successText;
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
                    <p class="text-base md:text-sm text-teal-500 font-bold">
                        <Link :href="route('blogs')"
                            class="text-base md:text-sm text-teal-500 dark:text-slate-500 font-bold no-underline hover:underline">BACK TO
                        BLOGS</Link>
                    </p>
                    <h1 class="font-bold break-normal text-teal-900 dark:text-teal-400 pt-6 pb-2 text-3xl md:text-4xl">{{ blog.title }}
                    </h1>
                    <div class="flex items-center text-xl justify-between">
                        <p class="text-sm md:text-base font-normal text-gray-600 dark:text-gray-400">Published {{
                                moment(blog.created_at).format("MMMM DD, YYYY")
                        }}</p>
                        <div class="flex">
                            <div class="flex views-btn-container mr-5">
                                <i class="bi bi-eye-fill mr-2 dark:text-slate-300"></i>
                                <p class="text-slate-800 dark:text-slate-300">{{ blog.reads }}</p>
                            </div>
                            <div class="flex like-btn-container">
                                <i @click="like()" class="cursor-pointer bi-suit-heart-fill bi mr-2"
                                    :class="liked ? 'text-secondary' : 'dark:text-slate-300'"></i>
                                <p class="text-slate-800 dark:text-slate-300">{{ likes }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Post Content-->

                <!--Body-->
                <div class="blog-body py-6 text-justify text-gray-600 dark:text-white" v-html="blog.body"></div>
            </div>

            <!--Category -->
            <div class="text-base flex justify-between md:text-sm text-gray-500 px-4 py-6">
                <span>
                    <span class="dark:text-slate-400">Category : </span> 
                    <Link :href="'/blogs/?category='+blog.category.slug" class="text-base md:text-sm text-teal-500 no-underline hover:underline dark:text-teal-400">{{ blog.category.name
                    }}</Link>
                </span>
            </div>

            <!--Divider-->
            <hr class="border-b-2 border-gray-400 mb-8 dark:border-gray-800 mx-4">

            <!-- Related Blog -->
            <blockquote class="border-l-4 border-teal-500 bg-slate-200 mx-5 my-8 pl-8 md:pl-12 py-2 dark:bg-gray-900">
                <span v-if="relatedBlog">
                    <span class="text-slate-500">Related blog </span>:
                    <Link :href="'/blog/' + relatedBlog.slug" class="text-teal-600 hover:underline">{{ relatedBlog.title }}</Link>
                </span>
                <span v-else>
                    <p class="text-slate-600 dark:text-slate-300">
                        No related blogs yet.
                    </p>
                </span>
            </blockquote>

            <!-- /Related Blog -->

            <!-- Tags -->
            <div v-if="tags" class="text-base md:text-sm text-gray-500 px-4 py-6">
                <span class="dark:text-slate-400">Tags : </span>
                <Link v-for="tag in blog.tags" :href="'/blogs/?tag='+tag.slug.en" class="mr-1 my-1 btn btn-xs bg-teal-500 border-none text-white hover:bg-teal-600 dark:bg-opacity-20 dark:text-teal-300 dark:hover:bg-teal-800">
                    <span>{{ tag.name.en }}</span> 
                </Link>
            </div>
            <div v-else class="text-base md:text-sm text-gray-500 px-4 py-6">
                <p class="italic text-slate-600">
                    No tags provided.
                </p>
            </div>
            <!-- /Tags -->

            <!-- Comment -->
            <div v-if="rulesConfirmed == false" class="collapse">
                <input type="checkbox" />
                <div class="collapse-title text-xl font-medium">
                    <p>
                        <i class="text-warning bi bi-exclamation-triangle-fill stroke-current flex-shrink-0 h-6 w-6"></i>
                        &nbsp;<span class="text-teal-900 text-base underline dark:text-teal-500">We provide rules for commenting</span>
                    </p>
                </div>
                <div class="collapse-content">
                    <div class="alert bg-transparent shadow-lg">
                        
                        <span class="text-gray-600 px-4 dark:text-white">
                            <ul class="list-disc">
                                <li class="comment-rule">
                                    Don't share comments that are degrading, discriminatory, or
                                    insulting to gender, sexual orientation, disability, ethnicity, religion,
                                    threats of violence, and any form of harassment.</li>
                                <li class="comment-rule">
                                    Don't make jokes about the misfortune of others. Imagine it was your loved one in the story, and show some restraint.
                                </li>
                                <li class="comment-rule">
                                    Other readers may disagree with your ideas, and that's okay. In fact, it's the point. Disagreement in the comments section should never lead to verbal warfare. Even if you think the ideas of the author or of other commenters are absurd, please be reasonable. There are real people on the other side of the screen. You can—and should—disagree with them respectfully.
                                </li>
                                <li class="comment-rule">
                                    Your comment can only be deleted if you have permission from the website administrator.
                                </li>
                            </ul>

                        </span>
                        <button v-on:click="setRulesConfirmed()" class="btn btn-accent">I understand</button>
                    </div>
                </div>
            </div>

            <div class="comments-container max-w-xl mx-5" v-if="comments != undefined">
                <p class="text-lg font-bold text-gray-500 mt-5 dark:text-gray-400">{{ commentsData.length }} comments</p>
                <div v-for="comment in commentsData" class="group single-comment-container">
                    <div class="text-base font-semibold text-gray-600 flex items-center justify-between">
                        <div class="flex mx-0">
                            <p class="dark:text-gray-200">{{ comment.name }}</p>&nbsp;
                            <span class="text-sm font-normal text-gray-500">- {{ moment(comment.created_at).format("MMMM DD, YYYY") }} </span>
                        </div>
                        <div class="text-red-500 cursor-pointer invisible report-btn-container group-hover:visible">
                            <label @click="this.reportCommentId = comment.id" for="report-modal" class="cursor-pointer modal-button"><i class="bi bi-exclamation-octagon"></i></label>
                        </div>
                        
                    </div>
                    <div class="text-base text-gray-500 dark:text-gray-400 my-2 text-justify">
                        {{ comment.body }}
                    </div>
                </div>
            </div>

            <div class="rounded-[12px] mx-5 mb-10">
                <textarea
                    v-model="commentBody" 
                    name="body"
                    class="bg-transparent h-40 px-3 text-base py-1 mt-5 outline-none border-gray-200 w-full resize-none border rounded-lg placeholder:text-base dark:border-gray-500"
                    placeholder="Comment here...">
                </textarea>

                <div class="mt-2">
                    <button @click="comment()" class="h-12 w-[150px] btn bg-teal-500 hover:bg-teal-600 border-none text-sm text-white rounded-lg transition-all cursor-pointer">Submit</button>
                </div>
            </div>
            <!-- /Comment -->

            <!--Donate-->
            <div class="container px-4">
                <div class="bg-gradient-to-b from-teal-100 to-gray-100 dark:from-gray-900 dark:to-teal-800 rounded-lg shadow-xl p-4 text-center">
                    <h2 class="font-bold break-normal text-xl md:text-3xl text-teal-800 dark:text-teal-500">Show your <span
                            class="text-rose-600">&hearts;</span> for this author !</h2>
                    <h3 class="font-bold break-normal text-gray-400 text-sm md:text-base">Please ensure that you do this
                        without any coercion.</h3>
                    <div class="w-full text-center pt-4">
                        <div class="max-w-xl mx-auto p-1 pr-0 flex flex-wrap items-center">
                            
                            <Link
                                class="flex-1 mt-4 block md:inline-block appearance-none bg-teal-500 text-white text-base font-semibold tracking-wider uppercase py-4 rounded shadow hover:bg-teal-400">
                            Donate</Link>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Donate-->

            <!--Author-->
            <div class="flex w-full items-center font-sans px-4 py-12">
                <img class="w-10 h-10 rounded-full mr-4" src="http://i.pravatar.cc/300" alt="Avatar of Author">
                <div class="flex-1 px-2">
                    <p class="font-bold text-base md:text-xl leading-none mb-2 dark:text-slate-300">{{ blog.author.name }}</p>
                    <p class="text-gray-600 text-xs md:text-base dark:text-gray-400">Fullstack Web Developer</p>
                </div>
                <div class="justify-end">
                    <button
                        class="bg-transparent border border-gray-500 hover:border-teal-500 text-xs text-gray-500 hover:text-teal-500 dark:text-gray-300 font-bold py-2 px-4 rounded-full">See
                        More</button>
                </div>
            </div>
            <!--/Author-->

            <!--Divider-->
            <hr class="border-b-2 border-gray-400 mb-8 mx-4">

            <!--Next & Prev Links-->
            <div class="font-sans flex justify-between content-center px-4 pb-12">
                <div class="text-left">
                    <Link v-if="previous != NULL" :href="'/blog/' + previous.slug" class="font-bold text-secondary">&lt;
                    Previous Blog</Link>
                </div>
                <div class="text-right">
                    <Link v-if="next != NULL" :href="'/blog/' + next.slug" class="font-bold text-accent">Next Blog &gt;
                    </Link>
                </div>
            </div>

        </div>
        <footer class="bg-white border-t border-gray-400 shadow dark:bg-gray-900 dark:border-none">
            <div class="container max-w-4xl mx-auto flex py-8">

                <div class="w-full mx-auto flex flex-wrap">
                    <div class="flex w-full md:w-1/2 ">
                        <div class="px-8">
                            <h3 class="font-bold text-gray-900 dark:text-gray-200">About the author</h3>
                            <p class="py-4 text-gray-600 text-sm dark:text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel mi ut felis tempus
                                commodo nec id erat. Suspendisse consectetur dapibus velit ut lacinia.
                            </p>
                        </div>
                    </div>

                    <div class="flex w-full md:w-1/2">
                        <div class="px-8">
                            <h3 class="font-bold text-gray-900">Social</h3>
                            <ul class="list-reset items-center text-sm pt-3">
                                <li>
                                    <a class="inline-block text-gray-600 dark:text-gray-300 no-underline hover:text-gray-900 dark:hover:text-teal-400 hover:text-underline py-1"
                                        href="#">Github</a>
                                </li>
                                <li>
                                    <a class="inline-block text-gray-600 dark:text-gray-300 no-underline hover:text-gray-900 dark:hover:text-teal-400 hover:text-underline py-1"
                                        href="#">VK</a>
                                </li>
                                <li>
                                    <a class="inline-block text-gray-600 dark:text-gray-300 no-underline hover:text-gray-900 dark:hover:text-teal-400 hover:text-underline py-1"
                                        href="#">Facebook</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <input type="checkbox" id="report-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box relative">
                <label for="report-modal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="text-lg font-bold mb-5">Why are you reporting this comment ?</h3>
                <div v-for="commentReportCategory in commentReportsCategories" class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">{{ commentReportCategory.name }}</span> 
                        <input type="radio" :value="commentReportCategory.id" v-model="this.reportCommentCategoryId" name="commentReportCategory" class="radio checked:bg-teal-500" />
                    </label>
                </div>
                <div class="modal-action">
                    <button v-if="this.reportCommentCategoryId" @click="sendCommentReport()" class="btn"><label for="report-feedback-modal" class="btn modal-button">Send report</label></button>
                </div>
            </div>
        </div>

        <input type="checkbox" id="report-feedback-modal" class="modal-toggle" />
        <div class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">{{ this.reportCommentSuccessTitle }}</h3>
                <p class="py-4">{{ this.reportCommentSuccessText }}</p>
                <div class="modal-action">
                <label for="report-feedback-modal" class="btn">Close</label>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>
* {
    font-family: 'Quicksand', sans-serif;
}
</style>