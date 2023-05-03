<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\MemberGroup;
use App\Models\Post;
use App\Models\MediaFilePost;
use URL;
use Carbon\Carbon;
use JWTAuth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function createGroup(Request $request)
    {
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
        $adminGroup->status = 1;
        $adminGroup->save();

        $post = new Post();
        $post->user_id = $userId;
        $post->post_content = 'Đã tạo nhóm.';
        $post->privacy = $request->privacy;
        $post->parent_post = null;
        $post->group_id = $newGroup->id;
        $post->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $post->status = 1;
        $post->save();

        $newGroup->avatar = URL::to('default/avatar_group_default.jpg');
        return response()->json($newGroup, 200);
    }

    public function fetchGroupJoined(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $lstGroup = User::WHERE('id', $userId)->get();
        foreach ($lstGroup as $user) {
            foreach ($user->groups as $gr) {
                $gr->avatar = $gr->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                    URL::to('media_file_post/' . $gr->avatar);
            }
        }

        return response()->json($lstGroup, 200);
    }

    public function fetchGroupById(Request $request, $groupId)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $group = Group::WHERE('id', $groupId)->first();

        if (empty($group)) {
            return response()->json('Không tìm thấy group yêu cầu!', 404);
        } else {
            $idAdmin = MemberGroup::WHERE('user_id', $userId)->WHERE('group_id', $group->id)->WHERE('isAdminGroup', 1)->first();
            $group->isAdminGroup = !empty($idAdmin);
            $group->avatar = $group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $group->avatar);
            return response()->json($group, 200);
        }
    }

    public function sendInviteFriendToGroup(Request $request)
    {
        $invite = new MemberGroup();
        $invite->user_id = $request->userId;
        $invite->group_id = $request->groupId;
        $invite->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $invite->status = 2;
        $invite->isAdminGroup = 0;
        $invite->save();
        return response()->json('Gửi lời mời thành công!', 200);
    }

    public function cancelSendInvite(Request $request)
    {
        $cancel = MemberGroup::WHERE('user_id', $request->userId)->WHERE('group_id', $request->groupId)->first();
        if (empty($cancel)) {
            return response()->json('Yêu cầu không hợp lệ!', 404);
        } else {
            $cancel->delete();
            return response()->json('Hoàn tác thành công!', 200);
        }
    }

    public function acceptInviteGroup(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $accept = MemberGroup::WHERE('user_id', $userId)->WHERE('group_id', $request->groupId)->WHERE('status', 2)->first();
        if (empty($accept)) {
            return response()->json('Có lỗi xảy ra', 400);
        } else {
            $accept->status = 1;
            $accept->update();
            return response()->json('Bạn đã chấp nhận lời mời nhóm!', 200);
        }
    }

    public function fetchInviteToGroup(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        $listGroup = MemberGroup::WHERE('user_id', $userId)->WHERE('status', 2)->get();
        foreach ($listGroup as $gr) {
            $gr->groupId = $gr->group->id;
            $gr->groupName = $gr->group->group_name;
            $gr->avatarGroup = $gr->group->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $gr->group->avatar);
        }
        return response()->json($listGroup, 200);
    }

    public function editGroupByAdmin(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        $check = MemberGroup::Where('user_id', $userId)->Where('group_id', $request->groupId)->first();

        if (!empty($check) && $check->isAdminGroup === 1) {
            $edit = Group::WHERE('id', $request->groupId)->first();
            $edit->group_name = $request->groupName === null ? $edit->group_name : $request->groupName;
            $edit->privacy = $request->privacy === null ? $edit->privacy : $request->privacy;

            if ($request->hasFile('file')) {
                $file = $request->file;
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move('media_file_post/', $fileName);
                $edit->avatar = $fileName;

                $crPost = new Post();
                $crPost->user_id = JWTAuth::toUser($request->token)->id;
                $crPost->post_content = 'Đã cập nhật ảnh của nhóm.';
                $crPost->privacy = $request->privacy;
                $crPost->parent_post = null;
                $crPost->group_id = $edit->id;
                $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $crPost->status = 1;
                $crPost->save();
                $media = new MediaFilePost();
                $media->media_file_name = $fileName;
                $media->media_type = $fileExtentsion;
                $media->post_id = $crPost->id;
                $media->group_id = $edit->id;
                $media->user_id = JWTAuth::toUser($request->token)->id;
                $media->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $media->status = 1;
                $media->save();
            }

            $edit->update();
            $edit->avatar = $edit->avatar === null ? URL::to('default/avatar_group_default.jpg') :
                URL::to('media_file_post/' . $edit->avatar);
            return response()->json($edit, 200);
        } else {
            return response()->json('Yêu cầu không hợp lệ!', 400);
        }
    }

    public function fetchMemberGroup($groupId)
    {
        $isGroup = Group::WHERE('id', $groupId)->first();
        if (empty($isGroup)) {
            return response()->json('Không tìm thấy nhóm yêu cầu!', 404);
        } else {
            $members = MemberGroup::WHERE('group_id', $isGroup->id)->WHERE('status', 1)->get();
            foreach ($members as $member) {
                $member->user->renameAvatarUserFromUser();
                $member->displayName = $member->user->displayName;
                $member->avatar = $member->user->avatar;
            }
            return response()->json($members, 200);
        }
    }

    public function addMemberToAdmin(Request $request)
    {
        $currentAdmin = JWTAuth::toUser($request->token)->id;

        $isGroup = Group::WHERE('id', $request->groupId)->first();
        if (empty($isGroup)) {
            return response()->json('Yêu cầu không hợp lệ', 400);
        } else {
            $isAdmin = MemberGroup::WHERE('user_id', $currentAdmin)->WHERE('group_id', $isGroup->id)->first();
            if (empty($isAdmin)) {
                return response()->json('Yêu cầu không hợp lệ', 400);
            } else {
                $update = MemberGroup::WHERE('user_id', $request->userId)->WHERE('group_id', $isGroup->id)->first();
                // $update->isAdminGroup = 1;
                $update->isAccept = 1;
                $update->update();

                $update->displayName = $update->user->displayName;
                $update->user->renameAvatarUserFromUser();
                $update->avatar = $update->user->avatar;
                return response()->json($update, 200);
            }
        }
    }

    public function removeAdminToGroup(Request $request)
    {
        $currentAdmin = JWTAuth::toUser($request->token)->id;

        $isGroup = Group::WHERE('id', $request->groupId)->first();
        if (empty($isGroup)) {
            return response()->json('Yêu cầu không hợp lệ', 400);
        } else {
            $isAdmin = MemberGroup::WHERE('user_id', $currentAdmin)->WHERE('group_id', $isGroup->id)->first();
            if (empty($isAdmin)) {
                return response()->json('Yêu cầu không hợp lệ', 400);
            } else {
                $update = MemberGroup::WHERE('user_id', $request->userId)->WHERE('group_id', $isGroup->id)->first();
                $update->isAdminGroup = 0;
                $update->update();

                $update->displayName = $update->user->displayName;
                $update->user->renameAvatarUserFromUser();
                $update->avatar = $update->user->avatar;

                return response()->json($update, 200);
            }
        }
    }


    public function removeMemberFromGroup(Request $request)
    {
        $currentAdmin = JWTAuth::toUser($request->token)->id;

        $isGroup = Group::WHERE('id', $request->groupId)->first();
        if (empty($isGroup)) {
            return response()->json('Yêu cầu không hợp lệ', 400);
        } else {
            $isAdmin = MemberGroup::WHERE('user_id', $currentAdmin)->WHERE('group_id', $isGroup->id)->first();
            if (empty($isAdmin)) {
                return response()->json('Yêu cầu không hợp lệ', 400);
            } else {
                $member = MemberGroup::WHERE('user_id', $request->userId)->WHERE('group_id', $isGroup->id)->first();
                $member->delete();
                return response()->json('Xóa thành viên thành công!', 200);
            }
        }
    }
}