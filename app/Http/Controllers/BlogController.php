<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function likeBlog($id)
    {
        $blog = Blog::find($id);

        if($blog->liked()) {
            $blog->unlike();
        } else {
            $blog->like();
        }

        return response()->json([
            'likes' => $blog->likeCount,
        ]);
    }

    public function getLikeBlog($id) {
        $blog = Blog::find($id);
        
        return response()->json([
            'likes' => $blog->likeCount,
            'liked' => $blog->liked
        ]);
    }

    public function isRulesConfirmed($id) {
        $blog = Blog::find($id);
        $cookie = Cookie::get(Auth::user()->id . "-rules-confirmed");
        $isRulesConfirmed = false;

        if($cookie) {
            $isRulesConfirmed = true;
        }

        return response()->json([
            "isRulesConfirmed" => $isRulesConfirmed
        ]);
    }

    public function setRulesConfirmed($id) {
        $blog = Blog::find($id);

        $cookie_name = Auth::user()->id . "-rules-confirmed";
        $cookie_value = Auth::user()->id . "-rules-confirmed";
        $cookie_duration = 60;
        Cookie::queue($cookie_name, $cookie_value, $cookie_duration);
    }

    public function comment(Request $request) {
        Comment::create([
            "blog_id" => $request->params["blogId"],
            "user_id" => auth()->user()->id,
            "body" => $request->params["body"],
            "name" => auth()->user()->name
        ]);

        return response()->json([
            'success' => "Your comment has been published !",
        ]);
    }

    public function getComments($id) {
        $comments = Comment::where("blog_id", $id)->latest()->get();

        return response()->json([
            'comments' => $comments,
        ]);
    }

}