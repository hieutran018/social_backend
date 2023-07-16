<?php

namespace App\Http\Controllers;

use App\Events\HaveMessageEvent;
use App\Events\MessageEvent;
use App\Models\Conversation;
use App\Models\FriendShip;
use App\Models\MediaFileMessage;
use App\Models\Message;
use App\Models\Participant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class ChatController extends Controller
{

    public function fetchChats(Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        // $chats = Conversation::Where(function ($query) use ($userCurrent) {
        //     $query->Where('user_one', $userCurrent)->orWhere('user_two', $userCurrent)->get();
        // })->orderBy('created_at', 'DESC')->get();

        $conversationRoom = Participant::Where('user_id', $userCurrent)->select('conversation_id')->get();
        $data = [];
        foreach ($conversationRoom as $conversation) {
            $data[] = $conversation->conversation_id;
        }

        $chats = Conversation::WhereIn('id', $data)->orderBy('created_at', 'DESC')->get();
        foreach ($chats as $chat) {
            if ($chat->conversation_type === 0) {
                foreach ($chat->paticipaints as $paticipaint) {
                    if ($userCurrent != $paticipaint->user->id) {
                        $chat->conversation_name = $paticipaint->user->displayName;
                        $chat->conversation_avatar =
                            $paticipaint->user->avatar === null ?
                            ($paticipaint->user->sex == 0 ?
                                URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                            URL::to('media_file_post/' . $paticipaint->user->id . '/' . $paticipaint->user->avatar);
                    }
                }
            } else {
                $chat->conversation_name = $chat->conversation_name == null ? 'Nhóm chat chưa đặt tên' : $chat->conversation_name;
                $chat->conversation_avatar = URL::to('default/avatar_chat_group_default.jpg');
            }
        }

        return response()->json($chats, 200);
    }

    public function sendMessage(Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        $newMessage = new Message();
        $newMessage->user_id = $userCurrent;
        $newMessage->conversation_id = $request->conversationId;
        $newMessage->content = $request->contentMessage;
        $newMessage->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newMessage->save();

        $newMessage->userName = $newMessage->user->displayName;
        $newMessage->avatar =
            $newMessage->user->avatar === null ?
            ($newMessage->user->sex === 0 ?
                URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
            URL::to('media_file_post/' . $newMessage->user->id . '/' . $newMessage->user->avatar);
        foreach ($newMessage->mediaFile as $file) {
            $file->media_file_name = URL::to('media_file_message/' . $file->media_file_name);
        }
        event(new MessageEvent($newMessage->toArray()));
        $paticipants = Participant::Where('conversation_id', $request->conversationId)->get();
        foreach ($paticipants as $paticipant) {
            if ($paticipant->user_id != $userCurrent) {
                event(new HaveMessageEvent($paticipant->user_id));
            }
        }
        return response()->json($newMessage, 200);
    }

    public function sendMessageHaveMediaFile(Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        $newMessage = new Message();
        $newMessage->user_id = $userCurrent;
        $newMessage->conversation_id = $request->conversationId;
        $newMessage->content = $request->contentMessage;
        $newMessage->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newMessage->save();

        //* Upload Files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time() . $random . '.' . $fileExtentsion;
                $file->move('media_file_message/', $fileName);

                $media = new MediaFileMessage();
                $media->media_file_name = $fileName;
                $media->media_type = $fileExtentsion;
                $media->message_id = $newMessage->id;
                $media->conversation_id = $request->conversationId;
                $media->user_id = JWTAuth::toUser($request->token)->id;
                $media->created_at = Carbon::now("Asia/Ho_Chi_Minh");
                $media->save();
            }
        }

        $newMessage->userName = $newMessage->user->displayName;
        $newMessage->avatar =
            $newMessage->user->avatar === null ?
            ($newMessage->user->sex == 0 ?
                URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
            URL::to('media_file_post/' . $newMessage->user->id . '/' . $newMessage->user->avatar);
        foreach ($newMessage->mediaFile as $file) {
            $file->media_file_name = URL::to('media_file_message/' . $file->media_file_name);
        }
        event(new MessageEvent($newMessage->toArray()));
        return response()->json($newMessage, 200);
    }

    public function fetchMessage(Request $request, $userId)
    {
        $userCurrent = JWTAuth::touser($request->token)->id;

        $conversation = Conversation::Where('id', $userId)->orderBy('created_at', 'DESC')->first();

        if (!empty($conversation)) {
            if ($conversation->conversation_type == 0) {
                foreach ($conversation->paticipaints as $paticipaint) {
                    if ($userCurrent != $paticipaint->user->id) {
                        $conversation->conversation_name = $paticipaint->user->displayName;
                        $conversation->userId = $paticipaint->user->id;
                        $conversation->conversation_avatar =
                            $paticipaint->user->avatar === null ?
                            ($paticipaint->user->sex == 0 ?
                                URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                            URL::to('media_file_post/' . $paticipaint->user->id . '/' . $paticipaint->user->avatar);
                    }
                }
            } else {
                $conversation->conversation_name = $conversation->conversation_name == null ? 'Nhóm chat chưa đặt tên' : $conversation->conversation_name;
                $conversation->conversation_avatar = URL::to('default/avatar_chat_group_default.jpg');
            }
            $messages = Message::Where('conversation_id', $userId)->orderBy('created_at', 'DESC')->get();

            foreach ($messages as $message) {
                $message->userName = $message->user->displayName;
                $message->avatar =
                    $message->user->avatar === null ?
                    ($message->user->sex === 0 ?
                        URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $message->user->id . '/' . $message->user->avatar);
                foreach ($message->mediaFile as $file) {
                    $file->media_file_name = URL::to('media_file_message/' . $file->media_file_name);
                }
            }
            return response()->json(['conversation' => $conversation, 'message' => $messages], 200);
        } else {
            $user = User::find($userId);
            if (!empty($user)) {
                $newConversation = new Conversation();
                $newConversation->conversation_type = 0;  //? chat 1 - 1
                $newConversation->user_one = $userCurrent;
                $newConversation->user_two = $userId;
                $newConversation->save();
                return response()->json($newConversation, 200);
            } else {
                return response()->json('Không tồn tại người dùng này', 200);
            }
        }
    }

    public function isChatOneToOne(Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        $userId = $request->userId;
        $isConversation = Conversation::where(function ($query) use ($userCurrent, $userId) {
            $query->where('user_one', $userCurrent)->where('user_two', $userId);
        })->orWhere(function ($query) use ($userCurrent, $userId) {
            $query->where('user_one', $userId)->where('user_two', $userCurrent);
        })->first();

        if ($isConversation) {
            return response()->json($isConversation, 200);
        } else {
            //? Chưa từng có đoạn chat thì tạo một room mới -> tạo tin nhắn
            $newConversation = new Conversation();
            $newConversation->conversation_type = 0;  //? chat 1 - 1
            $newConversation->user_one = $userCurrent;
            $newConversation->user_two = $request->userId;
            $newConversation->save();

            $paticipaint = new Participant();
            $paticipaint->conversation_id = $newConversation->id;
            $paticipaint->user_id = $userId;
            $paticipaint->save();

            $paticipaint = new Participant();
            $paticipaint->conversation_id = $newConversation->id;
            $paticipaint->user_id = $userCurrent;
            $paticipaint->save();
            return response()->json($newConversation, 200);
        }
    }

    public function chatOneToOne(Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        $userId = $request->userId;

        //? kiểm tra đã có đoạn chat trước đó hay chưa
        $isConversation = Conversation::where(function ($query) use ($userCurrent, $userId) {
            $query->where('user_one', $userCurrent)->where('user_two', $userId);
        })->orWhere(function ($query) use ($userCurrent, $userId) {
            $query->where('user_one', $userId)->where('user_two', $userCurrent);
        })->first();
        if ($isConversation) {
            //? Đã có đoạn chat trước dó thì tạo tin nhắn
            $newMessage = new Message();
            $newMessage->user_id = $userCurrent;
            $newMessage->conversation_id = $isConversation->id;
            $newMessage->content = $request->contentMessage;
            $newMessage->save();
        } else {
            //? Chưa từng có đoạn chat thì tạo một room mới -> tạo tin nhắn
            $newConversation = new Conversation();
            $newConversation->conversation_type = 0;  //? chat 1 - 1
            $newConversation->user_one = $userCurrent;
            $newConversation->user_two = $request->userId;
            $newConversation->save();

            if ($request->contentMessage !== null) {
                $newMessage = new Message();
                $newMessage->user_id = $userCurrent;
                $newMessage->conversation_id = $newConversation->id;
                $newMessage->content = $request->contentMessage;
                $newMessage->save();
            }
        }
        return response()->json('success', 200);
    }

    public function findFriend(Request $request, $input)
    {
        $userId = JWTAuth::toUser($request->token)->id;
        $friends = FriendShip::Where('status', 1)->Where(function ($query) use ($userId) {
            $query->Where('user_accept', $userId)->orWhere('user_request', $userId)->get();
        })->get();
        foreach ($friends as $fr) {
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

        $result = $friends->filter(function ($friend) use ($input) {
            return stripos($friend['displayName'], $input) !== false;
        });
        $resultArray = $result->values()->all();
        return response()->json($resultArray, 200);
    }

    public function createGroupChat(Request $request)
    {
        $userId = JWTAuth::toUser($request->token)->id;


        if (count($request->members) > 1) {
            $conversation = new Conversation();
            $conversation->conversation_type = 1; //? Chat nhóm
            $conversation->save();
        } else {
            $userTwo = $request->members[0];
            $isConversation = Conversation::where(function ($query) use ($userId, $userTwo) {
                $query->where('user_one', $userId)->where('user_two', $userTwo);
            })->orWhere(function ($query) use ($userId, $userTwo) {
                $query->where('user_one', $userTwo)->where('user_two', $userId);
            })->first();

            if (!$isConversation) {
                $conversation = new Conversation();
                $conversation->conversation_type = 0;
                $conversation->user_one = $userId;
                $conversation->user_two = $request->members[0];
                $conversation->save();
            } else {
                if ($request->contentMessage !== null) {
                    $newMessage = new Message();
                    $newMessage->user_id = $userId;
                    $newMessage->conversation_id = $isConversation->id;
                    $newMessage->content = $request->contentMessage;
                    $newMessage->save();
                }
                return response($isConversation, 200);
            }
        }



        $paticipaint = new Participant();
        $paticipaint->conversation_id = $conversation->id;
        $paticipaint->user_id = $userId;
        $paticipaint->save();
        foreach ($request->members as $member) {
            $paticipaint = new Participant();
            $paticipaint->conversation_id = $conversation->id;
            $paticipaint->user_id = $member;
            $paticipaint->save();
        }

        if ($request->contentMessage !== null) {
            $newMessage = new Message();
            $newMessage->user_id = $userId;
            $newMessage->conversation_id = $conversation->id;
            $newMessage->content = $request->contentMessage;
            $newMessage->save();
        }
        if ($conversation->conversation_type === 0) {
            foreach ($conversation->paticipaints as $paticipaint) {
                if ($userId != $paticipaint->user->id) {
                    $conversation->conversation_name = $paticipaint->user->displayName;
                    $conversation->conversation_avatar =
                        $paticipaint->user->avatar === null ?
                        ($paticipaint->user->sex == 0 ?
                            URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                        URL::to('media_file_post/' . $paticipaint->user->id . '/' . $paticipaint->user->avatar);
                }
            }
        } else {
            $conversation->conversation_name = $conversation->conversation_name == null ? 'Nhóm chat chưa đặt tên' : $conversation->conversation_name;
            $conversation->conversation_avatar = URL::to('default/avatar_chat_group_default.jpg');
        }
        return response($conversation, 200);
    }
    //Lấy tất cả file thuộc phòng trò chuyện
    public function fetchFileMessage($conversationId)
    {
        $files = MediaFileMessage::Where('conversation_id', $conversationId)->get();
        foreach ($files as $file) {
            $file->media_file_name = URL::to('media_file_message/' . $file->media_file_name);
        }
        return response()->json($files, 200);
    }

    //* ĐỔI TÊN NHÓM CHAT
    public function updateNameGroupChat(Request $request)
    {
        $conversation = Conversation::Where('id', $request->conversationId)->first();
        $conversation->conversation_name = $request->conversationName;
        $conversation->update();
        $conversation->conversation_avatar = URL::to('default/avatar_chat_group_default.jpg');
        return response()->json($conversation, 200);
    }

    //* LẤY TẤT CẢ THÀNH VIÊN TRONG PHÒNG TRÒ CHUYỆN
    public function fetchPaticipants($conversationId)
    {
        $paticipants = Participant::Where('conversation_id', $conversationId)->get();
        foreach ($paticipants as $paticipant) {
            $paticipant->userId = $paticipant->user->id;
            $paticipant->displayName = $paticipant->user->displayName;
            $paticipant->avatar =
                $paticipant->user->avatar === null ?
                ($paticipant->user->sex === 0 ?
                    URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                URL::to('media_file_post/' . $paticipant->user->id . '/' . $paticipant->user->avatar);
        }
        return response()->json($paticipants, 200);
    }
}
