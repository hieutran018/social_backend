<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\PostTrait;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\URL;

class AdminPostController extends Controller
{
    use PostTrait;
    public function fetchListPost()
    {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        foreach ($posts as $post) {
            $post->privacy = $post->privacy === 0 ? 'Chỉ mình tôi' : ($post->privacy === 1 ? 'Công khai' : 'Bạn bè');
            $post->userName = $post->user->displayName;
            $post->type = $post->parent_post === null ? 'Bài viết' : 'Bài chia sẻ';
            $post->reaction = $post->like->count();
            $post->totalComment = $post->comment->count();
            $post->share = Post::Where('parent_post', $post->id)->count();
        }
        return response()->json($posts, 200);
    }

    public function fetchPostById($postId)
    {
        $post = Post::find($postId);
        $post->displayName = $post->user->displayName;
        // $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d h:m:s');
        $this->_renameAvatarUserFromPost($post);
        $post->totalMediaFile = $post->mediafile->count();
        $post->totalComment = $post->comment->count();
        $post->totalComment = $post->comment->count();
        $post->totalLike = $post->like->count();
        $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
        foreach ($post->mediafile as $mediaFile) {
            $this->_renameMediaFile($mediaFile, $post->user->id);
        }
        if ($post->icon) {
            $post->iconName = $post->icon->icon_name;
            $post->icon->patch =
                URL::to('icon/' . $post->icon->patch);
        }
        if ($post->tag) {
            foreach ($post->tag as $tag) {
                $tag->displayName = $tag->user->displayName;
                $tag->avatar = $tag->user->avatar === null ? ($tag->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $tag->user->id . '/' . $tag->user->avatar);
            }
        }
        if ($post->parent_post) {
            $post->parent_post = Post::find($post->parent_post);
            if ($post->parent_post) {
                $this->_selectParentPost($post->parent_post);
            } else {
                $post->parent_post = 1;
            }
        }
        if ($post->group_id != null) {
            $post->groupName = $post->group->group_name;
            $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $post->group->avatar);
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, 'media_file_name');
            }
        } else {
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, 'media_file_name', $post->user->id);
            }
        }
        return response()->json($post, 200);
    }
}
