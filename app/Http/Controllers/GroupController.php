<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\MemberGroup;
use URL;
use Carbon\Carbon;
use JWTAuth;

class GroupController extends Controller
{
    public function createGroup(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;
        $newGroup = new Group();

        $newGroup->group_name = $request->groupName;
        $newGroup->privacy = $request->privacy;
        $newGroup->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        
        $newGroup->save();

        $adminGroup = new MemberGroup();
        $adminGroup->user_id = $userId;
        $adminGroup->group_id = $newGroup->id;
        $adminGroup->isAdminGroup = 1;
        $adminGroup->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $adminGroup->save();
        return response()->json('success',200);

    }

    public function fetchGroupJoined(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;
        $lstGroup = User::WHERE('id',$userId)->get();
        foreach($lstGroup as $user){
            foreach($user->groups as $gr){
                $gr->avatar = $gr->avatar === null ? URL::to('default/avatar_group_default.jpg') : 
                URL::to('media_file_post/'.$gr->avatar);
            }
           
        }
        
        return response()->json($lstGroup,200);
    }
}