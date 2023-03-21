<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use URL;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function profileUser(Request $request){
        $profile = User::find($request->userId);
        $profile->username = $profile->first_name.' '.$profile->last_name;
        $profile->avatar = $profile->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$profile->id.'/'.$profile->avatar);
        return response()->json($profile,200);
    }
}