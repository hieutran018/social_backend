<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostHistory;
use URL;

class PostHistoryController extends Controller
{
    use PostHistoryTrait;
    public function fetchPostHistoryByIdPost($idPost)
    {
        $histories = PostHistory::Where('post_id', $idPost)->get();
        foreach ($histories as $history) {
            $this->_renameAvatarUserFromPost($history);
            $history->displayName = $history->user->displayName;
        }
        return response()->json($histories, 200);
    }
}

trait PostHistoryTrait
{
    private function _renameAvatarUserFromPost(PostHistory $post): void //nên return string
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
