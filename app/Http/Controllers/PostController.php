<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function fetchPost(){
        $lstPost = Post::all();
        foreach($lstPost as $post){
           $post->user_id = $post->user->first_name. ' ' . $post->user->last_name;
           $post->created_at = Carbon::parse($post->created_at)->format('d:m:Y');
        }
        return response()->json($lstPost,200);
    }
}