<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaFilePost;
use App\Models\Group;
use DB;
use URL;
use Carbon\Carbon;
use App\Http\Traits\PostTrait;

class MediaFileController extends Controller
{
    use PostTrait;

    public function photoByUploaded($userId, $limit = null)
    {

        if ($limit != null) {
            $lst = DB::table('media_file_posts')
                ->select('*')
                ->where('user_id', '=', $userId)
                ->where('group_id', null)
                ->Where(function ($query) {
                    $query->where('media_type', '=', 'png')
                        ->orWhere('media_type', '=', 'jpg')
                        ->orWhere('media_type', '=', 'jpeg');
                })->orderBy('created_at', 'DESC')->limit(6)->get();
        } else {
            $lst = DB::table('media_file_posts')
                ->select('*')
                ->where('user_id', '=', $userId)
                ->where('group_id', null)
                ->Where(function ($query) {
                    $query->where('media_type', '=', 'png')
                        ->orWhere('media_type', '=', 'jpg')
                        ->orWhere('media_type', '=', 'jpeg');
                })->orderBy('created_at', 'DESC')->get();
        }
        foreach ($lst as $item) {
            $item = collect($item);
            $this->_renameMediaFile($item, 'media_file_name', $userId);
        }
        return response()->json($lst, 200);
    }

    public function fetchMediaFileVieo(Request $request, $limit = null)
    {
        if ($limit != null) {
            $lst = MediaFilePost::WHERE('media_type', 'mp4')->limit($limit)->get();
        } else {
            $lst = MediaFilePost::WHERE('media_type', 'mp4')->get();
        }
        foreach ($lst as $item) {
            $item->created_at = Carbon::parse($item->created_at)->format('Y/m/d H:m:s');
            $item->media_file_name = URL::to('media_file_post/' . $item->user_id . '/' . $item->media_file_name);
            $item->displayName = $item->user->displayName;
            $item->avatarUser = $item->user->avatar == null ?
                ($item->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                URL::to('media_file_post/' . $item->user->id . '/' . $item->user->avatar);
        }

        return response()->json($lst, 200);
    }

    public function fetchGroupPhotoList($groupId, $limit = null)
    {
        $isGroup = Group::find($groupId);
        if (empty($isGroup)) {
            return response()->json('Yêu cầu không hợp lệ!', 404);
        } else {
            if ($limit == null) {
                $mediaFiles = MediaFilePost::WHERE('group_id', $isGroup->id)->get();
                foreach ($mediaFiles as $file) {
                    $file->media_file_name = URL::to('media_file_post/' . $file->media_file_name);
                }
            } else {
                $mediaFiles = MediaFilePost::WHERE('group_id', $isGroup->id)->limit($limit)->get();
                foreach ($mediaFiles as $file) {
                    $file->media_file_name = URL::to('media_file_post/' . $file->media_file_name);
                }
            }

            return response()->json($mediaFiles, 200);
        }
    }
}
