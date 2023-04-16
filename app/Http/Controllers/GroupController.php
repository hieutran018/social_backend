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

    public function fetchGroupById($groupId){
        $group = Group::WHERE('id',$groupId)->first();

        if(empty($group)){
            return response()->json('Không tìm thấy group yêu cầu!',404);
        }
        else{
            $group->avatar = $group->avatar === null ? URL::to('default/avatar_group_default.jpg') : 
                URL::to('media_file_post/'.$group->avatar);
                return response()->json($group,200);
        }

    }

    public function sendInviteFriendToGroup(Request $request){
        $invite = new MemberGroup();
        $invite->user_id = $request->userId;
        $invite->group_id = $request->groupId;
        $invite->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $invite->status = 2;
        $invite->isAdminGroup = 0;
        $invite->save();
        return response()->json('Gửi lời mời thành công!',200);
        
    }

    public function editGroupByAdmin(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;

        $check = MemberGroup::Where('user_id',$userId)->Where('group_id',$request->groupId)->first();

        if(!empty($check) && $check->isAdminGroup === 1){
            $edit = Group::WHERE('id',$request->groupId)->first();
            $edit->group_name = $request->groupName === null ? $edit->group_name : $request->groupName;
            $edit->privacy = $request->privacy === null ? $edit->privacy : $request->privacy;
            $edit->update();
            $edit->avatar = $edit->avatar === null ? URL::to('default/avatar_group_default.jpg') : 
                URL::to('media_file_post/'.$edit->avatar);
                return response()->json($edit,200);
        }else{
            return response()->json('Yêu cầu không hợp lệ!',400);
        }
    }
}