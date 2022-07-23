<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function blogs() {
        $blogs = Blog::with(["author", "category"])->get();

        return Inertia::render("Blogs", compact("blogs"));
    }
}
