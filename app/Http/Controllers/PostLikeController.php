<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Models\PostLike;
use Carbon\Carbon;

class PostLikeController extends Controller
{
    public function like(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $isLike = PostLike::WHERE('user_id', $userId)->WHERE('post_id', $request->postId)->first();
        if (empty($isLike)) {
            $like = new PostLike();
            $like->user_id = $userId;
            $like->post_id = $request->postId;
            $like->type = $request->reaction;
            $like->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $like->save();
            return response()->json($like, 200);
        } else {
            if ($isLike->type == $request->reaction) {
                $isLike->delete();
                return response()->json($isLike, 201);
            } else {
                $isLike->type = $request->reaction;
                $isLike->update();
                return response()->json($isLike, 202);
            }
        }
    }
}
