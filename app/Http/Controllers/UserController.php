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
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$profile->id.'/'.$profile->avatar);
        $profile->coverImage = $profile->cover_image == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$profile->id.'/'.$profile->cover_image);
        return response()->json($profile,200);
    }

    public function editUserInformation(Request $request){
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|between:2,100',
            'lastName' => 'required|string|between:2,100',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = JWTAuth::toUser($request->token)->id;

        $user = User::find($userId);

        $data = $request->all();

        $user->first_name = $data['firstName'];
        $user->last_name = $data['lastName'];
        $user->date_of_birth = $data['dateOfBirth'];
        $user->address = $data['address'];
        $user->update();
        
        return response()->json($user,200);

    }
}