<?php

namespace App\Http\Traits;

use App\Models\Post;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\FriendShip;

trait PostTrait
{
    //? code bị lặp lại trên 2 lần ? => hãy nghĩ cách tách thành hàm để gọi lại
    //! rút ngắn mà dễ hiểu thì rút ngắn, không thì cứ viết dài ra không sao cả => cho dễ đọc, mainTain sau này

    private function _renameMediaFile(object &$objectRename, string $namePath, int $userId = null): void
    {
        $isHttp = !empty(parse_url($objectRename[$namePath], PHP_URL_SCHEME));
        if (!$isHttp) {
            if ($userId == null)
                $objectRename[$namePath] = URL::to('media_file_post/' . $objectRename[$namePath]);
            else
                $objectRename[$namePath] = URL::to('media_file_post/' . $userId  . '/' . $objectRename[$namePath]);
        }
    }

    private function _renameAvatarUserFromPost(Post $post): void //nên return string
    {
        $user = $post->user;
        $user->renameAvatarUserFromUser();

        $post->avatarUser = $user->avatar;
    }

    private function _selectParentPost($post): void
    {
        $post->created_at = Carbon::parse($post->created_at)->format('Y/m/d H:m:s');

        $post->totalMediaFile = $post->mediafile->count();
        $post->totalComment = $post->comment->count();
        if ($post->tag) {
            foreach ($post->tag as $tag) {
                $post->tag = $tag;
            }
        }
        if ($post->group_id) {
            $post->groupName = $post->group->group_name;
            $post->displayName = $post->user->displayName;
            $post->groupAvatar = $post->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $post->group->avatar);
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, 'media_file_name');
            }
        } else {
            $post->displayName = $post->user->displayName;
            if ($post->icon) {
                $post->iconName = $post->icon->icon_name;
                $post->iconPatch =
                    URL::to('icon/' . $post->icon->patch);
            }
            $this->_renameAvatarUserFromPost($post);
            foreach ($post->mediafile as $mediaFile) {
                $this->_renameMediaFile($mediaFile, 'media_file_name', $post->user->id);
            }
        }
    }
    private function _createNotification(Post $post): void
    {
        $data = [];
        $lstFriend = FriendShip::select('*')
            ->where('status', 1)
            ->Where(function ($query) use ($post) {
                $query->where('user_request', $post->user_id)
                    ->orWhere('user_accept', $post->user_id);
            })->get();
        foreach ($lstFriend as $friend) {
            if ($friend->user_accept == $post->user_id) {
                $data[] = $friend->user_request;
            } else {
                $data[] = $friend->user_accept;
            }
        }
        if ($data) {
            foreach ($data as $user) {
                $new = new Notification();
                $new->from = $post->user_id;
                $new->to = $user;
                $new->title = 'đã đăng một bài viết mới.';
                $new->unread = 1;
                $new->object_type = 'crPost';
                $new->object_id = $post->id;
                $new->icon_url = 'icon.png';
                $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $new->save();
            }
        }
    }
}
