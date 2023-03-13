<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function fetchPost(){
        $lstPost = Post::all();
        return response()->json($lstPost,200);
    }
}