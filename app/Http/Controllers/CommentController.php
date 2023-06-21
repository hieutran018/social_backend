<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use Illuminate\Http\Request;
use App\Models\CommentPost;
use App\Models\MediaFileComment;
use App\Models\Post;
use App\Models\Notification;
use Carbon\Carbon;
use URL;
use JWTAuth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    use CommentTrait;
    public function fetchCommentByPost($postId)
    {
        $lstComment = CommentPost::WHERE('post_id', $postId)->WHERE('parent_comment', null)->orderBy('created_at', 'DESC')->get();
        foreach ($lstComment as $comment) {
            $comment->countComment = CommentPost::WHERE('parent_comment', $comment->id)->count();
            $comment->userId = $comment->user_id;
            $this->_renameAvatarUserFromComment($comment);
            $comment->displayName = $comment->user->displayName;
            $comment->isVerified = $comment->user->isVerified ? 1 : 0;
            if ($comment->file) {
                $comment->fileName = URL::to('comment/' . $comment->file->media_file_name);
                $comment->mediaType = $comment->file->media_type;
            }
        }
        return response()->json($lstComment, 200);
    }

    public function createCommentPost(Request $request)
    {
        $input = $request->all();
        $comment = new CommentPost();
        $comment->post_id = $input['postId'];
        $comment->comment_content = $input['commentContent'];
        $comment->user_id = JWTAuth::toUser($request->token)->id;
        $comment->created_at = Carbon::Now('Asia/Ho_Chi_Minh');
        $comment->parent_comment = null;
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

        $comment->userId = $comment->user_id;
        $this->_renameAvatarUserFromComment($comment);
        $comment->displayName = $comment->user->displayName;
        $comment->isVerified = $comment->user->isVerified ? 1 : 0;
        if ($comment->file) {
            $comment->fileName = URL::to('comment/' . $comment->file->media_file_name);
            $comment->mediaType = $comment->file->media_type;
        }

        $comment->created_at = Carbon::parse($comment->created_at)->toDateTimeString();

        $this->_createNotification($comment);
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

        $reply->userId = $reply->user_id;
        $this->_renameAvatarUserFromComment($reply);
        $reply->displayName = $reply->user->displayName;
        $reply->isVerified = $reply->user->isVerified ? 1 : 0;
        if ($reply->file) {
            $reply->fileName = URL::to('comment/' . $reply->file->media_file_name);
            $reply->mediaType = $reply->file->media_type;
        }

        $reply->created_at = Carbon::parse($reply->created_at)->toDateTimeString();
        return response($reply, 200);
    }

    public function fetchReplyComment($commentId)
    {
        $lstComment = CommentPost::WHERE('parent_comment', $commentId)->orderBy('created_at', 'DESC')->get();
        foreach ($lstComment as $comment) {
            $comment->countComment = CommentPost::WHERE('parent_comment', $comment->id)->count();
            $comment->userId = $comment->user_id;
            $this->_renameAvatarUserFromComment($comment);
            $comment->displayName = $comment->user->displayName;
            $comment->isVerified = $comment->user->isVerified ? 1 : 0;
            if ($comment->file) {
                $comment->fileName = URL::to('comment/' . $comment->file->media_file_name);
                $comment->mediaType = $comment->file->media_type;
            }
        }
        return response()->json($lstComment, 200);
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

    private function _createNotification(CommentPost $comment)
    {
        $post = Post::Where('id', $comment->post_id)->first();
        if ($comment->user_id === $post->user_id) {
            return;
        } else {
            $noti = new Notification();
            $noti->from = $comment->user_id;
            $noti->to = $post->user_id;
            $noti->title = 'đã bình luận về bài viết của bạn.';
            $noti->unread = 1;
            $noti->object_type = 'comment';
            $noti->object_id = $post->id;
            $noti->icon_url = 'icon.png';
            $noti->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $noti->save();
            $noti->userNameFrom = $noti->user->displayName;
            $noti->userAvatarFrom = $noti->user->avatar === null ?
                ($noti->user->sex === 0 ?
                    URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')
                ) : URL::to('media_file_post/' . $noti->user->id . '/' . $noti->user->avatar);
            event(new NotificationEvent($noti->toArray()));
        }
    }
}
