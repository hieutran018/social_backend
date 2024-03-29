<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendShip;
use App\Models\MemberGroup;
use App\Models\Notification;
use URL;
use JWTAuth;
use Carbon\Carbon;


class FriendShipController extends Controller
{
    use FriendTrait;

    public function fetchFriendSuggestion(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $data[] = $userId;
        $friends = FriendShip::Where('status', 1)->orWhere('status', 0)->where(function ($query) use ($userId) {
            $query->where('user_accept', $userId)->orWhere('user_request', $userId)->get();
        })->get();

        foreach ($friends as $friend) {
            if ($friend->user_accept === $userId) {
                $data[] = $friend->user_request;
            } else {
                $data[] = $friend->user_accept;
            }
        }
        $frs = User::WhereNotIn('id', $data)->get();

        foreach ($frs as $user) {
            $user->displayName = $user->displayName;
            $user->renameAvatarUserFromUser();
        }
        return response()->json($frs, 200);
    }

    public function fetchListFriendByUser($userId, $limit = null)
    {

        if ($limit != null) {
            $lstFriend = FriendShip::Where('status', 1)->Where(function ($query) use ($userId) {
                $query->Where('user_accept', $userId)->orWhere('user_request', $userId)->get();
            })->orderBy('created_at', 'DESC')->limit(6)->get();


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
        } else {
            $lstFriend = FriendShip::Where('status', 1)->Where(function ($query) use ($userId) {
                $query->Where('user_accept', $userId)->orWhere('user_request', $userId)->get();
            })->orderBy('created_at', 'DESC')->paginate(10);

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
        $this->_createNotification($invite);
        return response()->json('success', 200);
    }

    public function fetchFriendRequestList($userId)
    {
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
        $this->_createNotification($invite);
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
    //* TỪ CHỐI LỜI MỜI KẾT BẠN
    public function denyFriendRequest(Request $request)
    {
        $userIdUnfr = JWTAuth::toUser($request->token)->id;
        $search1 = FriendShip::WHERE('user_request', $request->userId)->WHERE('user_accept', $userIdUnfr)->first();

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
                    $users->renameAvatarUserFromUser();
                    $fr->avatar = $users->avatar;
                }
            }
        }
        return response()->json($lstFriend, 200);
    }
}

trait FriendTrait
{
    private function _createNotification(FriendShip $invitation): void
    {
        $new = new Notification();
        $new->from = $invitation->status == 0 ? $invitation->user_request : $invitation->user_accept;
        $new->to = $invitation->status == 0 ? $invitation->user_accept : $invitation->user_request;
        $new->title = $invitation->status == 0 ? 'đã gửi cho bạn lời mời kết bạn.' : 'đã chấp nhận yêu cầu kết bạn.';
        $new->unread = 1;
        $new->object_type = $invitation->status == 0 ? 'FrInvitation' : 'FrAccept';
        $new->object_id = $invitation->id;
        $new->icon_url = 'icon.png';
        $new->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $new->save();
        $new->userNameFrom = $new->user->displayName;
        $new->userAvatarFrom = $new->user->avatar === null ?
            ($new->user->sex === 0 ?
                URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')
            ) : URL::to('media_file_post/' . $new->user->id . '/' . $new->user->avatar);
        event(new NotificationEvent($new->toArray()));
    }
}