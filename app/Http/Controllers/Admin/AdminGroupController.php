<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\MediaFilePost;
use App\Models\MemberGroup;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AdminGroupController extends Controller
{
    public function fetchListGroup()
    {
        $groups = Group::get();
        foreach ($groups as $group) {
            $group->privacy = $group->privacy === 0 ? 'Nhóm riêng tư' : 'Nhóm công khai';
            $group->owner = MemberGroup::WHERE('group_id', $group->id)->WHERE('isAdminGroup', 1)->get();
            $group->members = MemberGroup::count();
            foreach ($group->owner as $owner) {
                $group->owner =  $owner->user->displayName;
            }
        }
        return response()->json($groups, 200);
    }

    public function fetchDetailGroup($groupId)
    {
        $group = Group::Where('id', $groupId)->first();
        $group->avatar = $group->avatar == null ? URL::to('default/avatar_group_default.jpg') : URL::to('media_file_post/' . $group->avatar);
        $group->postCount = Post::Where('group_id', $groupId)->count();
        $group->mediaFile = MediaFilePost::Where('group_id', $groupId)->count();
        $admin = MemberGroup::Where('group_id', $groupId)->Where('isAdminGroup', 1)->first();
        $group->admin = $admin->user->displayName;
        $group->members = MemberGroup::Where('group_id', $groupId)->count();
        $group->privacy = $group->privacy === 0 ? 'Nhóm riêng tư' : 'Nhóm công khai';
        $group->created_at = Carbon::parse($group->created_at)->format('d/m/Y');
        return response()->json($group, 200);
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
}
