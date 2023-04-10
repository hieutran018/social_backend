<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\FriendShip; //TODO: SAU KHI CÓ DỮ LIỆU THAY BẰNG MODEL FRIENDSHIP
use URL;
use JWTAuth;
use Carbon\Carbon;
use DB;

class FriendShipController extends Controller
{
    //TODO: SAU KHI CÓ DỮ LIỆU THÊM ID CỦA NGƯỜI HIỆN TẠI
    public function fetchFriendSuggestion(Request $request){
        $frs = User::WHERE('id','!=',JWTAuth::toUser($request->token)->id)->get();
       
        foreach($frs as $user){
            $user->username = $user->first_name.''.$user->last_name;
            $user->avatar = $user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('media_file_post/'.$user->id.'/'.$user->avatar);
        }
        return response()->json($frs,200);
    }

    public function fetchListFriendByUser($userId,$limit = null){
        
        if($limit != null){
            $lstFriend = FriendShip::WHERE('status',1)->WHERE('user_accept',$userId)->orWhere('user_request',$userId)->orderBy('created_at','DESC')->limit(6)->get();
            // $lstFriend = DB::table('list_friend')
            //     ->select('*')
            //     ->where('status','=','1')
            //     ->Where(function($query){
            //             $query->where('user_accept','=',$userId)
            //             ->orWhere('user_request','=',$userId);
            //     })->orderBy('created_at','DESC')->limit(6)->get();

        foreach($lstFriend as $fr){
            if($fr->user_accept == $userId){
                foreach($fr->user as $user){
                $fr->friendId = $user->id;
                $fr->username = $user->first_name.''.$user->last_name;
                $fr->avatar = $user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$user->id.'/'.$user->avatar);
                }
            }else{
                foreach($fr->users as $users){
                $fr->friendId = $users->id;
                $fr->username = $users->first_name.''.$users->last_name;
                $fr->avatar = $users->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('media_file_post/'.$users->id.'/'.$users->avatar);
                }
            }   
        }
        }else{
            $lstFriend = FriendShip::WHERE('status',1)->WHERE('user_accept',$userId)->orWhere('user_request',$userId)->orderBy('created_at','DESC')->get();

        foreach($lstFriend as $fr){
            if($fr->user_accept == $userId){
                foreach($fr->user as $user){
                $fr->friendId = $user->id;
                $fr->username = $user->first_name.''.$user->last_name;
                $fr->avatar = $user->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('user/person/'.$user->id.'/'.$user->avatar);
                }
            }else{
                foreach($fr->users as $users){
                $fr->friendId = $users->id;
                $fr->username = $users->first_name.''.$users->last_name;
                $fr->avatar = $users->avatar == null ? 
                            URL::to('default/avatar_default_male.png'):
                            URL::to('media_file_post/'.$users->id.'/'.$users->avatar);
                }
            }
            
            
            
        }
        }
        
        return response()->json($lstFriend,200);
    }

    public function requestAddFriend(Request $request){
        $userIdRequest = JWTAuth::toUser($request->token)->id;

        $invite = new FriendShip();

        $invite->user_request = $userIdRequest;
        $invite->user_accept = $request->userIdAccept;
        $invite->status = 0;
        $invite->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $invite->save();
        return response()->json('success',200);
        
    }

    public function fetchFriendRequestList(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;
        $requestList = FriendShip::WHERE('user_accept',$userId)->WHERE('status',0)->get();
       
        foreach($requestList as $fr){
           foreach($fr->user as $user){
            $fr->username = $user->first_name.''.$user->last_name;
            $fr->avatar = $user->avatar == null ? 
                            ($user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
                            URL::to('media_file_post/'.$user->id.'/'.$user->avatar);
            $fr->cover_image = $user->cover_image == null ? URL::to('default/cover_image_default.jpeg') : URL::to('user/person/'.$user->id.'/'.$user->cover_image);
           }
            
           
        }
        return response()->json($requestList,200);

    }

    public function acceptFriendRequest(Request $request){
        $userIdAccept = JWTAuth::toUser($request->token)->id;
        $userIdRequest = $request->userIdRequest;

        $invite = FriendShip::WHERE('user_accept',$userIdAccept)->WHERE('user_request',$userIdRequest)->first();

        $invite->status = 1; 
        $invite->update();
        return response()->json('success',200);
    }

    public function unFriend(Request $request){
        $userIdUnfr = JWTAuth::toUser($request->token)->id;
        $search1 = FriendShip::WHERE('user_request',$userIdUnfr)->WHERE('user_accept',$request->userId)->first();
       
        if($search1){
            $search1->delete();
        }
        else{

            $search1 = FriendShip::WHERE('user_request',$request->userId)->WHERE('user_accept',$userIdUnfr)->first();
           
            $search1->delete();
        }


        return response()->json('success',200);
    }
}