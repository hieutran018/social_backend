<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\MemberGroup;

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
        $group->postCount = Post::Where('group_id', $groupId)->count();
        $group->adin = MemberGroup::Where('group_id', $groupId)->Where('isAdminGroup', 1)->first();
        return response()->json($group, 200);
    }
}
