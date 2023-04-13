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
        $lstComment = CommentPost::WHERE('post_id',$request->postId)->WHERE('parent_comment',null)->orderBy('created_at')->get();
        foreach($lstComment as $comment){
            $comment->userId = $comment->user_id;
            $comment->avatarUser = $comment->user->avatar == null ? 
                            ($comment->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
                            URL::to('media_file_post/'.$comment->user->id.'/'.$comment->user->avatar);
            $comment->username = $comment->user->first_name. ' ' . $comment->user->last_name;
            $comment->created_at = Carbon::parse($comment->created_at)->format('Y/m/d H:m:s');
            foreach($comment->replies as $reply){
                $reply->userId = $reply->user_id;
                $reply->avatarUser = $reply->user->avatar == null ? 
                           ($reply->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
                            URL::to('media_file_post/'.$reply->user->id.'/'.$reply->user->avatar);
                $reply->username = $reply->user->first_name. ' ' . $reply->user->last_name;
                $reply->created_at = Carbon::parse($reply->created_at)->format('Y/m/d H:m:s');
            }
           
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
        $countComment = CommentPost::WHERE('post_id',$input['postId'])->count();
        
        return response()->json($countComment,200);
    }

    public function commentReply(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;

        $reply = new CommentPost();
        $reply->post_id = $request->postId;
        $reply->comment_content = $request->commentContent;
        $reply->user_id = $userId;
        $reply->parent_comment = $request->commentId;
        $reply->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $reply->save();
        return response($reply,200);
    }
}