<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  //TODO: SAU KHI CÓ DỮ LIỆU THAY BẰNG MODEL FRIENDSHIP
use URL;
use JWTAuth;

class FriendShipController extends Controller
{
    //TODO: SAU KHI CÓ DỮ LIỆU THÊM ID CỦA NGƯỜI HIỆN TẠI
    public function fetchFriendSuggestion(Request $request){
        $frs = User::WHERE('id','!=',JWTAuth::toUser($request->token)->id)->get();
       
        foreach($frs as $user){
            $user->username = $user->first_name.''.$user->last_name;
            $user->avatar = $user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$user->id.'/'.$user->avatar);
        }
        return response()->json($frs,200);
    }
}