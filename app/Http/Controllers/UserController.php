<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
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
                            ($profile->sex === 0 ? URL::to('default/avatar_default_female.png') :URL::to('default/avatar_default_male.png'))
                            :
                            URL::to('user/person/'.$profile->id.'/'.$profile->avatar);
        $profile->coverImage = $profile->cover_image == null ? 
                            URL::to('default/cover_image_default.jpeg'):
                            URL::to('user/person/'.$profile->id.'/'.$profile->cover_image);
        
        return response()->json($profile,200);
    }

    public function editUserInformation(Request $request){
        $validator = Validator::make($request->all(), [
            // 'firstName' => 'required|string|between:2,100',
            // 'lastName' => 'required|string|between:2,100',
        ]);
        
        if($validator->fails()){
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
        $user->username = $user->first_name.' '.$user->last_name;
        $user->avatar = $user->avatar == null ? 
                            ($user->sex === 0 ? URL::to('default/avatar_default_female.png') :URL::to('default/avatar_default_male.png'))
                            :
                            URL::to('user/person/'.$user->id.'/'.$user->avatar);
        $user->coverImage = $user->cover_image == null ? 
                            URL::to('default/cover_image_default.jpeg'):
                            URL::to('user/person/'.$user->id.'/'.$user->cover_image);
        
        return response()->json($user,200);

    }
}