<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\FriendShip;
use App\Models\Stories;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use URL;

class StoriesController extends Controller
{
    use StoriesTrait;
    public function creatStroies(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $new = new Stories();
        $new->expiration_timestamp = Carbon::now("Asia/Ho_Chi_Minh");
        $new->user_id = $userId;
        $new->viewer_count = 0;
        $new->type = $request->type;
        $new->created_at = Carbon::now("Asia/Ho_Chi_Minh");
        if ($request->hasFile('file')) {
            $file = $request->file[0];
            $fileExtentsion = $file->getClientOriginalExtension();
            $random = Str::random(10);
            $fileName = time() . $random . '.' . $fileExtentsion;
            $file->move('stories/' . JWTAuth::toUser($request->token)->id, $fileName);
            $new->file_name_story = $fileName;
        }
        $new->save();
        $new->userNameForm = $new->user->displayName;
        $this->_createNotification($new);
        return response()->json($new, 200);
    }

    public function fetchStories(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;

        $friends = FriendShip::select('*')
            ->where('status', 1)
            ->Where(function ($query) use ($userId) {
                $query->where('user_request', $userId)
                    ->orWhere('user_accept', $userId);
            })->get();
        $data[] = $userId;
        foreach ($friends as $friend) {
            if ($userId === $friend->user_accept) {
                $data[] = $friend->user_request;
            } else {
                $data[] = $friend->user_accept;
            }
        }

        if ($data) {
            $groupedStories = User::with(['stories' => function ($query) {
                $query->select('id', 'expiration_timestamp', 'user_id', 'type', 'file_name_story', 'created_at', 'updated_at')->orderBy('created_at', 'DESC');
            }])->select('id', 'displayName', 'avatar', 'sex')->WhereIn('id', $data)->get();
            $stories = [];
            foreach ($groupedStories as $groupedStory) {
                if ($groupedStory->stories->count() !== 0) {
                    $stories[] = $groupedStory;
                }
            }


            foreach ($stories as $story) {
                $story->user_id = $story->id;
                $story->renameAvatarUserFromUser();
                foreach ($story->stories as $sto) {
                    $sto->displayName = $story->displayName;
                    $sto->avatar = $story->avatar;
                    $sto->file_name_story = URL::to('stories/' . $story->user_id . '/' . $sto->file_name_story);
                }
            }
            return response()->json($stories, 200);
        }
    }
}

trait StoriesTrait
{
    private function _createNotification(Stories $story): void
    {
        $data = [];
        $lstFriend = FriendShip::select('*')
            ->where('status', 1)
            ->Where(function ($query) use ($story) {
                $query->where('user_request', $story->user_id)
                    ->orWhere('user_accept', $story->user_id);
            })->get();
        foreach ($lstFriend as $friend) {
            if ($friend->user_accept == $story->user_id) {
                $data[] = $friend->user_request;
            } else {
                $data[] = $friend->user_accept;
            }
        }
        if ($data) {
            foreach ($data as $userId) {
                $noti = new Notification();
                $noti->from = $story->user_id;
                $noti->to = $userId;
                $noti->title = 'đã đăng bản tin mới.';
                $noti->unread = 1;
                $noti->object_type = 'crStory';
                $noti->object_id = $story->id;
                $noti->icon_url = 'icon.png';
                $noti->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $noti->save();

                $noti->userNameFrom = $noti->user->displayName;
                $noti->user->renameAvatarUserFromUser();
                $noti->userAvatarFrom = $noti->user->avatar;
                event(new NotificationEvent($noti->toArray()));
            }
        }
    }
}
