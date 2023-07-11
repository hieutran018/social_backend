<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FriendShip;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use URL;

class AdminUserController extends Controller
{
    public function fetchListUser()
    {
        $users = User::select('id', 'displayName', 'email', 'date_of_birth', 'sex', 'phone', 'address')
            ->Where('isAdmin', 0)->get();
        foreach ($users as $user) {
            $user->avatar = URL::to('media_file_post/' . $user->id  . '/' . $user->avatar);
            $user->sex = $user->sex === null ? 'Chưa cập nhật' : ($user->sex === 0 ? 'Nam' : 'Nữ');
            $user->phone = $user->phone === null ? 'Chưa cập nhật' : $user->phone;
        }
        return response()->json($users, 200);
    }

    public function getchDetailUser($userId)
    {
        $user = User::Where('id', $userId)->first();
        $user->friend = FriendShip::Where('status', 1)->Where(function ($query) use ($userId) {
            $query->Where('user_accept', $userId)->orWhere('user_request', $userId)->get();
        })->count();
        $user->sex = $user->sex == 0 ? 'Nữ' : 'Nam';
        $user->avatar = $user->avatar == null ?
            ($user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png'))
            :
            URL::to('media_file_post/' . $user->id . '/' . $user->avatar);
        $user->created_at = Carbon::parse($user->created_at)->toDateTimeString();
        return response()->json($user, 200);
    }
}
