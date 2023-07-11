<?php

namespace App\Http\Controllers;

use App\Http\Traits\PostTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\MemberGroup;
use App\Models\FriendShip;
use App\Models\Post;
use App\Models\PostLike;
use Carbon\Carbon;
use JWTAuth;
use URL;

class SearchController extends Controller
{
    use PostTrait;

    public function searchData(Request $request, $input = null)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $data = [];
        $lstFriend = FriendShip::WHERE('status', 1)->WHERE('user_accept', $userId)->orWhere('user_request', $userId)->orderBy('created_at', 'DESC')->get();
        foreach ($lstFriend as $fr) {
            if ($fr->user_accept == $userId) {
                foreach ($fr->user as $user) {
                    $data[] = $user->id;
                }
            } else {
                foreach ($fr->users as $users) {
                    $data[]  = $users->id;
                }
            }
        }

        $dataUser = User::WHERE('email_verified_at', '!=', null)
            ->Where(function ($query) use ($input) {
                $query->where('displayName', 'LIKE', "%$input%");
            })->limit(4)->get();
        foreach ($dataUser as $user) {
            $user->renameAvatarUserFromUser();
            $user->displayName = $user->displayName;
            $user->isFriend = FriendShip::Where('status', 1)->where(function ($query) use ($user) {
                $query->where('user_accept', $user->id)->orWhere('user_request', $user->id)->first();
            })->Where(function ($query) use ($userId) {
                $query->where('user_accept', $userId)->orWhere('user_request', $userId)->first();
            })->first();
        }
        $dataGroup = Group::WHERE('group_name', 'LIKE', "%$input%")->limit(4)->get();
        foreach ($dataGroup as $group) {
            $group->renameAvatar();
            $group->totalMember = MemberGroup::WHERE('group_id', $group->id)->WHERE('status', 1)->count();
        }
        $dataPost = Post::WHERE('post_content', 'LIKE', "%$input%")->WHERE('status', 1)->orderBy('created_at', 'DESC')->limit(4)->get();
        foreach ($dataPost as $post) {
            $post->user->renameAvatarUserFromUser();

            if ($post->parent_post) {
                $post->parent_post = Post::find($post->parent_post);
                if ($post->parent_post) {
                    if ($post->parent_post->privacy === 1) {
                        $this->_selectParentPost($post->parent_post);
                    } else if ($post->parent_post->privacy === 2) {
                        if (!empty(Post::WhereIn('user_id', $data)->Where('id', $post->parent_post->id)->first())) {
                            $this->_selectParentPost($post->parent_post);
                        } else {
                            $post->parent_post = 1;
                        }
                    } else if ($post->parent_post->privacy === 0) {
                        $post->parent_post = 1;
                    }
                } else {
                    $post->parent_post = 1;
                }
            }
            if ($post->group_id != null) {
                $post->group->renameAvatar();
                $post->groupName = $post->group->group_name;
                $post->groupAvatar = $post->group->avatar;
            }
            if ($post->tag) {
                foreach ($post->tag as $tag) {
                    $post->tags = $tag->user->displayName;
                }
            }
            $post->displayName = $post->user->displayName;

            // $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');
            $post->avatarUser = $post->user->avatar;
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, 'media_file_name', $post->user->id);
            }
        }
        return response(['users' => $dataUser, 'groups' => $dataGroup, 'posts' => $dataPost], 200);
    }
}
