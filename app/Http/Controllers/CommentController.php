<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentPost;

class CommentController extends Controller
{
    public function fetchCommentByPost(Request $request){
        $lstComment = CommentPost::WHERE('post_id',$request->postId)->get();
        foreach($lstComment as $comment){
            $comment->username = $comment->user->first_name. ' ' . $comment->user->last_name;
        }
        return response()->json($lstComment,200);
    }
}