<?php

namespace App\Http\Controllers;

use App\Http\Traits\PostTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\MediaFilePost;
use App\Models\Album;
use App\Models\FriendShip;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use URL;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    use PostTrait;
    public function profileUser($userId, Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        $profile = User::find($userId);
        if (empty($profile)) {
            return response()->json('Không tìm thấy yêu cầu!', 404);
        } else {
            $isFriend = FriendShip::Where('status', 1)->where(function ($query) use ($userCurrent, $profile) {
                $query->where('user_accept', $userCurrent)->where('user_request', $profile->id);
            })->orWhere(function ($query) use ($userCurrent, $profile) {
                $query->where('user_accept', $profile->id)->where('user_request', $userCurrent);
            })->first();
            $profile->renameAvatarUserFromUser();
            $profile->coverImage = $profile->cover_image == null ?
                URL::to('default/cover_image_default.jpeg') :
                URL::to('media_file_post/' . $profile->id . '/' . $profile->cover_image);
            $profile->isFriend = !empty($isFriend);
            return response()->json($profile, 200);
        }
    }

    public function updateDisplayName(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        $userCurrent = User::find($userId);
        if (empty($userCurrent)) {
            return response()->json('Không tìm thấy người dùng hợp lệ!', 404);
        } else {
            $userCurrent->displayName = $request->displayName;
            $userCurrent->update();
            $userCurrent->avatar = $userCurrent->avatar == null ?
                ($userCurrent->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
                :
                URL::to('media_file_post/' . $userCurrent->id . '/' . $userCurrent->avatar);
            $userCurrent->coverImage = $userCurrent->cover_image == null ?
                URL::to('default/cover_image_default.jpeg') :
                URL::to('media_file_post/' . $userCurrent->id . '/' . $userCurrent->cover_image);
            return response()->json($userCurrent, 200);
        }
    }
    public function updatePhone(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        $userCurrent = User::find($userId);
        if (empty($userCurrent)) {
            return response()->json('Không tìm thấy người dùng hợp lệ!', 404);
        } else {
            $userCurrent->phone = $request->phone;
            $userCurrent->update();
            $userCurrent->avatar = $userCurrent->avatar == null ?
                ($userCurrent->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
                :
                URL::to('media_file_post/' . $userCurrent->id . '/' . $userCurrent->avatar);
            $userCurrent->coverImage = $userCurrent->cover_image == null ?
                URL::to('default/cover_image_default.jpeg') :
                URL::to('media_file_post/' . $userCurrent->id . '/' . $userCurrent->cover_image);
            return response()->json($userCurrent, 200);
        }
    }

    public function updatePasswordUser(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $user = User::find($userId);

        if (empty($user)) {
            return response()->json('Không tìm thấy người dùng hợp lệ!', 404);
        } else {
            $validator = Validator::make($request->all(), [
                'currentPassword' => 'required',
                'password' => 'required|string|min:6',
                'confirmPassword' => 'required|string|min:6|same:password',
            ], [
                'currentPassword.required' => 'Mật khẩu không được bỏ trống!',
                'password.required' => 'Mật khẩu không được bỏ trống!',
                'password.min' => 'Mật khẩu phải nhiều hơn 6 ký tự!',
                'password.same' => 'Xác nhận mật khẩu và mật khẩu không khớp'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            } else {
                if (Hash::check($request->currentPassword, $user->password)) {
                    $user->password = bcrypt($request->password);
                    $user->update();
                    return response()->json('Thay đổi mật khẩu thành công!', 200);
                } else {
                    return response()->json('Mật khẩu cũ không đúng!', 400);
                }
            }
        }
    }

    public function editUserInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'firstName' => 'required|string|between:2,100',
            // 'lastName' => 'required|string|between:2,100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = JWTAuth::toUser($request->token)->id;

        $user = User::find($userId);

        $data = $request->all();

        $user->live_in = $data['liveIn'];
        $user->went_to = $data['wentTo'];
        $user->relationship = $data['relationship'];
        $user->phone = $data['phone'];
        $user->update();
        $user->avatar = $user->avatar == null ?
            ($user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
            :
            URL::to('media_file_post/' . $user->id . '/' . $user->avatar);
        $user->coverImage = $user->cover_image == null ?
            URL::to('default/cover_image_default.jpeg') :
            URL::to('media_file_post/' . $user->id . '/' . $user->cover_image);

        return response()->json($user, 200);
    }


    public function fetchlistImageUploaded($userId)
    {
        $lst = DB::table('media_file_posts')
            ->select('*')
            ->where('user_id', '=', $userId)
            ->Where(function ($query) {
                $query->where('media_type', '=', 'png')
                    ->orWhere('media_type', '=', 'jpg')
                    ->orWhere('media_type', '=', 'jpeg');
            })->get();

        foreach ($lst as $item) {
            $item->media_file_name = URL::to('media_file_post/' . $userId . '/' . $item->media_file_name);
        }
        return response()->json($lst, 200);
    }

    public function uploadAvatar(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        if ($request->hasFile('file')) {
            $file = $request->file[0];
            $fileExtentsion = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $fileName = time() . $random . '.' . $fileExtentsion;
            $file->move('media_file_post/' . JWTAuth::toUser($request->token)->id, $fileName);

            $update = User::find($userId);
            $update->avatar = $fileName;
            $update->update();

            $crPost = new Post();
            $crPost->user_id = $userId;
            $crPost->post_content = 'Đã cập nhật ảnh đại diện.';
            $crPost->privacy = 1;
            $crPost->parent_post = null;
            $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $crPost->status = 1;
            $crPost->save();
            $this->_createNotification($crPost);

            $checkAlbum = MediaFilePost::WHERE('user_id', $userId)->WHERE('isAvatar', 1)->first();
            if (!empty($checkAlbum)) {
                $upload = new MediaFilePost();
                $upload->media_file_name = $fileName;
                $upload->media_type = $fileExtentsion;
                $upload->post_id = $crPost->id;
                $upload->user_id = $userId;
                $upload->isAvatar = 1;
                $upload->status = 1;
                $upload->album_id = $checkAlbum->album_id;
                $upload->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $upload->save();
            } else {
                $newAlbum = new Album();
                $newAlbum->album_name = 'Ảnh đại diện';
                $newAlbum->user_id = $userId;
                $newAlbum->privacy = 1;
                $newAlbum->isDefault = 1;
                $newAlbum->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $newAlbum->save();

                $upload = new MediaFilePost();
                $upload->media_file_name = $fileName;
                $upload->media_type = $fileExtentsion;
                $upload->post_id = $crPost->id;
                $upload->user_id = $userId;
                $upload->isAvatar = 1;
                $upload->status = 1;
                $upload->album_id = $newAlbum->id;
                $upload->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $upload->save();
            }

            $update->avatar = $update->avatar == null ?
                ($update->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
                :
                URL::to('media_file_post/' . $update->id . '/' . $update->avatar);
            $update->coverImage = $update->cover_image == null ?
                URL::to('default/cover_image_default.jpeg') :
                URL::to('media_file_post/' . $update->id . '/' . $update->cover_image);
            return response()->json($update, 200);
        }
    }

    public function uploadCoverImage(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        if ($request->hasFile('file')) {
            $file = $request->file[0];
            $fileExtentsion = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $fileName = time() . $random . '.' . $fileExtentsion;
            $file->move('media_file_post/' . JWTAuth::toUser($request->token)->id, $fileName);

            $update = User::find($userId);
            $update->cover_image = $fileName;
            $update->update();

            $crPost = new Post();
            $crPost->user_id = $userId;
            $crPost->post_content = 'Đã cập nhật ảnh bìa.';
            $crPost->privacy = 1;
            $crPost->parent_post = null;
            $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $crPost->status = 1;
            $crPost->save();
            $this->_createNotification($crPost);

            $checkAlbum = MediaFilePost::WHERE('user_id', $userId)->WHERE('isCover', 1)->first();
            if (!empty($checkAlbum)) {
                $upload = new MediaFilePost();
                $upload->media_file_name = $fileName;
                $upload->media_type = $fileExtentsion;
                $upload->post_id = $crPost->id;
                $upload->user_id = $userId;
                $upload->isCover = 1;
                $upload->status = 1;
                $upload->album_id = $checkAlbum->album_id;
                $upload->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $upload->save();
            } else {
                $newAlbum = new Album();
                $newAlbum->album_name = 'Ảnh bìa';
                $newAlbum->user_id = $userId;
                $newAlbum->privacy = 1;
                $newAlbum->isDefault = 1;
                $newAlbum->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $newAlbum->save();

                $upload = new MediaFilePost();
                $upload->media_file_name = $fileName;
                $upload->media_type = $fileExtentsion;
                $upload->post_id = $crPost->id;
                $upload->user_id = $userId;
                $upload->isCover = 1;
                $upload->status = 1;
                $upload->album_id = $newAlbum->id;
                $upload->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $upload->save();
            }
            $update->avatar = $update->avatar == null ?
                ($update->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
                :
                URL::to('media_file_post/' . $update->id . '/' . $update->avatar);
            $update->coverImage = $update->cover_image == null ?
                URL::to('default/cover_image_default.jpeg') :
                URL::to('media_file_post/' . $update->id . '/' . $update->cover_image);
            return response()->json($update, 200);
        }
    }

    public function saveDeviceToken(Request $request)
    {
        //validate deviceToken
        $validator = Validator::make($request->all(), [
            'deviceToken' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = JWTAuth::toUser($request->token);
        $user->update([
            'device_token' => $request->deviceToken,
        ]);
        return response()->json($user);
    }
}
