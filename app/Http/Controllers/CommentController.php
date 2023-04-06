<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentPost;
use App\Http\Controllers\AuthController;
use Carbon\Carbon;
use URL;
use JWTAuth;
class CommentController extends Controller
{
    

    public function fetchCommentByPost(Request $request){
        $lstComment = CommentPost::WHERE('post_id',$request->postId)->orderBy('created_at')->get();
        foreach($lstComment as $comment){
            $comment->userId = $comment->user_id;
            $comment->avatarUser = $comment->user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('media_file_post/'.$comment->user->id.'/'.$comment->user->avatar);
            $comment->username = $comment->user->first_name. ' ' . $comment->user->last_name;
            $comment->created_at = Carbon::parse($comment->created_at)->format('Y/m/d H:m:s');
        }
        return response()->json($lstComment,200);
    }


    //TODO: Validate input 
    public function createCommentPost(Request $request){
        $input = $request->all();
        $comment = new CommentPost();
        $comment->post_id = $input['postId'];
        $comment->comment_content = $input['commentContent'];
        $comment->user_id = JWTAuth::toUser($request->token)->id;
        $comment->created_at = Carbon::Now('Asia/Ho_Chi_Minh');
        $comment->save();
        return response()->json('Success',200);
    }
}