<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Str;

class DashboardBlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route_name = Route::current()->getName();
        $blogs = Blog::where("author_id", Auth::user()->id)->with(["author", "category"])->filter(request(["search", "category", "tag"]))->latest()->paginate(3);
        $categories = Category::all();

        return Inertia::render("Dashboard", [
            "route_name" => $route_name,
            "blogs" => $blogs,
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route_name = Route::current()->getName();
        $categories = Category::all();
        return Inertia::render("Dashboard", [
            "route_name" => $route_name,
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->params["title"];
        $body = $request->params["body"];
        $excerpt = Str::limit($body, 40);
        $category_id = $request->params["categoryId"];
        $slug = $request->params["slug"];

        Blog::create([
            "title" => $title,
            "slug" => $slug,
            "excerpt" => $excerpt,
            "body" => $body,
            "category_id" => $category_id,
            "author_id" => Auth::user()->id
        ]);
        
        
        return response()->json([
            "success" => "Your blog has been published successfully !"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog::find($id)->delete();
        
        return response()->json([
            'success' => "Blog deleted successfully !",
        ]);
    }
}
