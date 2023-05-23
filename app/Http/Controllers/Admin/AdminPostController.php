<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class AdminPostController extends Controller
{
    public function fetchListPost()
    {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        foreach ($posts as $post) {
            $post->privacy = $post->privacy === 0 ? 'Chỉ mình tôi' : ($post->privacy === 1 ? 'Công khai' : 'Bạn bè');
            $post->userName = $post->user->displayName;
            $post->reaction = $post->like->count();
            $post->totalComment = $post->comment->count();
        }
        return response()->json($posts, 200);
    }
}
