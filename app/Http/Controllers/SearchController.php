<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\MemberGroup;
use App\Models\Post;
use App\Models\PostLike;
use Carbon\Carbon;
use JWTAuth;
use URL;

class SearchController extends Controller
{
    public function searchData(Request $request, $input = null)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $dataUser = User::WHERE('email_verified_at', '!=', null)
            ->Where(function ($query) use ($input) {
                $query->where('displayName', 'LIKE', "%$input%");
            })->limit(4)->get();
        foreach ($dataUser as $user) {
            $user->displayName = $user->displayName;
            $user->avatar = $user->avatar == null ?
                ($user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
                :
                URL::to('media_file_post/' . $user->id . '/' . $user->avatar);
        }
        $dataGroup = Group::WHERE('group_name', 'LIKE', "%$input%")->limit(4)->get();
        foreach ($dataGroup as $group) {
            $group->avatar = $group->avatar == null ?
                URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $group->avatar);
            $group->totalMember = MemberGroup::WHERE('group_id', $group->id)->WHERE('status', 1)->count();
        }
        $dataPost = Post::WHERE('post_content', 'LIKE', "%$input%")->WHERE('status', 1)->limit(4)->get();
        foreach ($dataPost as $post) {
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
                    $mediaFile->media_file_name = URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $mediaFile->media_file_name);
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
                $mediaFile->media_file_name = URL::to('media_file_post/' . $post->user->id . '/' . $mediaFile->media_file_name);
            }
        }
        return response(['users' => $dataUser, 'groups' => $dataGroup, 'posts' => $dataPost], 200);
    }
}
