<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReportsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function blogs() {
        $blogs = Blog::with(["author", "category"])->filter(request(["search", "category"]))->latest()->get();
        $categories = Category::all();

        return Inertia::render("Blogs", [
            "blogs" => $blogs,
            "categories" => $categories
        ]);
    }

    private function setBlogCookie($blog) {
        $cookie_name = Auth::user()->id . $blog->slug;
        $cookie_value = Auth::user()->id . $blog->slug;
        $cookie_duration = 5;
        Cookie::queue($cookie_name, $cookie_value, $cookie_duration);
    }

    private function getBlogCookie($blog){
        $cookie = Cookie::get(Auth::user()->id . $blog->slug);
        return $cookie;
    }

    private function incrementViews($blog) {
        if($this->getBlogCookie($blog) == '') {
            $this->setBlogCookie($blog);
            $blog->update(['reads'=>$blog->reads + 1]);
        }
    }

    private function getComments($id) {
        $comments = Comment::where("blog_id", $id)->latest()->get();
        return $comments;
    }

    private function getLikeBlog($id) {
        $blog = Blog::find($id);
        $likes = $blog->likeCount;

        return $likes;
    }

    private function isBlogLiked($id) {
        $blog = Blog::find($id);
        $liked = $blog->liked;
        return $liked;
    }

    private function isRulesConfirmed() {
        $cookie = Cookie::get(Auth::user()->id . "-rules-confirmed");
        $isRulesConfirmed = false;

        if($cookie) {
            $isRulesConfirmed = true;
        }

        return $isRulesConfirmed;
    }

    public function blog($slug) {
        $blogObj = Blog::where("slug", $slug)->with(["author", "category"])->get();
        $comment_reports_categories = CommentReportsCategory::all();
        $comments = '';
        $likes = '';
        $liked = '';
        $isRulesConfirmed = '';
        $tags = '';
        $related_blogs = [];
        $related_blog = '';

        foreach($blogObj as $blog) {
            // Take previous and next blog
            $previous = Blog::find($blog->id - 1);
            $next = Blog::find($blog->id + 1);
            
            // Count views
            $this->incrementViews($blog);

            // Get comments
            $comments = $this->getComments($blog->id);

            // Get likes
            $likes = $this->getLikeBlog($blog->id);

            // Is blog liked ?
            $liked = $this->isBlogLiked($blog->id);

            // Is commenting rules confirmed ?
            $isRulesConfirmed = $this->isRulesConfirmed();

            // Get tags
            $tags = $blog->tags;

            // Get random related blogs
            foreach($tags as $tag) {
                array_push($related_blogs, $tag->name);
            }
            $related_blogs = Blog::withAnyTags($related_blogs)->where("id", "!=", $blog->id)->get();

            if(sizeof($related_blogs) > 0) {
                $related_blog_index = mt_rand(0, sizeof($related_blogs) - 1);
                $related_blog = $related_blogs[$related_blog_index];
            }
        }

        return Inertia::render("Blog", [
            "blogObj" => $blogObj,
            "previous" => $previous,
            "next" => $next,
            "commentReportsCategories" => $comment_reports_categories,
            "comments" => $comments,
            "likesData" => $likes,
            "isLiked" => $liked,
            "isRulesConfirmed" => $isRulesConfirmed,
            "tags" => $tags,
            "relatedBlog" => $related_blog
        ]);
    }
}