<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendShip; //TODO: SAU KHI CÓ DỮ LIỆU THAY BẰNG MODEL FRIENDSHIP
use App\Models\MemberGroup;
use URL;
use JWTAuth;
use Carbon\Carbon;
use DB;

class FriendShipController extends Controller
{
    //TODO: SAU KHI CÓ DỮ LIỆU THÊM ID CỦA NGƯỜI HIỆN TẠI
    public function fetchFriendSuggestion(Request $request)
    {
        $frs = User::WHERE('id', '!=', JWTAuth::toUser($request->token)->id)->get();

        foreach ($frs as $user) {
            $user->displayName = $user->displayName;
            $user->renameAvatarUserFromUser();
        }
        return response()->json($frs, 200);
    }

    public function fetchListFriendByUser($userId, $limit = null)
    {

        if ($limit != null) {
            $lstFriend = FriendShip::WHERE('status', 1)->WHERE('user_accept', $userId)->orWhere('user_request', $userId)->orderBy('created_at', 'DESC')->limit(6)->get();
            // $lstFriend = DB::table('list_friend')
            //     ->select('*')
            //     ->where('status','=','1')
            //     ->Where(function($query){
            //             $query->where('user_accept','=',$userId)
            //             ->orWhere('user_request','=',$userId);
            //     })->orderBy('created_at','DESC')->limit(6)->get();

            foreach ($lstFriend as $fr) {
                if ($fr->user_accept == $userId) {
                    foreach ($fr->user as $user) {
                        $fr->friendId = $user->id;
                        $fr->displayName = $user->displayName;
                        $user->renameAvatarUserFromUser();
                        $fr->avatar = $user->avatar;
                    }
                } else {
                    foreach ($fr->users as $user) {
                        $fr->friendId = $user->id;
                        $fr->displayName = $user->fdisplayName;
                        $user->renameAvatarUserFromUser();
                        $fr->avatar = $user->avatar;
                    }
                }
            }
        } else {
            $lstFriend = FriendShip::WHERE('status', 1)->WHERE('user_accept', $userId)->orWhere('user_request', $userId)->orderBy('created_at', 'DESC')->paginate(10);

            foreach ($lstFriend as $fr) {
                if ($fr->user_accept == $userId) {
                    foreach ($fr->user as $user) {
                        $fr->friendId = $user->id;
                        $fr->displayName = $user->displayName;
                        $user->renameAvatarUserFromUser();
                        $fr->avatar = $user->avatar;
                    }
                } else {
                    foreach ($fr->users as $user) {
                        $fr->friendId = $user->id;
                        $fr->displayName = $user->displayName;
                        $user->renameAvatarUserFromUser();
                        $fr->avatar = $user->avatar;
                    }
                }
            }
        }

        return response()->json($lstFriend, 200);
    }

    public function requestAddFriend(Request $request)
    {
        $userIdRequest = JWTAuth::toUser($request->token)->id;

        $invite = new FriendShip();

        $invite->user_request = $userIdRequest;
        $invite->user_accept = $request->userIdAccept;
        $invite->status = 0;
        $invite->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $invite->save();
        return response()->json('success', 200);
    }

    public function fetchFriendRequestList(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $requestList = FriendShip::WHERE('user_accept', $userId)->WHERE('status', 0)->get();

        foreach ($requestList as $fr) {
            foreach ($fr->user as $user) {
                $fr->displayName = $user->displayName;
                $user->renameAvatarUserFromUser();
                $fr->avatar = $user->avatar;
                $fr->cover_image = $user->cover_image == null ? URL::to('default/cover_image_default.jpeg') : URL::to('user/person/' . $user->id . '/' . $user->cover_image);
            }
        }
        return response()->json($requestList, 200);
    }

    public function acceptFriendRequest(Request $request)
    {
        $userIdAccept = JWTAuth::toUser($request->token)->id;
        $userIdRequest = $request->userIdRequest;

        $invite = FriendShip::WHERE('user_accept', $userIdAccept)->WHERE('user_request', $userIdRequest)->first();

        $invite->status = 1;
        $invite->update();
        return response()->json('success', 200);
    }

    public function unFriend(Request $request)
    {
        $userIdUnfr = JWTAuth::toUser($request->token)->id;
        $search1 = FriendShip::WHERE('user_request', $userIdUnfr)->WHERE('user_accept', $request->userId)->first();

        if ($search1) {
            $search1->delete();
        } else {

            $search1 = FriendShip::WHERE('user_request', $request->userId)->WHERE('user_accept', $userIdUnfr)->first();

            $search1->delete();
        }


        return response()->json('success', 200);
    }

    public function cancelAddFriend(Request $request)
    {
        $userIdUnfr = JWTAuth::toUser($request->token)->id;
        $search1 = FriendShip::WHERE('user_request', $userIdUnfr)->WHERE('user_accept', $request->userId)->first();

        if ($search1) {
            $search1->delete();
        }
        return response()->json('success', 200);
    }

    public function fetchFriendToInviteGroup(Request $request, $groupId)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $lstMember = MemberGroup::WHERE('group_id', $groupId)->get();
        foreach ($lstMember as $member) {
            $data[] = $member->user_id;
        }
        $lstFriend = FriendShip::select('*')
            ->where('status', 1)
            ->Where(function ($query) use ($userId) {
                $query->where('user_request', $userId)
                    ->orWhere('user_accept', $userId);
            })->Where(function ($query) use ($data) {
                $query->whereNotIn('user_request', $data)
                    ->orWhereNotIn('user_accept', $data);
            })->get();

        foreach ($lstFriend as $fr) {
            if ($fr->user_accept == $userId) {
                foreach ($fr->user as $user) {
                    $fr->friendId = $user->id;
                    $fr->displayName = $user->displayName;
                    $user->renameAvatarUserFromUser();
                    $fr->avatar = $user->avatar;
                }
            } else {
                foreach ($fr->users as $users) {
                    $fr->friendId = $users->id;
                    $fr->displayName = $users->displayName;
                    $user->renameAvatarUserFromUser();
                    $fr->avatar = $users->avatar;
                }
            }
        }
        return response()->json($lstFriend, 200);
    }
}
