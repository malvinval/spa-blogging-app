<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentReports;
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
            'isLiked' => $blog->liked,
            'likesData' => $blog->likeCount
        ]);
    }

    public function setRulesConfirmed() {
        $cookie_name = Auth::user()->id . "-rules-confirmed";
        $cookie_value = Auth::user()->id . "-rules-confirmed";
        $cookie_duration = 30;
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

    public function updateComments($id) {
        $comments = Comment::where("blog_id", $id)->latest()->get();

        return response()->json([
            'updatedComments' => $comments,
        ]);
    }

    public function sendCommentReport($id, Request $request) {
        CommentReports::create([
            "comment_id" => $id,
            "reports_category_id" => $request->params["reportCommentCategoryId"],
            "blog_id" => $request->params["blogId"]
        ]);

        return response()->json([
            'successTitle' => 'Thanks for letting us know',
            'successText' => 'Your feedback is important in helping us keep the ' . env("APP_NAME") . ' community safe.'
        ]);
    }

}