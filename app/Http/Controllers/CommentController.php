<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentPost;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function fetchCommentByPost(Request $request){
        $lstComment = CommentPost::WHERE('post_id',$request->postId)->orderBy('created_at')->get();
        foreach($lstComment as $comment){
            $comment->username = $comment->user->first_name. ' ' . $comment->user->last_name;
            $comment->created_at = Carbon::parse($comment->created_at)->format('Y/m/d h:m:s');
        }
        return response()->json($lstComment,200);
    }
}