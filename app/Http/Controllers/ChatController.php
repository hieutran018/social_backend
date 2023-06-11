<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChatController extends Controller
{

    public function fetchChats(Request $request)
    {
        $userCurrent = JWTAuth::toUser($request->token)->id;
        $chats = Conversation::Where(function ($query) use ($userCurrent) {
            $query->Where('user_one', $userCurrent)->orWhere('user_two', $userCurrent)->get();
        })->orderBy('created_at', 'DESC')->get();

        foreach ($chats as $chat) {
            if ($userCurrent === $chat->user_one) {
                $chat->conversation_name = $chat->userTwo->displayName;
                $chat->conversation_avatar = $chat->userTwo->avatar === null ?
                    ($chat->userTwo->sex === 0 ?
                        URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $chat->userTwo->id . '/' . $chat->userTwo->avatar);
                $chat->userId = $chat->userTwo->id;
            } else {
                $chat->conversation_name = $chat->userOne->displayName;
                $chat->conversation_avatar = $chat->userOne->avatar === null ?
                    ($chat->userOne->sex === 0 ?
                        URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $chat->userOne->id . '/' . $chat->userOne->avatar);
                $chat->userId = $chat->userOne->id;
            }
        }

        return response()->json($chats, 200);
    }

    public function fetchMessage(Request $request, $userId)
    {
        $userCurrent = JWTAuth::touser($request->token)->id;
        $conversation = Conversation::where(function ($query) use ($userCurrent, $userId) {
            $query->where('user_one', $userCurrent)->where('user_two', $userId);
        })->orWhere(function ($query) use ($userCurrent, $userId) {
            $query->where('user_one', $userId)->where('user_two', $userCurrent);
        })->first();
        if ($conversation) {
            if ($userCurrent === $conversation->user_one) {
                $conversation->conversation_name = $conversation->userTwo->displayName;
                $conversation->conversation_avatar = $conversation->userTwo->avatar === null ?
                    ($conversation->userTwo->sex === 0 ?
                        URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $conversation->userTwo->id . '/' . $conversation->userTwo->avatar);
                $conversation->userId = $conversation->userTwo->id;
            } else {
                $conversation->conversation_name = $conversation->userOne->displayName;
                $conversation->conversation_avatar = $conversation->userOne->avatar === null ?
                    ($conversation->userOne->sex === 0 ?
                        URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $conversation->userOne->id . '/' . $conversation->userOne->avatar);
                $conversation->userId = $conversation->userTwo->id;
            }
            $messages = Message::Where('conversation_id', $conversation->id)->get();
            foreach ($messages as $message) {
                $message->userName = $message->user->displayName;
                $message->avatar =
                    $message->user->avatar === null ?
                    ($message->user->sex === 0 ?
                        URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')) :
                    URL::to('media_file_post/' . $message->user->id . '/' . $message->user->avatar);
            }
            return response()->json(['conversation' => $conversation, 'message' => $messages], 200);
        } else {
            $newConversation = new Conversation();
            $newConversation->conversation_type = 0;  //? chat 1 - 1
            $newConversation->user_one = $userCurrent;
            $newConversation->user_two = $userId;
            $newConversation->save();
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
}
