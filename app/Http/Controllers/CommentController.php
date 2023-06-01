<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentPost;
use App\Models\MediaFileComment;
use Carbon\Carbon;
use URL;
use JWTAuth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    use CommentTrait;
    public function fetchCommentByPost(Request $request)
    {
        $lstComment = CommentPost::WHERE('post_id', $request->postId)->WHERE('parent_comment', null)->orderBy('created_at')->get();
        foreach ($lstComment as $comment) {
            $comment->userId = $comment->user_id;
            $this->_renameAvatarUserFromComment($comment);
            $comment->displayName = $comment->user->displayName;
            //chổ này sao không để mạc định trả về, tào lao parse lại chi nó sai
            // $comment->created_at = Carbon::parse($comment->created_at)->format('Y/m/d H:m:s');
            if ($comment->file) {
                $comment->fileName = URL::to('comment/' . $comment->file->media_file_name);
                $comment->mediaType = $comment->file->media_type;
            }
            foreach ($comment->replies as $reply) {
                $reply->userId = $reply->user_id;
                $this->_renameAvatarUserFromComment($reply);
                $reply->displayName = $reply->user->displayName;
                // $reply->created_at = Carbon::parse($reply->created_at)->format('Y/m/d H:m:s');
            }
        }
        return response()->json($lstComment, 200);
    }


    //TODO: Validate input
    public function createCommentPost(Request $request)
    {
        $input = $request->all();
        $comment = new CommentPost();
        $comment->post_id = $input['postId'];
        $comment->comment_content = $input['commentContent'];
        $comment->user_id = JWTAuth::toUser($request->token)->id;
        $comment->created_at = Carbon::Now('Asia/Ho_Chi_Minh');
        $comment->save();

        if ($request->hasFile('file')) {
            $file = $request->file;
            $fileExtentsion = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $fileName = time() . $random . '.' . $fileExtentsion;
            $file->move('comment/', $fileName);
            $media = new MediaFileComment();
            $media->media_file_name = $fileName;
            $media->media_type = $fileExtentsion;
            $media->comment_id = $comment->id;
            $media->save();
        }
        if ($comment->fileName) {
            $comment->fileName = URL::to('/comment/' . $comment->file->media_file_name);
        } else {
            $comment->fileName = null;
        }
        // $countComment = CommentPost::WHERE('post_id', $input['postId'])->count();

        return response()->json($comment, 200);
    }

    public function commentReply(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        $reply = new CommentPost();
        $reply->post_id = $request->postId;
        $reply->comment_content = $request->commentContent;
        $reply->user_id = $userId;
        $reply->parent_comment = $request->commentId;
        $reply->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $reply->save();
        return response($reply, 200);
    }
}
trait CommentTrait
{
    private function _renameAvatarUserFromComment(CommentPost $comment): void //nên return string
    {
        $user = $comment->user;
        $user->renameAvatarUserFromUser();

        $comment->avatarUser = $user->avatar;
    }
}
