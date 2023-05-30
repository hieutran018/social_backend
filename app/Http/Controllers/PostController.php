<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
// use App\Models\CommentPost;
use App\Models\FriendShip;
use App\Models\MediaFilePost;
use App\Models\PostLike;
use App\Models\MemberGroup;
use App\Models\Tag;
use App\Models\PostHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use DB;

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
        $crPost->feel_activity_id = $request->feelActivityId;
        $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $crPost->status = 1;
        $crPost->save();
        if (!empty($request->tags)) {
            foreach ($request->tags as $tag) {
                $newTag = new Tag();
                $newTag->user_id = $tag;
                $newTag->post_id = $crPost->id;
                $newTag->save();
            }
        }

        //* Upload Files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                if ($request->groupId) {
                    $file->move('media_file_post/', $fileName);
                } else {
                    $file->move('media_file_post/' . JWTAuth::toUser($request->token)->id, $fileName);
                }
                $media = new MediaFilePost();
                $media->media_file_name = $fileName;
                $media->media_type = $fileExtentsion;
                $media->post_id = $crPost->id;
                $media->group_id = $request->groupId;
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
        if ($crPost->icon) {
            $crPost->iconName = $crPost->icon->icon_name;
            $crPost->iconPatch =
                URL::to('icon/' . $crPost->icon->patch);
        }
        $crPost->created_at = Carbon::parse($crPost->created_at)->format('Y/m/d H:m:s');
        if ($crPost->group_id != null) {
            $crPost->groupName = $crPost->group->group_name;
            $crPost->groupAvatar = $crPost->group->avatar == null ?
                URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $crPost->group->avatar);
        }

        $this->_renameAvatarUserFromPost($crPost);
        $crPost->like = $crPost->like;
        $crPost->totalMediaFile = $crPost->mediafile->count();
        $crPost->totalComment = $crPost->comment->count();
        if ($request->groupId) {
            foreach ($crPost->mediafile as $mediaFile) {
                $this->_renameMediaFileForGroup($mediaFile);
            }
        } else {
            foreach ($crPost->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, $crPost->user->id);
            }
        }
        if ($crPost->tag) {
            foreach ($crPost->tag as $tag) {
                $crPost->tags = $tag->user->displayName;
            }
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

        if ($postShare->tag) {
            foreach ($postShare->tag as $tag) {
                $postShare->tag = $tag;
            }
        }

        $postShare->displayName = $postShare->user->displayName;

        $postShare->created_at = Carbon::parse($postShare->created_at)->format('Y/m/d H:m:s');

        $this->_renameAvatarUserFromPost($postShare);

        $postShare->totalMediaFile = $postShare->mediafile->count();
        $postShare->totalComment = $postShare->comment->count();
        $postShare->totalLike = $postShare->like->count();
        $postShare->parent_post = Post::find($postShare->parent_post);

        $postShare->parent_post->created_at = Carbon::parse($postShare->parent_post->created_at)->format('Y/m/d H:m:s');

        $this->_renameAvatarUserFromPost($postShare->parent_post);

        $postShare->parent_post->totalMediaFile = $postShare->parent_post->mediafile->count();
        $postShare->parent_post->totalComment = $postShare->parent_post->comment->count();
        if ($postShare->parent_post->group_id) {
            $postShare->parent_post->groupName = $postShare->parent_post->group->group_name;
            $postShare->parent_post->displayName = $postShare->user->displayName;
            $postShare->parent_post->groupAvatar = $postShare->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $postShare->parent_post->group->avatar);
            foreach ($postShare->parent_post->mediafile as $mediaFile) {
                $this->_renameMediaFileForGroup($mediaFile);
            }
        } else {
            $postShare->parent_post->displayName = $postShare->parent_post->user->displayName;
            if ($postShare->parent_post->icon) {
                $postShare->parent_post->iconName = $postShare->parent_post->icon->icon_name;
                $postShare->parent_post->iconPatch =
                    URL::to('icon/' . $postShare->parent_post->icon->patch);
            }
            $postShare->parent_post->avatarUser = $postShare->parent_post->user->avatar == null ?
                ($postShare->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                URL::to('media_file_post/' . $postShare->parent_post->user->id . '/' . $postShare->parent_post->user->avatar);
        }
        if ($postShare->parent_post->tag) {
            foreach ($postShare->parent_post->tag as $tag) {
                $postShare->parent_post->tag = $tag;
            }
        }
        foreach ($postShare->parent_post->mediafile as $mediaFile) {
            $this->_renameMediaFile($mediaFile, $postShare->parent_post->user->id);
        }

        return response()->json($postShare, 200);
    }

    public function fetchPostByUserId($userId)
    {
        $data[] = $userId;
        $lstFriend = FriendShip::WHERE('status', 1)->WHERE('user_accept', $userId)->orWhere('user_request', $userId)->orderBy('created_at', 'DESC')->get();
        $lstGroup = MemberGroup::WHERE('status', 1)->WHERE('user_id', $userId)->get();
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
        foreach ($lstGroup as $group) {
            $gr[] = $group->group_id;
        }

        if (!empty($gr)) {
            $lstPost = Post::WhereIn('user_id', $data)->Where('privacy', '!=', 0)->orWhere('group_id', $gr)->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $lstPost = Post::WhereIn('user_id', $data)->Where('privacy', '!=', 0)->orderBy('created_at', 'DESC')->paginate(10);
        }


        foreach ($lstPost as $post) {
            if ($post->parent_post) {
                $post->parent_post = Post::find($post->parent_post);
                $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');

                $this->_renameAvatarUserFromPost($post->parent_post);

                $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
                $post->parent_post->totalComment = $post->parent_post->comment->count();
                if ($post->parent_post->tag) {
                    foreach ($post->parent_post->tag as $tag) {
                        $post->parent_post->tag = $tag;
                    }
                }
                if ($post->parent_post->group_id) {
                    $post->parent_post->groupName = $post->parent_post->group->group_name;
                    $post->parent_post->displayName = $post->user->displayName;
                    $post->parent_post->groupAvatar = $post->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                        URL::to('media_file_post/' . $post->parent_post->group->avatar);
                    foreach ($post->parent_post->mediafile as $mediaFile) {
                        $this->_renameMediaFileForGroup($mediaFile);
                    }
                } else {
                    $post->parent_post->displayName = $post->parent_post->user->displayName;
                    if ($post->parent_post->icon) {
                        $post->parent_post->iconName = $post->parent_post->icon->icon_name;
                        $post->parent_post->iconPatch =
                            URL::to('icon/' . $post->parent_post->icon->patch);
                    }
                    $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ?
                        ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                        URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $post->parent_post->user->avatar);
                    foreach ($post->parent_post->mediafile as $mediaFile) {
                        $this->_renameMediaFile($mediaFile, $post->parent_post->user->id);
                    }
                }
            }

            if ($post->tag) {
                foreach ($post->tag as $tag) {
                    $post->tags = $tag->user->displayName;
                }
            }

            $post->displayName = $post->user->displayName;
            if ($post->icon) {
                $post->iconName = $post->icon->icon_name;
                $post->iconPatch =
                    URL::to('icon/' . $post->icon->patch);
            }
            $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');

            $this->_renameAvatarUserFromPost($post);

            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());

            if ($post->group_id != null) {
                $post->groupName = $post->group->group_name;
                $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                    URL::to('media_file_post/' . $post->group->avatar);
                foreach ($post->mediafile as $mediaFile) {
                    $this->_renameMediaFileForGroup($mediaFile);
                }
            } else {
                foreach ($post->mediafile as $mediaFile) {
                    $this->_renameMediaFile($mediaFile, $post->user->id);
                }
            }
        }
        return response()->json($lstPost, 200);
    }

    public function fetchPost(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $data[] = $userId;
        $lstFriend = FriendShip::WHERE('status', 1)->WHERE('user_accept', $userId)->orWhere('user_request', $userId)->orderBy('created_at', 'DESC')->get();
        $lstGroup = MemberGroup::WHERE('status', 1)->WHERE('user_id', $userId)->get();
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
        foreach ($lstGroup as $group) {
            $gr[] = $group->group_id;
        }

        if (!empty($gr)) {
            $lstPost = Post::WhereIn('user_id', $data)->Where('privacy', '!=', 0)->orWhere('group_id', $gr)->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $lstPost = Post::WhereIn('user_id', $data)->Where('privacy', '!=', 0)->orderBy('created_at', 'DESC')->paginate(10);
        }


        foreach ($lstPost as $post) {
            if ($post->parent_post) {

                $post->parent_post = Post::find($post->parent_post);
                if ($post->parent_post) {
                    if ($post->parent_post->privacy === 1) {
                        $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');
                        $this->_renameAvatarUserFromPost($post->parent_post);
                        $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
                        $post->parent_post->totalComment = $post->parent_post->comment->count();
                        if ($post->parent_post->tag) {
                            foreach ($post->parent_post->tag as $tag) {
                                $post->parent_post->tag = $tag;
                            }
                        }
                        if ($post->parent_post->group_id) {
                            $post->parent_post->groupName = $post->parent_post->group->group_name;
                            $post->parent_post->displayName = $post->user->displayName;
                            $post->parent_post->groupAvatar = $post->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                                URL::to('media_file_post/' . $post->parent_post->group->avatar);
                            foreach ($post->parent_post->mediafile as $mediaFile) {
                                $this->_renameMediaFileForGroup($mediaFile);
                            }
                        } else {
                            $post->parent_post->displayName = $post->parent_post->user->displayName;
                            if ($post->parent_post->icon) {
                                $post->parent_post->iconName = $post->parent_post->icon->icon_name;
                                $post->parent_post->iconPatch =
                                    URL::to('icon/' . $post->parent_post->icon->patch);
                            }
                            $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ?
                                ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                                URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $post->parent_post->user->avatar);
                            foreach ($post->parent_post->mediafile as $mediaFile) {
                                $this->_renameMediaFile($mediaFile, $post->parent_post->user->id);
                            }
                        }
                    } else if ($post->parent_post->privacy === 2) {
                        // dd(Post::WhereIn('user_id', $data)->Where('id', $post->parent_post->id)->first(), $post->parent_post, $data);
                        if (!empty(Post::WhereIn('user_id', $data)->Where('id', $post->parent_post->id)->first())) {
                            $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');
                            $this->_renameAvatarUserFromPost($post->parent_post);
                            $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
                            $post->parent_post->totalComment = $post->parent_post->comment->count();
                            if ($post->parent_post->tag) {
                                foreach ($post->parent_post->tag as $tag) {
                                    $post->parent_post->tag = $tag;
                                }
                            }
                            if ($post->parent_post->group_id) {
                                $post->parent_post->groupName = $post->parent_post->group->group_name;
                                $post->parent_post->displayName = $post->user->displayName;
                                $post->parent_post->groupAvatar = $post->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                                    URL::to('media_file_post/' . $post->parent_post->group->avatar);
                                foreach ($post->parent_post->mediafile as $mediaFile) {
                                    $this->_renameMediaFileForGroup($mediaFile);
                                }
                            } else {
                                $post->parent_post->displayName = $post->parent_post->user->displayName;
                                if ($post->parent_post->icon) {
                                    $post->parent_post->iconName = $post->parent_post->icon->icon_name;
                                    $post->parent_post->iconPatch =
                                        URL::to('icon/' . $post->parent_post->icon->patch);
                                }
                                $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ?
                                    ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                                    URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $post->parent_post->user->avatar);
                                foreach ($post->parent_post->mediafile as $mediaFile) {
                                    $this->_renameMediaFile($mediaFile, $post->parent_post->user->id);
                                }
                            }
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

            if ($post->tag) {
                foreach ($post->tag as $tag) {
                    $post->tags = $tag->user->displayName;
                }
            }

            $post->displayName = $post->user->displayName;
            if ($post->icon) {
                $post->iconName = $post->icon->icon_name;
                $post->iconPatch =
                    URL::to('icon/' . $post->icon->patch);
            }
            $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');

            $this->_renameAvatarUserFromPost($post);

            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            $post->histories = $post->postHistory->count();
            if ($post->group_id != null) {
                $post->groupName = $post->group->group_name;
                $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                    URL::to('media_file_post/' . $post->group->avatar);
                foreach ($post->mediafile as $mediaFile) {
                    $this->_renameMediaFileForGroup($mediaFile);
                }
            } else {
                foreach ($post->mediafile as $mediaFile) {
                    $this->_renameMediaFile($mediaFile, $post->user->id);
                }
            }
        }
        return response()->json($lstPost, 200);
    }

    public function fetchPostById($postId)
    {
        $post = Post::find($postId);
        $post->displayName = $post->user->displayName;
        $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d h:m:s');

        $this->_renameAvatarUserFromPost($post);

        $post->totalMediaFile = $post->mediafile->count();
        $post->totalComment = $post->comment->count();
        foreach ($post->mediafile as $mediaFile) {
            $this->_renameMediaFile($mediaFile, $post->user->id);
        }
        if ($post->icon) {
            $post->iconName = $post->icon->icon_name;
            $post->iconPatch =
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
            $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');

            $this->_renameAvatarUserFromPost($post->parent_post);

            $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
            $post->parent_post->totalComment = $post->parent_post->comment->count();
            if ($post->parent_post->tag) {
                foreach ($post->parent_post->tag as $tag) {
                    $post->parent_post->tag = $tag;
                }
            }
            if ($post->parent_post->group_id) {
                $post->parent_post->groupName = $post->parent_post->group->group_name;
                $post->parent_post->displayName = $post->user->displayName;
                $post->parent_post->groupAvatar = $post->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                    URL::to('media_file_post/' . $post->parent_post->group->avatar);
                foreach ($post->parent_post->mediafile as $mediaFile) {
                    $this->_renameMediaFileForGroup($mediaFile);
                }
            } else {
                $post->parent_post->displayName = $post->parent_post->user->displayName;
                if ($post->parent_post->icon) {
                    $post->parent_post->iconName = $post->parent_post->icon->icon_name;
                    $post->parent_post->iconPatch =
                        URL::to('icon/' . $post->parent_post->icon->patch);
                }
                $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ?
                    ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $post->parent_post->user->avatar);
                foreach ($post->parent_post->mediafile as $mediaFile) {
                    $this->_renameMediaFile($mediaFile, $post->parent_post->user->id);
                }
            }
        }
        return response()->json($post, 200);
    }

    public function fetchPostByGroupId(Request $request, $groupId)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $lst = Post::WHERE('group_id', $groupId)->orderBy('created_at', 'DESC')->paginate(10);
        foreach ($lst as $post) {
            $post->displayName = $post->user->displayName;

            $this->_renameAvatarUserFromPost($post);

            $post->groupName = $post->group->group_name;
            $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $post->group->avatar);
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFileForGroup($mediaFile);
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
            })->orderBy('created_at', 'DESC')->paginate(10);
        foreach ($posts as $post) {
            $post->displayName = $post->user->displayName;

            $this->_renameAvatarUserFromPost($post);

            $post->groupName = $post->group->group_name;
            $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $post->group->avatar);
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            $post->isLike = !empty(PostLike::WHERE('user_id', $userId)->WHERE('post_id', $post->id)->first());
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFileForGroup($mediaFile);
            }
        }
        return response()->json($posts, 200);
    }

    public function updatePost(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $post = Post::Where('id', $request->postId)->Where('user_id', $userId)->first();
        if (empty($post)) {
            return response()->json('Yêu cầu không hợp lệ', 403);
        } else {
            $history = new PostHistory();
            $history->post_id = $post->id;
            $history->user_id = $post->user_id;
            $history->post_content = $post->post_content;
            $history->privacy = $post->privacy;
            $history->parent_post = $post->parent_post;
            $history->group_id = $post->group_id;
            $history->feel_activity_id = $post->feel_activity_id;
            $history->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $history->status = 1;
            $history->save();
            if ($request->removeFile) {
                MediaFilePost::WhereIn('id', $request->removeFile)->Where('post_id', $request->postId)->delete();
            }
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $fileExtentsion = $file->getClientOriginalExtension();
                    $random = Str::random(10);
                    $fileName = time() . $random . '.' . $fileExtentsion;
                    if ($request->groupId) {
                        $file->move('media_file_post/', $fileName);
                    } else {
                        $file->move('media_file_post/' . JWTAuth::toUser($request->token)->id, $fileName);
                    }
                    $media = new MediaFilePost();
                    $media->media_file_name = $fileName;
                    $media->media_type = $fileExtentsion;
                    $media->post_id = $post->id;
                    $media->group_id = $request->groupId;
                    $media->post_history_id = $history->id;
                    $media->user_id = $userId;
                    $media->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $media->status = 1;
                    $media->save();
                }
            }

            $post->post_content = $request->contentPost;
            $post->feel_activity_id = $request->faaId;
            $post->privacy = $request->privacy;
            //* xóa tag cũ -> lưu lại tag mới
            $tagged = Tag::Where('post_id', $post->id)->delete();
            if ($request->tags) {
                foreach ($request->tags as $tag) {
                    $newTag = new Tag();
                    $newTag->user_id = $tag;
                    $newTag->post_id = $post->id;
                    $newTag->save();
                }
            }

            $post->update();
            $post->displayName = $post->user->displayName;
            $this->_renameAvatarUserFromPost($post);
            $post->totalMediaFile = $post->mediafile->count();
            $post->totalComment = $post->comment->count();
            $post->totalLike = $post->like->count();
            $post->totalShare = Post::WHERE('parent_post', $post->id)->count();
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, $post->user->id);
            }
            if ($post->icon) {
                $post->iconName = $post->icon->icon_name;
                $post->iconPatch =
                    URL::to('icon/' . $post->icon->patch);
            }
            if ($post->tag) {
                foreach ($post->tag as $tag) {
                    $post->tag = $tag->user->displayName;
                }
            }
            if ($post->parent_post) {
                $post->parent_post = Post::find($post->parent_post);
                $post->parent_post->created_at = Carbon::parse($post->parent_post->created_at)->format('Y/m/d H:m:s');

                $this->_renameAvatarUserFromPost($post->parent_post);

                $post->parent_post->totalMediaFile = $post->parent_post->mediafile->count();
                $post->parent_post->totalComment = $post->parent_post->comment->count();
                if ($post->parent_post->tag) {
                    foreach ($post->parent_post->tag as $tag) {
                        $post->parent_post->tag = $tag;
                    }
                }
                if ($post->parent_post->group_id) {
                    $post->parent_post->groupName = $post->parent_post->group->group_name;
                    $post->parent_post->displayName = $post->user->displayName;
                    $post->parent_post->groupAvatar = $post->parent_post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                        URL::to('media_file_post/' . $post->parent_post->group->avatar);
                    foreach ($post->parent_post->mediafile as $mediaFile) {
                        $this->_renameMediaFileForGroup($mediaFile);
                    }
                } else {
                    $post->parent_post->displayName = $post->parent_post->user->displayName;
                    if ($post->parent_post->icon) {
                        $post->parent_post->iconName = $post->parent_post->icon->icon_name;
                        $post->parent_post->iconPatch =
                            URL::to('icon/' . $post->parent_post->icon->patch);
                    }
                    $post->parent_post->avatarUser = $post->parent_post->user->avatar == null ?
                        ($post->parent_post->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                        URL::to('media_file_post/' . $post->parent_post->user->id . '/' . $post->parent_post->user->avatar);
                    foreach ($post->parent_post->mediafile as $mediaFile) {
                        $this->_renameMediaFile($mediaFile, $post->parent_post->user->id);
                    }
                }
            }
            return response()->json($post, 200);
        }
    }

    public function deletePost(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $post = Post::Where('user_id', $userId)->Where('id', $request->postId)->first();
        if (empty($post)) {
            return response()->json('Không tìm thấy yêu cầu hợp lệ', 404);
        } else {
            $post->delete();
            return response()->json($post, 201);
        }
    }
}

