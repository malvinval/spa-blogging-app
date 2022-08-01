<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;


class SiteController extends Controller
{
    public function blogs() {
        $blogs = Blog::with(["author", "category"])->filter(request(["search", "category"]))->latest()->get();
        return Inertia::render("Blogs", compact("blogs"));
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

    public function blog($slug) {
        $blogObj = Blog::where("slug", $slug)->with(["author", "category"])->get();
        
        foreach($blogObj as $blog) {
            // Take previous and next blog
            $previous = Blog::find($blog->id - 1);
            $next = Blog::find($blog->id + 1);
            
            // Count views
            $this->incrementViews($blog);
        }


        return Inertia::render("Blog", [
            "blogObj" => $blogObj,
            "previous" => $previous,
            "next" => $next,
        ]);
    }
}