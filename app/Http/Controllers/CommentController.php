<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentPost;
use Carbon\Carbon;
use URL;

class CommentController extends Controller
{
    public function fetchCommentByPost(Request $request){
        $lstComment = CommentPost::WHERE('post_id',$request->postId)->orderBy('created_at')->get();
        foreach($lstComment as $comment){
            $comment->userId = $comment->user_id;
            $comment->avatarUser = $comment->user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$comment->user->id.'/'.$comment->user->avatar);
            $comment->username = $comment->user->first_name. ' ' . $comment->user->last_name;
            $comment->created_at = Carbon::parse($comment->created_at)->format('Y/m/d h:m:s');
        }
        return response()->json($lstComment,200);
    }
    //TODO: Validate input 
    public function createCommentPost(Request $request){
        $input = $request->all();

        $comment = new Comment();
        $comment->post_id = $input['postId'];
        $comment->comment_content = $input['commentContent'];
        $comment->user_id = $this->guard()->user()->id;
        // $comment->created_at = Carbon:
    }
}