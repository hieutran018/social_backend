<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
}
