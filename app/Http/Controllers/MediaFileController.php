<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use URL;

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

    
}