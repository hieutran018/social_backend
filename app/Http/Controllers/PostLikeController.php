<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Models\PostLike;
use App\Models\Notification;
use App\Models\Post;
use Carbon\Carbon;

class PostLikeController extends Controller
{
    use LikeTrait;
    public function like(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $isLike = PostLike::WHERE('user_id', $userId)->WHERE('post_id', $request->postId)->first();
        $post = Post::Where('id', $request->postId)->first();
        if (empty($isLike)) {
            $like = new PostLike();
            $like->user_id = $userId;
            $like->post_id = $request->postId;
            $like->type = $request->reaction;
            $like->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $like->save();
            $this->_createNotification($userId, $post->user_id, $like);
            return response()->json($like, 200);
        } else {
            if ($isLike->type == $request->reaction) {
                $isLike->delete();
                return response()->json($isLike, 201);
            } else {
                $isLike->type = $request->reaction;
                $isLike->update();
                $this->_createNotification($userId, $post->user_id, $isLike);
                return response()->json($isLike, 202);
            }
        }
    }
}
trait LikeTrait
{
    private function _createNotification(int $userSent, int $userReceive, PostLike $typeReaction): void
    {
        $new = new Notification();
        $new->from = $userSent;
        $new->to = $userReceive;
        $new->title = $typeReaction->type === 1 ? 'đã thích bài viết của bạn.' : 'đã bày tỏ cảm xúc về bài viết của bạn';
        $new->unread = 1;
        $new->object_type = 'reaction';
        $new->object_id = $typeReaction->id;
        $new->icon_url = 'icon.png';
        $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $new->save();
    }
}
