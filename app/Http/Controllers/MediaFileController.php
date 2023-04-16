<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaFilePost;
use DB;
use URL;
use Carbon\Carbon;

class MediaFileController extends Controller
{
    public function photoByUploaded($userId,$limit = null){
       
        if($limit != null){
            $lst = DB::table('media_file_posts')
                ->select('*')
                ->where('user_id','=',$userId)
                ->Where(function($query){
                        $query->where('media_type','=','png')
                        ->orWhere('media_type','=','jpg')
                        ->orWhere('media_type','=','jpeg');
                })->orderBy('created_at','DESC')->limit(6)->get();
        }else{
            $lst = DB::table('media_file_posts')
                ->select('*')
                ->where('user_id','=',$userId)
                ->Where(function($query){
                        $query->where('media_type','=','png')
                        ->orWhere('media_type','=','jpg')
                        ->orWhere('media_type','=','jpeg');
                })->orderBy('created_at','DESC')->get();
        }
        
        
        foreach($lst as $item){
            $item->media_file_name = URL::to('media_file_post/'.$userId.'/'.$item->media_file_name);
        }
        return response()->json($lst,200);  
    
    }

    public function fetchMediaFileVieo(Request $request,$limit = null){
        if($limit != null){
            $lst = MediaFilePost::WHERE('media_type','mp4')->limit($limit)->get();
        }else{
            $lst = MediaFilePost::WHERE('media_type','mp4')->get();
        }
        foreach($lst as $item){
            $item->created_at = Carbon::parse($item->created_at)->format('Y/m/d H:m:s');
            $item->media_file_name = URL::to('media_file_post/'.$item->user_id.'/'.$item->media_file_name);
            $item->userName = $item->user->first_name.' '.$item->user->last_name;
            $item->avatarUser =$item->user->avatar == null ? 
                            ($item->user->sex === 0 ? URL::to('default/avatar_default_female.png') : URL::to('default/avatar_default_male.png')):
                            URL::to('media_file_post/'.$item->user->id.'/'.$item->user->avatar);
        }

        return response()->json($lst,200);
    }
}