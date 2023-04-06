<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\MediaFilePost;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use URL;
use DB;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function profileUser(Request $request){
        $profile = User::find($request->userId);
        $profile->username = $profile->first_name.' '.$profile->last_name;
        $profile->avatar = $profile->avatar == null ? 
                            ($profile->sex === 0 ? URL::to('default/avatar_default_female.png') :URL::to('default/avatar_default_male.png'))
                            :
                            URL::to('media_file_post/'.$profile->id.'/'.$profile->avatar);
        $profile->coverImage = $profile->cover_image == null ? 
                            URL::to('default/cover_image_default.jpeg'):
                            URL::to('user/person/'.$profile->id.'/'.$profile->cover_image);
        
        return response()->json($profile,200);
    }

    public function editUserInformation(Request $request){
        $validator = Validator::make($request->all(), [
            // 'firstName' => 'required|string|between:2,100',
            // 'lastName' => 'required|string|between:2,100',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = JWTAuth::toUser($request->token)->id;

        $user = User::find($userId);

        $data = $request->all();

        $user->live_in = $data['liveIn'];
        $user->went_to = $data['wentTo'];
        $user->relationship = $data['relationship'];
        $user->phone = $data['phone'];
        $user->update();
        $user->username = $user->first_name.' '.$user->last_name;
        $user->avatar = $user->avatar == null ? 
                            ($user->sex === 0 ? URL::to('default/avatar_default_female.png') :URL::to('default/avatar_default_male.png'))
                            :
                            URL::to('media_file_post/'.$user->id.'/'.$user->avatar);
        $user->coverImage = $user->cover_image == null ? 
                            URL::to('default/cover_image_default.jpeg'):
                            URL::to('user/person/'.$user->id.'/'.$user->cover_image);
        
        return response()->json($user,200);

    }
    //TODO: CẬP NHẬT ẢNH ĐẠI DIỆN
    public function updateAvatarUser(){
        
    }

    public function fetchlistImageUploaded($userId){
        $lst = DB::table('media_file_posts')
                ->select('*')
                ->where('user_id','=',$userId)
                ->Where(function($query){
                        $query->where('media_type','=','png')
                        ->orWhere('media_type','=','jpg')
                        ->orWhere('media_type','=','jpeg');
                })->get();
                
        foreach($lst as $item){
            $item->media_file_name = URL::to('media_file_post/'.$userId.'/'.$item->media_file_name);
        }
        return response()->json($lst,200);  
    }

    public function uploadAvatar(Request $request){
        $userId = JWTAuth::toUser($request->token)->id;
        if($request->hasFile('file')){
        $file = $request->file[0];
        $fileExtentsion = $file->getClientOriginalExtension();
                $random = Str::random(10);
                $fileName = time().$random.'.'.$fileExtentsion;
                $file->move('media_file_post/'.JWTAuth::toUser($request->token)->id, $fileName);
                
        $update = User::find($userId);
        $update->avatar = $fileName;
        $update->update();

        $crPost = new Post();
        $crPost->user_id = $userId;
        $crPost->post_content = 'Đã cập nhật ảnh đại diện.';
        $crPost->privacy = 1;
        $crPost->parent_post = null;
        $crPost->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $crPost->status = 1;
        $crPost->save();

        $upload = new MediaFilePost();
        $upload->media_file_name = $fileName;
        $upload->media_type = $fileExtentsion;
        $upload->post_id = $crPost->id;
        $upload->user_id = $userId;
        $upload->isAvatar = 1;
        $upload->status =1;
        $upload->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $upload->save();
        

        $update->username = $update->first_name.' '.$update->last_name;
        $update->avatar = $update->avatar == null ? 
                            ($update->sex === 0 ? URL::to('default/avatar_default_female.png') :URL::to('default/avatar_default_male.png'))
                            :
                            URL::to('media_file_post/'.$update->id.'/'.$update->avatar);
        $update->coverImage = $update->cover_image == null ? 
                            URL::to('default/cover_image_default.jpeg'):
                            URL::to('user/person/'.$update->id.'/'.$update->cover_image);
        return response()->json($update,200);
        }


    }
}