trait PostTrait
{
    //? code bị lặp lại trên 2 lần ? => hãy nghĩ cách tách thành hàm để gọi lại
    //! rút ngắn mà dễ hiểu thì rút ngắn, không thì cứ viết dài ra không sao cả => cho dễ đọc, mainTain sau này

    private function _renameMediaFile(MediaFilePost $mediaFile, int $userId): void
    {
        $isHttp = !empty(parse_url($mediaFile->media_file_name, PHP_URL_SCHEME));
        if (!$isHttp) {
            $mediaFile->media_file_name = URL::to('media_file_post/' . $userId  . '/' . $mediaFile->media_file_name);
        }
    }
    private function _renameMediaFileForGroup(MediaFilePost $mediaFile): void
    {
        $isHttp = !empty(parse_url($mediaFile->media_file_name, PHP_URL_SCHEME));
        if (!$isHttp) {
            $mediaFile->media_file_name = URL::to('media_file_post/' . $mediaFile->media_file_name);
        }
    }

    private function _renameAvatarUserFromPost(Post $post): void //nên return string
    {

        $newImage = "";
        $user = $post->user;
        if ($user->avatar == null) {
            $newImage = ($user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'));
        } else {
            //check if user has avatar is link http
            $isHttp = !empty(parse_url($user->avatar, PHP_URL_SCHEME));
            if ($isHttp) {
                $newImage = $user->avatar;
            } else {
                $newImage = URL::to('media_file_post/' . $user->id . '/' . $user->avatar);
            }
        }

        $post->avatarUser = $newImage; //return $newImage
    }
}
