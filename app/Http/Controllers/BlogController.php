<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

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
}
