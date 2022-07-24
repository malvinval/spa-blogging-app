<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function blogs() {
        $blogs = Blog::with(["author", "category"])->latest()->get();

        return Inertia::render("Blogs", compact("blogs"));
    }

    public function blog($slug) {
        $blogObj = Blog::where("slug", $slug)->with(["author", "category"])->get();
        
        foreach($blogObj as $blog) {
            $previous = Blog::find($blog->id - 1);
            $next = Blog::find($blog->id + 1);
        }

        return Inertia::render("Blog", [
            "blogObj" => $blogObj,
            "previous" => $previous,
            "next" => $next
        ]);
    }
}
