<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CommentPost;
use App\Models\MediaFilePost;
use App\Models\PostLike;
use App\Models\MemberGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use PostTrait;

    public function createPost(Request $request)
    {
        $crPost = new Post();
        $crPost->user_id = JWTAuth::toUser($request->token)->id;
        $crPost->post_content = $request->postContent;
        $crPost->privacy = $request->privacy;
        $crPost->parent_post = null;
        $crPost->group_id = $request->groupId;
        $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $crPost->status = 1;
        $crPost->save();

        //* Upload Files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move('media_file_post/' . JWTAuth::toUser($request->token)->id, $fileName);
                $media = new MediaFilePost();
                $media->media_file_name = $fileName;
                $media->media_type = $fileExtentsion;
                $media->post_id = $crPost->id;
                // $media->group_id = $request->groupId;
                $media->user_id = JWTAuth::toUser($request->token)->id;
                $media->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $media->status = 1;
                $media->save();
            }
        }
        if (!empty($request->images)) {
            foreach ($request->images as $image) {
                //get fileImage Extension ex: https://exaample.com/upload/1734595129695881175.png
                //return png
                $splitName = explode('.', basename($image));
                $fileExtentsion = $splitName[1];
                $media = new MediaFilePost();
                $media->media_file_name = $image;
                $media->media_type = $fileExtentsion;
                $media->post_id = $crPost->id;
                // $media->group_id = $request->groupId;
                $media->user_id = JWTAuth::toUser($request->token)->id;
                $media->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $media->status = 1;
                $media->save();
            }
        }
        $crPost->displayName = $crPost->user->displayName;

        $crPost->created_at = Carbon::parse($crPost->created_at)->format('Y/m/d H:m:s');
        if ($crPost->group_id != null) {
            $crPost->groupName = $crPost->group->group_name;
            $crPost->groupAvatar = $crPost->group->avatar == null ?
                URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $crPost->group->avatar);
        }

        $crPost->avatarUser = $crPost->user->avatar == null ?
            ($crPost->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
            URL::to('media_file_post/' . $crPost->user->id . '/' . $crPost->user->avatar);
        $crPost->totalMediaFile = $crPost->mediafile->count();
        $crPost->totalComment = $crPost->comment->count();
        foreach ($crPost->mediafile as $mediaFile) {
            $this->_renameMediaFile($mediaFile, $crPost->user->id);
        }

        return response()->json($crPost, 200);
    }

    public function sharePost(Request $request)
    {
        $isShared = Post::WHERE('id', $request->postId)->first();
        $postShare = new Post();
        if ($isShared->parent_post) {
            $postShare->user_id = JWTAuth::toUser($request->token)->id;
            $postShare->privacy = $request->privacy;
            $postShare->parent_post = $isShared->parent_post;
            $postShare->post_content = $request->postContent;
            $postShare->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $postShare->status = 1;
        } else {
            $postShare->user_id = JWTAuth::toUser($request->token)->id;
            $postShare->privacy = $request->privacy;
            $postShare->parent_post = $request->postId;
            $postShare->post_content = $request->postContent;
            $postShare->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $postShare->status = 1;
        }

        $postShare->save();

        $postShare->displayName = $postShare->user->displayName;
        $postShare->created_at = Carbon::parse($postShare->created_at)->format('Y/m/d H:m:s');
        $postShare->avatarUser = $postShare->user->avatar == null ?
            ($postShare->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
            URL::to('media_file_post/' . $postShare->user->id . '/' . $postShare->user->avatar);
        $postShare->totalMediaFile = $postShare->mediafile->count();
        $postShare->totalComment = $postShare->comment->count();

        $postShare->parent_post = Post::find($postShare->parent_post);
        $postShare->parent_post->displayName = $postShare->parent_post->user->displayName;
        $postShare->parent_post->created_at = Carbon::parse($postShare->parent_post->created_at)->format('Y/m/d H:m:s');
        $postShare->parent_post->avatarUser = $postShare->parent_post->user->avatar == null ?
            ($postShare->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
            URL::to('media_file_post/' . $postShare->parent_post->user->id . '/' . $postShare->parent_post->user->avatar);
        $postShare->parent_post->totalMediaFile = $postShare->parent_post->mediafile->count();
        $postShare->parent_post->totalComment = $postShare->parent_post->comment->count();
        foreach ($postShare->parent_post->mediafile as $mediaFile) {
            $this->_renameMediaFile($mediaFile, $postShare->parent_post->user->id);
        }

        return response()->json($postShare, 200);
    }

    public function fetchPost(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $lstPost = Post::orderBy('created_at', 'DESC')->paginate(10);

        foreach ($lstPost as $post) {
            if ($post->parent_post) {
                $post->parent_post = Post::find($post->parent_post);
                $post->parent_post->displayName = $post->parent_post->user->displayName;
                $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');
                $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ?
                    ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $post->parent_post->user->avatar);
                $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
                $post->parent_post->totalComment = $post->parent_post->comment->count();
                foreach ($post->parent_post->mediafile as $mediaFile) {
                    $this->_renameMediaFile($mediaFile, $post->parent_post->user->id);
                    if ($post->parent_post->group_id != null) {
                        $post->parent_post->groupName = $post->parent_post->group->group_name;
                        $post->parent_post->groupAvatar = $post->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                            URL::to('media_file_post/' . $post->parent_post->group->avatar);
                    }
                }
            }
            if ($post->group_id != null) {
                $post->groupName = $post->group->group_name;
                $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                    URL::to('media_file_post/' . $post->group->avatar);
            }

            $post->displayName = $post->user->displayName;
            $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');
            $post->avatarUser = $post->user->avatar == null ?
                ($post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                URL::to('media_file_post/' . $post->user->id . '/' . $post->user->avatar);
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, $post->user->id);
            }
        }
        return response()->json($lstPost, 200);
    }

    public function fetchPostById(Request $request)
    {
        $post = Post::find($request->postId);
        $post->displayName = $post->user->displayName;
        $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d h:m:s');
        $post->avatarUser = $post->user->avatar == null ?
            ($post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
            URL::to('media_file_post/' . $post->user->id . '/' . $post->user->avatar);
        $post->totalMediaFile = $post->mediafile->count();
        $post->totalComment = $post->comment->count();
        foreach ($post->mediafile as $mediaFile) {
            $this->_renameMediaFile($mediaFile, $post->user->id);
        }
        return response()->json($post, 200);
    }

    public function fetchPostByGroupId(Request $request, $groupId)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $lst = Post::WHERE('group_id', $groupId)->orderBy('created_at', 'DESC')->get();
        foreach ($lst as $post) {
            $post->displayName = $post->user->displayName;
            $post->avataruser = $post->user->avatar == null ?
                ($post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                URL::to('media_file_post/' . $post->user->id . '/' . $post->user->avatar);
            $post->groupName = $post->group->group_name;
            $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $post->group->avatar);
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, $post->user->id);
            }
        }
        return response()->json($lst, 200);
    }

    public function fetchPostGroup(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $isJoined = MemberGroup::WHERE('user_id', $userId)->WHERE('status', 1)->get();
        foreach ($isJoined as $group) {
            $data[] = $group->group_id;
        }

        $posts = Post::select('*')
            ->where('status', 1)
            ->Where(function ($query) use ($data) {
                $query->WhereIn('group_id', $data);
            })->orderBy('created_at', 'DESC')->get();
        foreach ($posts as $post) {
            $post->displayName = $post->user->displayName;
            $post->avataruser = $post->user->avatar == null ?
                ($post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                URL::to('media_file_post/' . $post->user->id . '/' . $post->user->avatar);
            $post->groupName = $post->group->group_name;
            $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $post->group->avatar);
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, $post->user->id);
            }
        }
        return response()->json($posts, 200);
    }
}

trait PostTrait
{
    private function _renameMediaFile(MediaFilePost $mediaFile, int $userId): void
    {
        $isHttp = !empty(parse_url($mediaFile->media_file_name, PHP_URL_SCHEME));
        if (!$isHttp) {
            $mediaFile->media_file_name = URL::to('media_file_post/' . $userId  . '/' . $mediaFile->media_file_name);
        }
    }
}
