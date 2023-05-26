<?php

namespace App\Http\Traits;

use App\Models\Post;
use Illuminate\Support\Facades\URL;

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
}
