<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostHistory;
use App\Models\MediaFilePost;
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
            //? Chưa lấy ra được lịch sử có kèm danh sách files theo từng chỉnh sửa
            //* BÀI VIẾT (text:expample, files:[file1,file2])
            //* CHỈNH SỬA (text:expample1, files:[file1,file2])
            //TODO LỊCH SỬ (text:expample1,files:[file1,file2])
            //! LỊCH SỬ(text:expample1,files:[])
            foreach ($history->mediafile as $file) {
                $this->_renameMediaFile($file, $file->user_id);
            }
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
    private function _renameMediaFile(MediaFilePost $mediaFile, int $userId): void
    {
        $isHttp = !empty(parse_url($mediaFile->media_file_name, PHP_URL_SCHEME));
        if (!$isHttp) {
            $mediaFile->media_file_name = URL::to('media_file_post/' . $userId  . '/' . $mediaFile->media_file_name);
        }
    }
}
